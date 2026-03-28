<?php
$page_title = 'Career Guidance';
require_once '../config.php';
require_once '../includes/header.php';

// Sample career data
$careers = [
    [
        'title' => 'Data Scientist',
        'description' => 'Analyze complex data to help organizations make informed decisions',
        'education' => 'Bachelor\'s in Computer Science, Statistics, or Mathematics',
        'skills' => ['Python', 'R', 'Machine Learning', 'Statistics', 'SQL'],
        'salary_range' => '3,000,000 - 8,000,000 UGX',
        'demand' => 'High',
        'category' => 'Technology'
    ],
    [
        'title' => 'Software Developer',
        'description' => 'Design, develop, and maintain software applications',
        'education' => 'Bachelor\'s in Computer Science or Software Engineering',
        'skills' => ['Programming', 'Problem Solving', 'Teamwork', 'Version Control'],
        'salary_range' => '2,500,000 - 6,000,000 UGX',
        'demand' => 'Very High',
        'category' => 'Technology'
    ],
    [
        'title' => 'Medical Doctor',
        'description' => 'Diagnose and treat patients, provide medical care',
        'education' => 'Bachelor of Medicine and Bachelor of Surgery (MBChB)',
        'skills' => ['Medical Knowledge', 'Communication', 'Empathy', 'Problem Solving'],
        'salary_range' => '4,000,000 - 12,000,000 UGX',
        'demand' => 'High',
        'category' => 'Healthcare'
    ],
    [
        'title' => 'Civil Engineer',
        'description' => 'Design and oversee construction of infrastructure projects',
        'education' => 'Bachelor\'s in Civil Engineering',
        'skills' => ['Engineering Design', 'Project Management', 'Mathematics', 'CAD'],
        'salary_range' => '3,000,000 - 7,000,000 UGX',
        'demand' => 'High',
        'category' => 'Engineering'
    ],
    [
        'title' => 'Business Analyst',
        'description' => 'Analyze business processes and recommend improvements',
        'education' => 'Bachelor\'s in Business Administration or related field',
        'skills' => ['Analytical Thinking', 'Communication', 'Data Analysis', 'Problem Solving'],
        'salary_range' => '2,800,000 - 5,500,000 UGX',
        'demand' => 'High',
        'category' => 'Business'
    ],
    [
        'title' => 'Teacher/Educator',
        'description' => 'Educate students in various subjects and grade levels',
        'education' => 'Bachelor\'s in Education or subject-specific degree',
        'skills' => ['Teaching', 'Communication', 'Patience', 'Subject Knowledge'],
        'salary_range' => '1,500,000 - 4,000,000 UGX',
        'demand' => 'High',
        'category' => 'Education'
    ]
];

$categories = array_unique(array_column($careers, 'category'));
?>

