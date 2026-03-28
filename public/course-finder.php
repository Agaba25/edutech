<?php
$page_title = 'Course Finder';
require_once '../config.php';
require_once '../includes/header.php';
require_once '../includes/Program.php';
require_once '../includes/Institution.php';

$program = new Program();
$institution = new Institution();

// Get all programs with institution names
$allPrograms = $program->getAll();
$programsWithInstitution = [];
foreach ($allPrograms as $prog) {
    $inst = $institution->getById($prog['institution_id']);
    $prog['institution_name'] = $inst['name'];
    $programsWithInstitution[] = $prog;
}

// Group programs by level
$certificatePrograms = array_filter($programsWithInstitution, function($p) { return $p['level'] === 'Certificate'; });
$diplomaPrograms = array_filter($programsWithInstitution, function($p) { return $p['level'] === 'Diploma'; });
?>

<div class="container">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-4 fw-bold mb-3">Course Finder</h1>
            <p class="lead text-muted mb-4">Discover your course by answering a course quiz based on your combination and interests</p>
        </div>
    </div>

    <!-- Course Quiz Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Find Your Perfect Course</h4>
                </div>
                <div class="card-body">
                    <form id="courseQuizForm">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">What is your subject combination?</label>
                                <select class="form-select" name="subjects" required>
                                    <option value="">Select your combination</option>
                                    <option value="sciences">Sciences (Math, Physics, Chemistry, Biology)</option>
                                    <option value="arts">Arts (History, Geography, Literature, Economics)</option>
                                    <option value="commerce">Commerce (Economics, Accounts, Business Studies)</option>
                                    <option value="technical">Technical (Math, Physics, Technical Drawing)</option>
                                    <option value="general">General (Mixed subjects)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">What are your interests?</label>
                                <select class="form-select" name="interests" required>
                                    <option value="">Select your interests</option>
                                    <option value="technology">Technology & Computing</option>
                                    <option value="health">Health & Medicine</option>
                                    <option value="business">Business & Management</option>
                                    <option value="education">Education & Teaching</option>
                                    <option value="engineering">Engineering & Technical</option>
                                    <option value="agriculture">Agriculture & Environment</option>
                                    <option value="arts">Arts & Creative</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Preferred program level?</label>
                                <select class="form-select" name="level" required>
                                    <option value="">Select level</option>
                                    <option value="Certificate">Certificate</option>
                                    <option value="Diploma">Diploma</option>
                                    <option value="both">Both Certificate and Diploma</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Budget range (UGX)</label>
                                <select class="form-select" name="budget" required>
                                    <option value="">Select budget range</option>
                                    <option value="low">Under 2,000,000</option>
                                    <option value="medium">2,000,000 - 4,000,000</option>
                                    <option value="high">Above 4,000,000</option>
                                    <option value="any">Any budget</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Find My Courses</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Section -->
    <div id="quizResults" class="row" style="display: none;">
        <div class="col-12">
            <h3 class="mb-4">Recommended Courses for You</h3>
            <div id="recommendedCourses"></div>
        </div>
    </div>

    <!-- Popular Courses Section -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="mb-4">Popular Courses in Uganda</h2>
            <p class="text-muted mb-4">Based on recent student searches</p>
        </div>
        
        <!-- STEM Courses -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge bg-primary">STEM</span>
                        <span class="text-muted small">5-year program</span>
                    </div>
                    <h5 class="card-title">Medicine and Surgery</h5>
                    <p class="card-text">5-year program leading to MBChB degree with clinical training at major Ugandan teaching hospitals.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">12 Universities</small>
                        <small class="text-info">Doctor, Surgeon</small>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-primary btn-sm">View Details</button>
                </div>
            </div>
        </div>

        <!-- Business Courses -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge bg-success">Business</span>
                        <span class="text-muted small">3-year program</span>
                    </div>
                    <h5 class="card-title">Business Administration</h5>
                    <p class="card-text">3-year program covering management principles, finance, and entrepreneurship skills.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">18 Universities</small>
                        <small class="text-info">Manager, Entrepreneur</small>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-success btn-sm">View Details</button>
                </div>
            </div>
        </div>

        <!-- STEM Courses -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge bg-primary">STEM</span>
                        <span class="text-muted small">3-year program</span>
                    </div>
                    <h5 class="card-title">Computer Science</h5>
                    <p class="card-text">3-year program focusing on software development, algorithms, and IT systems design.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">15 Universities</small>
                        <small class="text-info">Developer, Analyst</small>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-primary btn-sm">View Details</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Explore Careers Section -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="mb-4">Explore Careers</h2>
        </div>
        <div class="col-md-2 col-sm-4 col-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-mortarboard text-primary" style="font-size: 2rem;"></i>
                    <h6 class="card-title mt-2">Graduate</h6>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-airplane text-info" style="font-size: 2rem;"></i>
                    <h6 class="card-title mt-2">Pilot</h6>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-heart-pulse text-danger" style="font-size: 2rem;"></i>
                    <h6 class="card-title mt-2">Doctor</h6>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-building text-warning" style="font-size: 2rem;"></i>
                    <h6 class="card-title mt-2">Architect</h6>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-book text-success" style="font-size: 2rem;"></i>
                    <h6 class="card-title mt-2">Teacher</h6>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="bi bi-gear text-secondary" style="font-size: 2rem;"></i>
                    <h6 class="card-title mt-2">Engineer</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('courseQuizForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const subjects = formData.get('subjects');
    const interests = formData.get('interests');
    const level = formData.get('level');
    const budget = formData.get('budget');
    
    // Simple recommendation logic
    let recommendedCourses = <?php echo json_encode($programsWithInstitution); ?>;
    
    // Filter based on quiz answers
    if (level && level !== 'both') {
        recommendedCourses = recommendedCourses.filter(course => course.level === level);
    }
    
    // Filter by budget
    if (budget && budget !== 'any') {
        recommendedCourses = recommendedCourses.filter(course => {
            const fee = parseInt(course.fee_estimate?.replace(/[^\d]/g, '') || '0');
            switch(budget) {
                case 'low': return fee < 2000000;
                case 'medium': return fee >= 2000000 && fee <= 4000000;
                case 'high': return fee > 4000000;
                default: return true;
            }
        });
    }
    
    // Display results
    displayResults(recommendedCourses.slice(0, 6));
});

function displayResults(courses) {
    const resultsDiv = document.getElementById('quizResults');
    const coursesDiv = document.getElementById('recommendedCourses');
    
    if (courses.length === 0) {
        coursesDiv.innerHTML = '<div class="alert alert-info">No courses found matching your criteria. Try adjusting your preferences.</div>';
    } else {
        let html = '<div class="row">';
        courses.forEach(course => {
            html += `
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge bg-primary">${course.level}</span>
                                <span class="text-muted small">${course.duration || 'N/A'}</span>
                            </div>
                            <h5 class="card-title">${course.name}</h5>
                            <p class="card-text">${course.description || 'No description available'}</p>
                            <p class="card-text"><small class="text-muted">${course.institution_name}</small></p>
                            <p class="card-text"><small class="text-info">${course.fee_estimate || 'Contact for fees'}</small></p>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-outline-primary btn-sm">View Details</button>
                        </div>
                    </div>
                </div>
            `;
        });
        html += '</div>';
        coursesDiv.innerHTML = html;
    }
    
    resultsDiv.style.display = 'block';
    resultsDiv.scrollIntoView({ behavior: 'smooth' });
}
</script>

<?php require_once '../includes/footer.php'; ?>
