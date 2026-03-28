<?php
$page_title = 'Scholarship Hub';
require_once '../config.php';
require_once '../includes/header.php';
require_once '../includes/Institution.php';

$institution = new Institution();
$institutions = $institution->getAll();

// Sample scholarship data (in a real application, this would come from a database)
$scholarships = [
    [
        'title' => 'Government Scholarship Program',
        'institution' => 'Various Universities',
        'amount' => 'Full Tuition',
        'deadline' => '2026-03-15',
        'description' => 'Government-funded scholarships for outstanding students in STEM fields',
        'requirements' => 'Minimum 3.5 GPA, UACE with 15+ points',
        'category' => 'Government'
    ],
    [
        'title' => 'Mastercard Foundation Scholars Program',
        'institution' => 'Makerere University',
        'amount' => 'Full Scholarship',
        'deadline' => '2024-04-30',
        'description' => 'Comprehensive scholarship covering tuition, accommodation, and living expenses',
        'requirements' => 'Financial need, academic excellence, leadership potential',
        'category' => 'International'
    ],
    [
        'title' => 'KIU Merit Scholarship',
        'institution' => 'Kampala International University',
        'amount' => '50% Tuition',
        'deadline' => '2024-05-15',
        'description' => 'Merit-based scholarship for top-performing students',
        'requirements' => 'UACE with 18+ points, excellent academic record',
        'category' => 'Merit'
    ],
    [
        'title' => 'Women in STEM Scholarship',
        'institution' => 'Kyambogo University',
        'amount' => '75% Tuition',
        'deadline' => '2024-06-01',
        'description' => 'Scholarship specifically for female students pursuing STEM programs',
        'requirements' => 'Female student, STEM program, financial need',
        'category' => 'Gender'
    ],
    [
        'title' => 'Rural Development Scholarship',
        'institution' => 'Mbarara University of Science and Technology',
        'amount' => 'Full Tuition + Stipend',
        'deadline' => '2024-04-20',
        'description' => 'Scholarship for students from rural areas pursuing agriculture and development studies',
        'requirements' => 'Rural background, agriculture/development program',
        'category' => 'Rural'
    ],
    [
        'title' => 'Sports Excellence Scholarship',
        'institution' => 'Various Universities',
        'amount' => 'Variable',
        'deadline' => '2024-07-01',
        'description' => 'Scholarship for students with exceptional sports achievements',
        'requirements' => 'National/international sports recognition',
        'category' => 'Sports'
    ]
];
?>

<div class="container">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-4 fw-bold mb-3">Scholarship Hub</h1>
            <p class="lead text-muted mb-4">Providing you with various scholarships currently available in various universities and institutions</p>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Search Scholarships</label>
                            <input type="text" class="form-control" name="search" placeholder="Search by title or institution..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category">
                                <option value="">All Categories</option>
                                <option value="Government" <?php echo (isset($_GET['category']) && $_GET['category'] === 'Government') ? 'selected' : ''; ?>>Government</option>
                                <option value="International" <?php echo (isset($_GET['category']) && $_GET['category'] === 'International') ? 'selected' : ''; ?>>International</option>
                                <option value="Merit" <?php echo (isset($_GET['category']) && $_GET['category'] === 'Merit') ? 'selected' : ''; ?>>Merit</option>
                                <option value="Gender" <?php echo (isset($_GET['category']) && $_GET['category'] === 'Gender') ? 'selected' : ''; ?>>Gender</option>
                                <option value="Rural" <?php echo (isset($_GET['category']) && $_GET['category'] === 'Rural') ? 'selected' : ''; ?>>Rural</option>
                                <option value="Sports" <?php echo (isset($_GET['category']) && $_GET['category'] === 'Sports') ? 'selected' : ''; ?>>Sports</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Institution</label>
                            <select class="form-select" name="institution">
                                <option value="">All Institutions</option>
                                <?php foreach ($institutions as $inst): ?>
                                <option value="<?php echo htmlspecialchars($inst['name']); ?>" <?php echo (isset($_GET['institution']) && $_GET['institution'] === $inst['name']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($inst['name']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
            </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scholarship Statistics -->
    <div class="row mb-5">
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-primary"><?php echo count($scholarships); ?></h3>
                    <p class="card-text">Available Scholarships</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-success"><?php echo count($institutions); ?></h3>
                    <p class="card-text">Participating Institutions</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-warning">6</h3>
                    <p class="card-text">Scholarship Categories</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-info">500+</h3>
                    <p class="card-text">Students Helped</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scholarships List -->
    <div class="row">
        <?php
        $search = isset($_GET['search']) ? strtolower(trim($_GET['search'])) : '';
        $category = isset($_GET['category']) ? $_GET['category'] : '';
        $institution_filter = isset($_GET['institution']) ? $_GET['institution'] : '';
        
        $filteredScholarships = array_filter($scholarships, function($scholarship) use ($search, $category, $institution_filter) {
            $matchesSearch = empty($search) || 
                strpos(strtolower($scholarship['title']), $search) !== false ||
                strpos(strtolower($scholarship['institution']), $search) !== false;
            
            $matchesCategory = empty($category) || $scholarship['category'] === $category;
            $matchesInstitution = empty($institution_filter) || $scholarship['institution'] === $institution_filter;
            
            return $matchesSearch && $matchesCategory && $matchesInstitution;
        });
        
        if (empty($filteredScholarships)):
        ?>
        <div class="col-12">
            <div class="alert alert-info text-center">
                <h4>No scholarships found</h4>
                <p>Try adjusting your search criteria or check back later for new opportunities.</p>
            </div>
        </div>
        <?php else: ?>
            <?php foreach ($filteredScholarships as $scholarship): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary"><?php echo htmlspecialchars($scholarship['category']); ?></span>
                        <small class="text-muted"><?php echo date('M d, Y', strtotime($scholarship['deadline'])); ?></small>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($scholarship['title']); ?></h5>
                        <p class="card-text text-muted"><?php echo htmlspecialchars($scholarship['institution']); ?></p>
                        <p class="card-text"><?php echo htmlspecialchars($scholarship['description']); ?></p>
                        <div class="mb-3">
                            <strong>Amount:</strong> <?php echo htmlspecialchars($scholarship['amount']); ?><br>
                            <strong>Requirements:</strong> <?php echo htmlspecialchars($scholarship['requirements']); ?>
                        </div>
                        <div class="alert alert-warning small">
                            <i class="bi bi-clock"></i> Deadline: <?php echo date('F d, Y', strtotime($scholarship['deadline'])); ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary btn-sm" onclick="applyScholarship('<?php echo htmlspecialchars($scholarship['title']); ?>')">Apply Now</button>
                        <button class="btn btn-outline-secondary btn-sm ms-2" onclick="viewDetails('<?php echo htmlspecialchars($scholarship['title']); ?>')">View Details</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Application Tips -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-body">
                    <h4 class="mb-3">Scholarship Application Tips</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Before Applying:</h6>
                            <ul>
                                <li>Read all requirements carefully</li>
                                <li>Prepare all necessary documents</li>
                                <li>Check application deadlines</li>
                                <li>Write a compelling personal statement</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Required Documents:</h6>
                            <ul>
                                <li>Academic transcripts</li>
                                <li>Recommendation letters</li>
                                <li>Personal statement/essay</li>
                                <li>Financial need documentation</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function applyScholarship(title) {
    alert('Application for "' + title + '" would open here. In a real application, this would redirect to the application form.');
}

function viewDetails(title) {
    alert('Detailed information for "' + title + '" would be displayed here.');
}
</script>

<?php require_once '../includes/footer.php'; ?>
