<?php
require_once __DIR__ . '/../config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || empty($input['userResults']) || empty($input['userInterests'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

$userResults = $input['userResults'];
$userInterests = $input['userInterests'];

try {
    $db = Database::getInstance();
    $rows = $db->fetchAll('SELECT * FROM courses');

    $courses = [];

    foreach ($rows as $row) {
        $row['essential_subjects'] = json_decode($row['essential_subjects'], true) ?: [];
        $row['career_fields'] = json_decode($row['career_fields'], true) ?: [];
        $row['career_opportunities'] = json_decode($row['career_opportunities'], true) ?: [];

        $matchScore = calculateCourseMatchApi($userResults, $userInterests, $row);

        if ($matchScore >= 60) {
            $row['matchScore'] = $matchScore;

            $uniRows = $db->fetchAll(
                'SELECT cu.*, i.name, i.website FROM course_universities cu
                 INNER JOIN institutions i ON cu.institution_id = i.id
                 WHERE cu.course_id = ?',
                [$row['id']]
            );

            $row['universities'] = [];
            foreach ($uniRows as $uni) {
                $row['universities'][] = [
                    'name' => $uni['name'],
                    'application_link' => $uni['application_link'] ?: $uni['website'],
                ];
            }

            $schRows = $db->fetchAll(
                'SELECT scholarship_name, scholarship_link FROM course_scholarships WHERE course_id = ?',
                [$row['id']]
            );

            $row['scholarships'] = [];
            foreach ($schRows as $sch) {
                $row['scholarships'][] = [
                    'scholarship_name' => $sch['scholarship_name'],
                    'scholarship_link' => $sch['scholarship_link'],
                ];
            }

            $courses[] = $row;
        }
    }

    usort($courses, static function ($a, $b) {
        return ($b['matchScore'] ?? 0) <=> ($a['matchScore'] ?? 0);
    });

    echo json_encode([
        'success' => true,
        'courses' => $courses,
    ]);
} catch (Throwable $e) {
    error_log('Course matching error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred while processing your request. Please try again.',
    ]);
}

/**
 * @param array $userResults
 * @param array $userInterests
 * @param array $course
 */
function calculateCourseMatchApi($userResults, $userInterests, $course) {
    $matchScore = 0;

    $userSubjects = [
        ['subject' => $userResults['principal1']['subject'], 'grade' => $userResults['principal1']['grade'], 'points' => $userResults['principal1']['points']],
        ['subject' => $userResults['principal2']['subject'], 'grade' => $userResults['principal2']['grade'], 'points' => $userResults['principal2']['points']],
        ['subject' => $userResults['principal3']['subject'], 'grade' => $userResults['principal3']['grade'], 'points' => $userResults['principal3']['points']],
    ];

    $essentialSubjects = $course['essential_subjects'];
    $relevantSubjects = json_decode($course['relevant_subjects'] ?? '[]', true);
    if (!is_array($relevantSubjects)) {
        $relevantSubjects = [];
    }
    $desirableSubjects = json_decode($course['desirable_subjects'] ?? '[]', true);
    if (!is_array($desirableSubjects)) {
        $desirableSubjects = [];
    }

    $weightedPoints = 0;
    $essentialMatches = 0;

    foreach ($userSubjects as $userSubj) {
        foreach ($essentialSubjects as $essential) {
            if ($userSubj['subject'] === $essential && $userSubj['grade'] !== 'F' && $userSubj['grade'] !== 'O') {
                $weightedPoints += $userSubj['points'] * 3;
                $essentialMatches++;
                break;
            }
        }
    }

    if ($essentialMatches === 0) {
        return 0;
    }

    $relevantMatches = 0;
    foreach ($userSubjects as $userSubj) {
        $alreadyCounted = false;
        foreach ($essentialSubjects as $essential) {
            if ($userSubj['subject'] === $essential) {
                $alreadyCounted = true;
                break;
            }
        }

        if (!$alreadyCounted) {
            foreach ($relevantSubjects as $relevant) {
                if ($userSubj['subject'] === $relevant && $userSubj['grade'] !== 'F') {
                    $weightedPoints += $userSubj['points'] * 2;
                    $relevantMatches++;
                    break;
                }
            }
        }
    }

    $desirableMatches = 0;
    foreach ($userSubjects as $userSubj) {
        $alreadyCounted = false;
        foreach ($essentialSubjects as $essential) {
            if ($userSubj['subject'] === $essential) {
                $alreadyCounted = true;
                break;
            }
        }
        if (!$alreadyCounted) {
            foreach ($relevantSubjects as $relevant) {
                if ($userSubj['subject'] === $relevant) {
                    $alreadyCounted = true;
                    break;
                }
            }
        }

        if (!$alreadyCounted) {
            foreach ($desirableSubjects as $desirable) {
                if ($userSubj['subject'] === $desirable && $userSubj['grade'] !== 'F') {
                    $weightedPoints += $userSubj['points'] * 1;
                    $desirableMatches++;
                    break;
                }
            }
        }
    }

    if (($userResults['generalPaper'] ?? '') === 'Pass') {
        $weightedPoints += 1;
    }

    if (($userResults['subsidiary'] ?? '') === 'Pass') {
        $weightedPoints += 1;
    }

    $minPoints = (int) ($course['minimum_points'] ?? 0);
    if ($weightedPoints < $minPoints) {
        return 0;
    }

    $essentialMatchRatio = $essentialMatches / max(count($essentialSubjects), 1);
    $matchScore += $essentialMatchRatio * 40;

    $interestMatches = 0;
    if (!empty($course['career_fields'])) {
        foreach ($course['career_fields'] as $field) {
            if (in_array($field, $userInterests, true)) {
                $interestMatches++;
            }
        }
    }
    $interestMatchRatio = count($userInterests) > 0 ? $interestMatches / count($userInterests) : 0;
    $matchScore += $interestMatchRatio * 25;

    $pointsSurplus = max(0, $weightedPoints - $minPoints);
    $matchScore += min(($pointsSurplus / 10) * 20, 20);

    $totalMatches = $essentialMatches + $relevantMatches + $desirableMatches;
    $matchScore += min(($totalMatches / 3) * 15, 15);

    return (int) round($matchScore);
}
