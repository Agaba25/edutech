<?php
$page_title = 'Program Details';
require_once __DIR__ . '/includes/header.php';

$program_model = new Program();
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$program = $id ? $program_model->getByIdWithInstitution($id) : null;
if (!$program) {
    header('Location: programs.php');
    exit;
}

$subject_combinations = $program_model->getSubjectCombinations($id);

/**
 * @param string|null $csv "A, B, C" subject lists from DB
 * @return array<int, string>
 */
$splitSubjects = static function ($csv) {
    if ($csv === null || trim((string) $csv) === '') {
        return [];
    }
    return array_values(array_filter(array_map('trim', explode(',', $csv))));
};
?>

<style>
.subject-tag { display: inline-block; margin: 2px; padding: 6px 12px; border-radius: 20px; font-size: 0.9em; font-weight: 500; }
.essential-subject { background-color: #dc3545; color: white; }
.relevant-subject { background-color: #ffc107; color: #000; }
.desirable-subject { background-color: #28a745; color: white; }
.cutoff-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
.requirement-card { border-left: 4px solid #0d6efd; }
.combination-card { border: 1px solid #dee2e6; border-radius: 8px; transition: box-shadow 0.2s, transform 0.2s; }
.combination-card:hover { box-shadow: 0 4px 8px rgba(0,0,0,0.1); transform: translateY(-2px); }
</style>

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo Sanitizer::escape(rtrim(APP_URL, '/') . '/'); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="programs.php">Programs</a></li>
            <li class="breadcrumb-item active"><?php echo Sanitizer::escape($program['name']); ?></li>
        </ol>
    </nav>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h1 class="display-6 text-primary mb-3">
                                <?php echo Sanitizer::escape($program['name']); ?>
                                <?php if (!empty($program['program_code'])): ?>
                                    <span class="badge bg-secondary ms-2"><?php echo Sanitizer::escape($program['program_code']); ?></span>
                                <?php endif; ?>
                            </h1>
                            <div class="mb-3">
                                <h4 class="text-muted">
                                    <i class="bi bi-building me-2"></i>
                                    <?php echo Sanitizer::escape($program['institution_name']); ?>
                                    <?php if (!empty($program['institution_short_name'])): ?>
                                        <small class="text-muted">(<?php echo Sanitizer::escape($program['institution_short_name']); ?>)</small>
                                    <?php endif; ?>
                                </h4>
                            </div>
                            <div class="mb-3">
                                <span class="badge bg-info fs-6 me-2"><?php echo Sanitizer::escape(ucfirst(strtolower($program['level']))); ?></span>
                                <?php if (!empty($program['faculty'])): ?>
                                    <span class="badge bg-secondary fs-6 me-2"><?php echo Sanitizer::escape($program['faculty']); ?></span>
                                <?php endif; ?>
                                <?php if (!empty($program['duration'])): ?>
                                    <span class="badge bg-success fs-6 me-2"><i class="bi bi-clock me-1"></i><?php echo Sanitizer::escape($program['duration']); ?></span>
                                <?php endif; ?>
                                <?php if (!empty($program['sponsorship_type'])): ?>
                                    <span class="badge bg-warning text-dark fs-6"><i class="bi bi-people me-1"></i><?php echo Sanitizer::escape($program['sponsorship_type']); ?> Sponsorship</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <?php if (!empty($program['cutoff_points_2023'])): ?>
                            <div class="card cutoff-card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">2023 Cut-off Points</h5>
                                    <h2 class="display-4"><?php echo Sanitizer::escape((string) $program['cutoff_points_2023']); ?></h2>
                                    <small>Minimum Entry Points</small>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Program Information</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($program['description'])): ?>
                        <p class="lead"><?php echo nl2br(Sanitizer::escape($program['description'])); ?></p>
                    <?php endif; ?>
                    <div class="row">
                        <?php if (!empty($program['fee_estimate'])): ?>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Estimated Fees</h6>
                            <p class="fs-5 text-primary"><?php echo Sanitizer::escape($program['fee_estimate']); ?></p>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($program['application_fee'])): ?>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Application Fee</h6>
                            <p class="fs-5 text-success"><?php echo Sanitizer::escape(number_format((float) $program['application_fee'])); ?> UGX</p>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($program['cutoff_info'])): ?>
                    <div class="alert alert-info mb-0">
                        <h6><i class="bi bi-exclamation-circle me-2"></i>Entry Requirements</h6>
                        <p class="mb-0"><?php echo nl2br(Sanitizer::escape($program['cutoff_info'])); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php
            $essential = $splitSubjects($program['essential_subjects'] ?? '');
            $relevant = $splitSubjects($program['relevant_subjects'] ?? '');
            $desirable = $splitSubjects($program['desirable_subjects'] ?? '');
            ?>
            <?php if ($essential || $relevant || $desirable): ?>
            <div class="card mb-4 requirement-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-book me-2"></i>Subject Requirements</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php if ($essential): ?>
                        <div class="col-md-4 mb-3">
                            <h6 class="text-danger"><i class="bi bi-star-fill me-1"></i>Essential</h6>
                            <p class="small text-muted">Must be passed with principal pass</p>
                            <?php foreach ($essential as $subject): ?>
                                <span class="subject-tag essential-subject"><?php echo Sanitizer::escape($subject); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        <?php if ($relevant): ?>
                        <div class="col-md-4 mb-3">
                            <h6 class="text-warning"><i class="bi bi-star-half me-1"></i>Relevant</h6>
                            <p class="small text-muted">Supporting subjects</p>
                            <?php foreach ($relevant as $subject): ?>
                                <span class="subject-tag relevant-subject"><?php echo Sanitizer::escape($subject); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        <?php if ($desirable): ?>
                        <div class="col-md-4 mb-3">
                            <h6 class="text-success"><i class="bi bi-star me-1"></i>Desirable</h6>
                            <p class="small text-muted">Additional qualifications</p>
                            <?php foreach ($desirable as $subject): ?>
                                <span class="subject-tag desirable-subject"><?php echo Sanitizer::escape($subject); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if (!empty($subject_combinations)): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-layers me-2"></i>Recommended Subject Combinations</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach ($subject_combinations as $combination): ?>
                        <div class="col-md-6 mb-3">
                            <div class="combination-card p-3">
                                <h6 class="text-primary">
                                    <?php if (!empty($combination['combination_code'])): ?>
                                        <?php echo Sanitizer::escape($combination['combination_code']); ?>:
                                    <?php endif; ?>
                                    Combination
                                </h6>
                                <div class="d-flex flex-wrap gap-1">
                                    <?php foreach (['subject_1', 'subject_2', 'subject_3'] as $sk): ?>
                                        <?php if (!empty($combination[$sk])): ?>
                                            <span class="badge bg-primary"><?php echo Sanitizer::escape($combination[$sk]); ?></span>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                                <?php if (!empty($combination['description'])): ?>
                                    <p class="small text-muted mt-2 mb-0"><?php echo Sanitizer::escape($combination['description']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if (!empty($program['cutoff_points_2023']) || !empty($program['cutoff_points_2022']) || !empty($program['cutoff_points_2021'])): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Historical Cut-off Points</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <?php if (!empty($program['cutoff_points_2023'])): ?>
                        <div class="col-md-4 mb-2">
                            <div class="p-3 border rounded">
                                <h6 class="text-muted">2023/2024</h6>
                                <h4 class="text-primary"><?php echo Sanitizer::escape((string) $program['cutoff_points_2023']); ?></h4>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($program['cutoff_points_2022'])): ?>
                        <div class="col-md-4 mb-2">
                            <div class="p-3 border rounded">
                                <h6 class="text-muted">2022/2023</h6>
                                <h4 class="text-info"><?php echo Sanitizer::escape((string) $program['cutoff_points_2022']); ?></h4>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($program['cutoff_points_2021'])): ?>
                        <div class="col-md-4 mb-2">
                            <div class="p-3 border rounded">
                                <h6 class="text-muted">2021/2022</h6>
                                <h4 class="text-success"><?php echo Sanitizer::escape((string) $program['cutoff_points_2021']); ?></h4>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-building me-2"></i>Institution</h5>
                </div>
                <div class="card-body">
                    <h6><?php echo Sanitizer::escape($program['institution_name']); ?></h6>
                    <?php if (!empty($program['institution_short_name'])): ?>
                        <p class="text-muted small"><?php echo Sanitizer::escape($program['institution_short_name']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($program['website'])): ?>
                    <p class="mb-1">
                        <i class="bi bi-globe me-2"></i>
                        <a href="<?php echo Sanitizer::escape(Sanitizer::formatWebsiteUrl($program['website'])); ?>" target="_blank" rel="noopener noreferrer" class="text-decoration-none"><?php echo Sanitizer::escape($program['website']); ?></a>
                    </p>
                    <?php endif; ?>
                    <?php if (!empty($program['contact_email'])): ?>
                    <p class="mb-1">
                        <i class="bi bi-envelope me-2"></i>
                        <a href="mailto:<?php echo Sanitizer::escape($program['contact_email']); ?>" class="text-decoration-none"><?php echo Sanitizer::escape($program['contact_email']); ?></a>
                    </p>
                    <?php endif; ?>
                    <?php if (!empty($program['phone'])): ?>
                    <p class="mb-0">
                        <i class="bi bi-telephone me-2"></i>
                        <a href="tel:<?php echo Sanitizer::escape(preg_replace('/\s+/', '', $program['phone'])); ?>" class="text-decoration-none"><?php echo Sanitizer::escape($program['phone']); ?></a>
                    </p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-lightning me-2"></i>Quick actions</h5>
                </div>
                <div class="card-body d-grid gap-2">
                    <a href="institution-detail.php?id=<?php echo (int) $program['institution_id']; ?>" class="btn btn-outline-primary">
                        <i class="bi bi-building me-2"></i>View institution profile
                    </a>
                    <a href="programs.php?institution_id=<?php echo (int) $program['institution_id']; ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-list-ul me-2"></i>All programs at this institution
                    </a>
                    <a href="programs.php?level=<?php echo urlencode($program['level']); ?>" class="btn btn-outline-info">
                        <i class="bi bi-funnel me-2"></i>More <?php echo Sanitizer::escape($program['level']); ?> programs
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
