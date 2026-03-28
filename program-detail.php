<?php
require_once 'config.php';
require_once 'includes/EnhancedProgram.php';

$enhanced_program = new EnhancedProgram();

// Get program ID
$program_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$program_id) {
    header('Location: programs.php');
    exit;
}

// Get program details
$program = $enhanced_program->getById($program_id);

if (!$program) {
    header('Location: programs.php');
    exit;
}

// Get subject combinations for this program
$subject_combinations = $enhanced_program->getSubjectCombinations($program_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($program['name']); ?> - EduTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .subject-tag {
            display: inline-block;
            margin: 2px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 500;
        }
        .essential-subject {
            background-color: #dc3545;
            color: white;
        }
        .relevant-subject {
            background-color: #ffc107;
            color: #000;
        }
        .desirable-subject {
            background-color: #28a745;
            color: white;
        }
        .cutoff-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .requirement-card {
            border-left: 4px solid #007bff;
        }
        .combination-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .combination-card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-graduation-cap me-2"></i>EduTech
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php">Home</a>
                <a class="nav-link" href="institutions.php">Institutions</a>
                <a class="nav-link" href="programs.php">Programs</a>
                <a class="nav-link" href="enhanced-search.php">Enhanced Search</a>
                <a class="nav-link" href="contact.php">Contact</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="programs.php">Programs</a></li>
                <li class="breadcrumb-item active"><?php echo htmlspecialchars($program['name']); ?></li>
            </ol>
        </nav>

        <!-- Program Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h1 class="display-6 text-primary mb-3">
                                    <?php echo htmlspecialchars($program['name']); ?>
                                    <?php if ($program['program_code']): ?>
                                        <span class="badge bg-secondary ms-2"><?php echo htmlspecialchars($program['program_code']); ?></span>
                                    <?php endif; ?>
                                </h1>
                                
                                <div class="mb-3">
                                    <h4 class="text-muted">
                                        <i class="fas fa-university me-2"></i>
                                        <?php echo htmlspecialchars($program['institution_name']); ?>
                                        <small class="text-muted">(<?php echo htmlspecialchars($program['institution_short_name']); ?>)</small>
                                    </h4>
                                </div>

                                <div class="mb-3">
                                    <span class="badge bg-info fs-6 me-2"><?php echo ucfirst($program['level']); ?></span>
                                    <?php if ($program['faculty']): ?>
                                        <span class="badge bg-secondary fs-6 me-2"><?php echo htmlspecialchars($program['faculty']); ?></span>
                                    <?php endif; ?>
                                    <?php if ($program['duration']): ?>
                                        <span class="badge bg-success fs-6 me-2">
                                            <i class="fas fa-clock me-1"></i><?php echo htmlspecialchars($program['duration']); ?>
                                        </span>
                                    <?php endif; ?>
                                    <span class="badge bg-warning text-dark fs-6">
                                        <i class="fas fa-users me-1"></i><?php echo ucfirst($program['sponsorship_type']); ?> Sponsorship
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <?php if ($program['cutoff_points_2023']): ?>
                                <div class="card cutoff-card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">2023 Cut-off Points</h5>
                                        <h2 class="display-4"><?php echo $program['cutoff_points_2023']; ?></h2>
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
            <!-- Program Details -->
            <div class="col-lg-8">
                <!-- Program Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>Program Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if ($program['description']): ?>
                            <p class="lead"><?php echo nl2br(htmlspecialchars($program['description'])); ?></p>
                        <?php endif; ?>

                        <div class="row">
                            <?php if ($program['fee_estimate']): ?>
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted">Estimated Fees</h6>
                                <p class="fs-5 text-primary"><?php echo htmlspecialchars($program['fee_estimate']); ?></p>
                            </div>
                            <?php endif; ?>

                            <?php if ($program['application_fee']): ?>
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted">Application Fee</h6>
                                <p class="fs-5 text-success"><?php echo number_format($program['application_fee']); ?> UGX</p>
                            </div>
                            <?php endif; ?>
                        </div>

                        <?php if ($program['cutoff_info']): ?>
                        <div class="alert alert-info">
                            <h6><i class="fas fa-exclamation-circle me-2"></i>Entry Requirements</h6>
                            <p class="mb-0"><?php echo nl2br(htmlspecialchars($program['cutoff_info'])); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Subject Requirements -->
                <?php if ($program['essential_subjects'] || $program['relevant_subjects'] || $program['desirable_subjects']): ?>
                <div class="card mb-4 requirement-card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-book me-2"></i>Subject Requirements
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php if ($program['essential_subjects']): ?>
                            <div class="col-md-4 mb-3">
                                <h6 class="text-danger">
                                    <i class="fas fa-star me-1"></i>Essential Subjects (Weight x3)
                                </h6>
                                <p class="small text-muted">Must be passed with principal pass</p>
                                <?php 
                                $essential = explode(',', $program['essential_subjects']);
                                foreach ($essential as $subject): 
                                    $subject = trim($subject);
                                    if ($subject):
                                ?>
                                    <span class="subject-tag essential-subject"><?php echo htmlspecialchars($subject); ?></span>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </div>
                            <?php endif; ?>

                            <?php if ($program['relevant_subjects']): ?>
                            <div class="col-md-4 mb-3">
                                <h6 class="text-warning">
                                    <i class="fas fa-star-half-alt me-1"></i>Relevant Subjects (Weight x2)
                                </h6>
                                <p class="small text-muted">Supporting subjects</p>
                                <?php 
                                $relevant = explode(',', $program['relevant_subjects']);
                                foreach ($relevant as $subject): 
                                    $subject = trim($subject);
                                    if ($subject):
                                ?>
                                    <span class="subject-tag relevant-subject"><?php echo htmlspecialchars($subject); ?></span>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </div>
                            <?php endif; ?>

                            <?php if ($program['desirable_subjects']): ?>
                            <div class="col-md-4 mb-3">
                                <h6 class="text-success">
                                    <i class="fas fa-star me-1"></i>Desirable Subjects (Weight x1)
                                </h6>
                                <p class="small text-muted">Additional qualifications</p>
                                <?php 
                                $desirable = explode(',', $program['desirable_subjects']);
                                foreach ($desirable as $subject): 
                                    $subject = trim($subject);
                                    if ($subject):
                                ?>
                                    <span class="subject-tag desirable-subject"><?php echo htmlspecialchars($subject); ?></span>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Subject Combinations -->
                <?php if (!empty($subject_combinations)): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-layer-group me-2"></i>Recommended Subject Combinations
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($subject_combinations as $combination): ?>
                            <div class="col-md-6 mb-3">
                                <div class="combination-card p-3">
                                    <h6 class="text-primary">
                                        <?php if ($combination['combination_code']): ?>
                                            <?php echo htmlspecialchars($combination['combination_code']); ?>:
                                        <?php endif; ?>
                                        Subject Combination
                                    </h6>
                                    <div class="d-flex flex-wrap">
                                        <?php if ($combination['subject_1']): ?>
                                            <span class="badge bg-primary me-1 mb-1"><?php echo htmlspecialchars($combination['subject_1']); ?></span>
                                        <?php endif; ?>
                                        <?php if ($combination['subject_2']): ?>
                                            <span class="badge bg-primary me-1 mb-1"><?php echo htmlspecialchars($combination['subject_2']); ?></span>
                                        <?php endif; ?>
                                        <?php if ($combination['subject_3']): ?>
                                            <span class="badge bg-primary me-1 mb-1"><?php echo htmlspecialchars($combination['subject_3']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($combination['description']): ?>
                                        <p class="small text-muted mt-2 mb-0"><?php echo htmlspecialchars($combination['description']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Historical Cut-off Points -->
                <?php if ($program['cutoff_points_2023'] || $program['cutoff_points_2022'] || $program['cutoff_points_2021']): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-line me-2"></i>Historical Cut-off Points
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <?php if ($program['cutoff_points_2023']): ?>
                            <div class="col-md-4">
                                <div class="p-3 border rounded">
                                    <h6 class="text-muted">2023/2024</h6>
                                    <h4 class="text-primary"><?php echo $program['cutoff_points_2023']; ?></h4>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($program['cutoff_points_2022']): ?>
                            <div class="col-md-4">
                                <div class="p-3 border rounded">
                                    <h6 class="text-muted">2022/2023</h6>
                                    <h4 class="text-info"><?php echo $program['cutoff_points_2022']; ?></h4>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($program['cutoff_points_2021']): ?>
                            <div class="col-md-4">
                                <div class="p-3 border rounded">
                                    <h6 class="text-muted">2021/2022</h6>
                                    <h4 class="text-success"><?php echo $program['cutoff_points_2021']; ?></h4>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Institution Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-university me-2"></i>Institution Details
                        </h5>
                    </div>
                    <div class="card-body">
                        <h6><?php echo htmlspecialchars($program['institution_name']); ?></h6>
                        <p class="text-muted small"><?php echo htmlspecialchars($program['institution_short_name']); ?></p>
                        
                        <?php if ($program['website']): ?>
                        <p class="mb-1">
                            <i class="fas fa-globe me-2"></i>
                            <a href="http://<?php echo htmlspecialchars($program['website']); ?>" target="_blank" class="text-decoration-none">
                                <?php echo htmlspecialchars($program['website']); ?>
                            </a>
                        </p>
                        <?php endif; ?>
                        
                        <?php if ($program['contact_email']): ?>
                        <p class="mb-1">
                            <i class="fas fa-envelope me-2"></i>
                            <a href="mailto:<?php echo htmlspecialchars($program['contact_email']); ?>" class="text-decoration-none">
                                <?php echo htmlspecialchars($program['contact_email']); ?>
                            </a>
                        </p>
                        <?php endif; ?>
                        
                        <?php if ($program['phone']): ?>
                        <p class="mb-0">
                            <i class="fas fa-phone me-2"></i>
                            <a href="tel:<?php echo htmlspecialchars($program['phone']); ?>" class="text-decoration-none">
                                <?php echo htmlspecialchars($program['phone']); ?>
                            </a>
                        </p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-tools me-2"></i>Quick Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="programs.php?institution=<?php echo urlencode($program['institution_name']); ?>" 
                               class="btn btn-outline-primary">
                                <i class="fas fa-search me-2"></i>View All Programs at <?php echo htmlspecialchars($program['institution_short_name']); ?>
                            </a>
                            
                            <a href="programs.php?level=<?php echo urlencode($program['level']); ?>" 
                               class="btn btn-outline-info">
                                <i class="fas fa-filter me-2"></i>View All <?php echo ucfirst($program['level']); ?> Programs
                            </a>
                            
                            <?php if ($program['faculty']): ?>
                            <a href="programs.php?faculty=<?php echo urlencode($program['faculty']); ?>" 
                               class="btn btn-outline-secondary">
                                <i class="fas fa-graduation-cap me-2"></i>View <?php echo htmlspecialchars($program['faculty']); ?> Programs
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Related Programs -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-link me-2"></i>Related Programs
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small">Find similar programs at other institutions</p>
                        <div class="d-grid gap-2">
                            <a href="programs.php?search=<?php echo urlencode(explode(' ', $program['name'])[0]); ?>" 
                               class="btn btn-sm btn-outline-primary">
                                Search Similar Programs
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>EduTech</h5>
                    <p class="text-muted">Your gateway to higher education in Uganda</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted">&copy; 2024 EduTech. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