<div class="container">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-4 fw-bold mb-3">Career Guidance</h1>
            <p class="lead text-muted mb-4">Providing you with career guidance on various potential careers to help you shape your career path</p>
        </div>
    </div>

    <!-- Career Assessment -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Career Assessment Quiz</h4>
                </div>
                <div class="card-body">
                    <form id="careerAssessmentForm">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">What subjects do you enjoy most?</label>
                                <select class="form-select" name="subjects" required>
                                    <option value="">Select your favorite subjects</option>
                                    <option value="sciences">Mathematics, Physics, Chemistry, Biology</option>
                                    <option value="arts">History, Geography, Literature, Languages</option>
                                    <option value="business">Economics, Accounts, Business Studies</option>
                                    <option value="technical">Technical Drawing, Computer Studies</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">What type of work environment do you prefer?</label>
                                <select class="form-select" name="environment" required>
                                    <option value="">Select your preference</option>
                                    <option value="office">Office/Corporate Environment</option>
                                    <option value="field">Field Work/Outdoor</option>
                                    <option value="healthcare">Healthcare/Medical</option>
                                    <option value="education">Educational/Teaching</option>
                                    <option value="creative">Creative/Artistic</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">What are your key strengths?</label>
                                <select class="form-select" name="strengths" required>
                                    <option value="">Select your main strength</option>
                                    <option value="analytical">Analytical and Logical Thinking</option>
                                    <option value="creative">Creative and Innovative</option>
                                    <option value="social">Social and Communication</option>
                                    <option value="technical">Technical and Problem-Solving</option>
                                    <option value="leadership">Leadership and Management</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">What motivates you most?</label>
                                <select class="form-select" name="motivation" required>
                                    <option value="">Select your main motivation</option>
                                    <option value="money">Financial Success</option>
                                    <option value="impact">Making a Difference</option>
                                    <option value="learning">Continuous Learning</option>
                                    <option value="recognition">Recognition and Status</option>
                                    <option value="security">Job Security</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Get Career Recommendations</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Assessment Results -->
    <div id="assessmentResults" class="row mb-5" style="display: none;">
        <div class="col-12">
            <h3 class="mb-4">Recommended Careers for You</h3>
            <div id="recommendedCareers"></div>
        </div>
    </div>

    <!-- Career Categories -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="mb-4">Explore Career Categories</h2>
        </div>
        <?php foreach ($categories as $category): ?>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <?php
                        $icon = match($category) {
                            'Technology' => 'bi-laptop',
                            'Healthcare' => 'bi-heart-pulse',
                            'Engineering' => 'bi-gear',
                            'Business' => 'bi-briefcase',
                            'Education' => 'bi-book',
                            default => 'bi-person'
                        };
                        ?>
                        <i class="bi <?php echo $icon; ?> text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="card-title"><?php echo $category; ?></h5>
                    <p class="card-text">Explore careers in <?php echo strtolower($category); ?> field</p>
                    <button class="btn btn-outline-primary" onclick="filterCareers('<?php echo $category; ?>')">Explore</button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- All Careers -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="mb-4">Career Paths</h2>
            <div class="row">
                <?php foreach ($careers as $career): ?>
                <div class="col-md-6 col-lg-4 mb-4 career-card" data-category="<?php echo $career['category']; ?>">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span class="badge bg-primary"><?php echo $career['category']; ?></span>
                            <span class="badge bg-<?php echo $career['demand'] === 'Very High' ? 'danger' : ($career['demand'] === 'High' ? 'success' : 'warning'); ?>">
                                <?php echo $career['demand']; ?> Demand
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $career['title']; ?></h5>
                            <p class="card-text"><?php echo $career['description']; ?></p>
                            <div class="mb-3">
                                <strong>Education:</strong> <?php echo $career['education']; ?><br>
                                <strong>Salary:</strong> <?php echo $career['salary_range']; ?>
                            </div>
                            <div class="mb-3">
                                <strong>Key Skills:</strong>
                                <div class="mt-1">
                                    <?php foreach ($career['skills'] as $skill): ?>
                                    <span class="badge bg-light text-dark me-1"><?php echo $skill; ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary btn-sm" onclick="viewCareerDetails('<?php echo $career['title']; ?>')">Learn More</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Career Tips -->
    <div class="row">
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-body">
                    <h4 class="mb-3">Career Development Tips</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Building Your Career:</h6>
                            <ul>
                                <li>Set clear career goals</li>
                                <li>Develop relevant skills continuously</li>
                                <li>Build a professional network</li>
                                <li>Seek mentorship opportunities</li>
                                <li>Stay updated with industry trends</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Job Market Trends:</h6>
                            <ul>
                                <li>Technology skills are in high demand</li>
                                <li>Soft skills are increasingly important</li>
                                <li>Remote work opportunities are growing</li>
                                <li>Continuous learning is essential</li>
                                <li>Entrepreneurship is on the rise</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('careerAssessmentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const subjects = formData.get('subjects');
    const environment = formData.get('environment');
    const strengths = formData.get('strengths');
    const motivation = formData.get('motivation');
    
    // Simple recommendation logic based on quiz answers
    let recommendedCareers = <?php echo json_encode($careers); ?>;
    
    // Filter based on quiz answers
    if (subjects === 'sciences' || strengths === 'analytical') {
        recommendedCareers = recommendedCareers.filter(career => 
            career.category === 'Technology' || career.category === 'Engineering' || career.category === 'Healthcare'
        );
    } else if (subjects === 'arts' || strengths === 'creative') {
        recommendedCareers = recommendedCareers.filter(career => 
            career.category === 'Education' || career.category === 'Business'
        );
    }
    
    // Display results
    displayCareerResults(recommendedCareers.slice(0, 3));
});

function displayCareerResults(careers) {
    const resultsDiv = document.getElementById('assessmentResults');
    const careersDiv = document.getElementById('recommendedCareers');
    
    if (careers.length === 0) {
        careersDiv.innerHTML = '<div class="alert alert-info">No careers found matching your preferences. Try adjusting your answers.</div>';
    } else {
        let html = '<div class="row">';
        careers.forEach(career => {
            html += `
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <span class="badge bg-primary">${career.category}</span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">${career.title}</h5>
                            <p class="card-text">${career.description}</p>
                            <p class="card-text"><strong>Salary:</strong> ${career.salary_range}</p>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary btn-sm" onclick="viewCareerDetails('${career.title}')">Learn More</button>
                        </div>
                    </div>
                </div>
            `;
        });
        html += '</div>';
        careersDiv.innerHTML = html;
    }
    
    resultsDiv.style.display = 'block';
    resultsDiv.scrollIntoView({ behavior: 'smooth' });
}

function filterCareers(category) {
    const careerCards = document.querySelectorAll('.career-card');
    careerCards.forEach(card => {
        if (card.dataset.category === category) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

function viewCareerDetails(title) {
    alert('Detailed information for "' + title + '" would be displayed here.');
}
</script>

<?php require_once '../includes/footer.php'; ?>
