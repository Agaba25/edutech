<?php
require_once '../config.php';
require_once '../includes/Database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get input data
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

$userResults = $input['userResults'];
$userInterests = $input['userInterests'];

try {
    $db = Database::getInstance();
    
    // Fetch all courses
    $query = "SELECT * FROM courses";
    $result = $db->getConnection()->query($query);
    
    if (!$result) {
        throw new Exception("Failed to fetch courses: " . $db->getConnection()->error);
    }
    
    $courses = [];
    
    while ($row = $result->fetch_assoc()) {
        // Decode JSON fields
        $row['essential_subjects'] = json_decode($row['essential_subjects'], true) ?: [];
        $row['career_fields'] = json_decode($row['career_fields'], true) ?: [];
        $row['career_opportunities'] = json_decode($row['career_opportunities'], true) ?: [];
        
        // Calculate match score
        $matchScore = calculateCourseMatch($userResults, $userInterests, $row);
        
        if ($matchScore >= 60) {
            $row['matchScore'] = $matchScore;
            
            // Get universities offering this course
            $uniQuery = "SELECT cu.*, i.name, i.website 
                         FROM course_universities cu
                         JOIN institutions i ON cu.institution_id = i.id
                         WHERE cu.course_id = ?";
            $uniStmt = $db->getConnection()->prepare($uniQuery);
            
            if ($uniStmt) {
                $uniStmt->bind_param('i', $row['id']);
                $uniStmt->execute();
                $uniResult = $uniStmt->get_result();
                
                $row['universities'] = [];
                while ($uni = $uniResult->fetch_assoc()) {
                    $row['universities'][] = [
                        'name' => $uni['name'],
                        'application_link' => $uni['application_link'] ?: $uni['website']
                    ];
                }
                $uniStmt->close();
            } else {
                $row['universities'] = [];
            }
            
            // Get scholarships
            $schQuery = "SELECT scholarship_name, scholarship_link 
                         FROM course_scholarships 
                         WHERE course_id = ?";
            $schStmt = $db->getConnection()->prepare($schQuery);
            
            if ($schStmt) {
                $schStmt->bind_param('i', $row['id']);
                $schStmt->execute();
                $schResult = $schStmt->get_result();
                
                $row['scholarships'] = [];
                while ($sch = $schResult->fetch_assoc()) {
                    $row['scholarships'][] = [
                        'scholarship_name' => $sch['scholarship_name'],
                        'scholarship_link' => $sch['scholarship_link']
                    ];
                }
                $schStmt->close();
            } else {
                $row['scholarships'] = [];
            }
            
            $courses[] = $row;
        }
    }
    
    // Sort by match score (highest first)
    usort($courses, function($a, $b) {
        return $b['matchScore'] - $a['matchScore'];
    });
    
    echo json_encode([
        'success' => true,
        'courses' => $courses
    ]);
    
} catch (Exception $e) {
    error_log("Course matching error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'An error occurred while processing your request. Please try again.'
    ]);
}

function calculateCourseMatch($userResults, $userInterests, $course) {
    $matchScore = 0;
    
    // Get user subjects and grades
    $userSubjects = [
        ['subject' => $userResults['principal1']['subject'], 'grade' => $userResults['principal1']['grade'], 'points' => $userResults['principal1']['points']],
        ['subject' => $userResults['principal2']['subject'], 'grade' => $userResults['principal2']['grade'], 'points' => $userResults['principal2']['points']],
        ['subject' => $userResults['principal3']['subject'], 'grade' => $userResults['principal3']['grade'], 'points' => $userResults['principal3']['points']]
    ];
    
    // Get course subject requirements
    $essentialSubjects = $course['essential_subjects'];
    $relevantSubjects = json_decode($course['relevant_subjects'] ?? '[]', true);
    $desirableSubjects = json_decode($course['desirable_subjects'] ?? '[]', true);
    
    // Calculate weighted points using A-Level weighting system
    // Essential Subjects: x3, Relevant Subjects: x2, Desirable: x1
    $weightedPoints = 0;
    $essentialMatches = 0;
    $essentialPoints = 0;
    
    // Check Essential subjects (x3 weight)
    foreach ($userSubjects as $userSubj) {
        foreach ($essentialSubjects as $essential) {
            if ($userSubj['subject'] === $essential && $userSubj['grade'] !== 'F' && $userSubj['grade'] !== 'O') {
                $weightedPoints += $userSubj['points'] * 3;
                $essentialMatches++;
                $essentialPoints += $userSubj['points'];
                break;
            }
        }
    }
    
    // Must have at least one Essential subject passed (Principal Pass A-E)
    if ($essentialMatches === 0) {
        return 0; // No match if no essential subjects
    }
    
    // Check Relevant subjects (x2 weight) - can also count if not already in essential
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
    
    // Check Desirable subjects (x1 weight)
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
    
    // Add General Paper (x1 if Pass)
    if ($userResults['generalPaper'] === 'Pass') {
        $weightedPoints += 1;
    }
    
    // Add Subsidiary (x1 if Pass)
    if ($userResults['subsidiary'] === 'Pass') {
        $weightedPoints += 1;
    }
    
    // Check if meets minimum weighted points requirement
    if ($weightedPoints < $course['minimum_points']) {
        return 0;
    }
    
    // Calculate match score based on multiple factors
    
    // 1. Essential subjects matching (40% weight)
    $essentialMatchRatio = $essentialMatches / max(count($essentialSubjects), 1);
    $matchScore += $essentialMatchRatio * 40;
    
    // 2. Interest alignment (25% weight)
    $interestMatches = 0;
    if (!empty($course['career_fields'])) {
        foreach ($course['career_fields'] as $field) {
            if (in_array($field, $userInterests)) {
                $interestMatches++;
            }
        }
    }
    $interestMatchRatio = count($userInterests) > 0 ? $interestMatches / count($userInterests) : 0;
    $matchScore += $interestMatchRatio * 25;
    
    // 3. Weighted points surplus (20% weight) 
    $pointsSurplus = max(0, $weightedPoints - $course['minimum_points']);
    $matchScore += min(($pointsSurplus / 10) * 20, 20);
    
    // 4. Total subject matches (15% weight)
    $totalMatches = $essentialMatches + $relevantMatches + $desirableMatches;
    $matchScore += min(($totalMatches / 3) * 15, 15);
    
    return round($matchScore);
}
?>