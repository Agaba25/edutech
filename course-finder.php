<?php
$page_title = 'Course Finder';
require_once __DIR__ . '/includes/header.php';
?>

<style>
:root {
    --primary-gold: #FDB913;
    --primary-dark: #F59E0B;
    --text-dark: #1f2937;
}

.bg-gradient-gold {
    background: linear-gradient(135deg, #FDB913 0%, #F59E0B 100%);
}

.match-badge {
    font-size: 1.1rem;
    font-weight: bold;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
}

.match-excellent {
    background-color: #10b981;
    color: white;
}

.match-good {
    background-color: #f59e0b;
    color: white;
}

.match-fair {
    background-color: #f97316;
    color: white;
}

.form-section {
    background: white;
    border-radius: 0.5rem;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.results-card {
    transition: transform 0.2s, box-shadow 0.2s;
    margin-bottom: 2rem;
}

.results-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.subject-group {
    background-color: #f9fafb;
    padding: 1rem;
    border-radius: 0.375rem;
    margin-bottom: 1rem;
}

.interest-checkbox {
    margin-bottom: 0.75rem;
}

.interest-checkbox input[type="checkbox"] {
    margin-right: 0.5rem;
}

.loading-spinner {
    display: none;
}

.loading-spinner.active {
    display: block;
}

#courseFinderForm {
    max-width: 900px;
    margin: 0 auto;
}
</style>

<div class="container my-5">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-lg-10 mx-auto text-center">
            <h1 class="display-4 fw-bold mb-3">Course Finder</h1>
            <p class="lead text-muted">Discover your ideal course by entering your A-Level results and interests. Get personalized course recommendations!</p>
        </div>
    </div>

    <!-- A-Level Results Form -->
    <div class="form-section">
        <form id="courseFinderForm">
            <!-- A-Level Results Section -->
            <h3 class="mb-4">A-Level Results</h3>
            
            <!-- Principal Subjects -->
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Principal Subject 1</label>
                    <select class="form-select" name="principal1_subject" required>
                        <option value="">Select Subject</option>
                        <optgroup label="Sciences">
                            <option value="Mathematics">Mathematics</option>
                            <option value="Physics">Physics</option>
                            <option value="Chemistry">Chemistry</option>
                            <option value="Biology">Biology</option>
                        </optgroup>
                        <optgroup label="Languages">
                            <option value="English">English</option>
                            <option value="Luganda">Luganda</option>
                            <option value="French">French</option>
                            <option value="German">German</option>
                            <option value="Arabic">Arabic</option>
                            <option value="Kiswahili">Kiswahili</option>
                            <option value="Latin">Latin</option>
                        </optgroup>
                        <optgroup label="Humanities">
                            <option value="History">History</option>
                            <option value="Geography">Geography</option>
                            <option value="Divinity">Divinity</option>
                            <option value="Literature in English">Literature in English</option>
                            <option value="CRE">CRE</option>
                            <option value="IRE">IRE</option>
                            <option value="Entrepreneurship Education">Entrepreneurship Education</option>
                        </optgroup>
                        <optgroup label="Business">
                            <option value="Economics">Economics</option>
                            <option value="Entrepreneurship">Entrepreneurship</option>
                            <option value="Accounts">Accounts</option>
                            <option value="Commerce">Commerce</option>
                        </optgroup>
                        <optgroup label="Arts">
                            <option value="Fine Art">Fine Art</option>
                            <option value="Music">Music</option>
                            <option value="Technical Drawing">Technical Drawing</option>
                            <option value="Food & Nutrition">Food & Nutrition</option>
                            <option value="ICT">ICT</option>
                            <option value="Agriculture">Agriculture</option>
                        </optgroup>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Principal Subject 2</label>
                    <select class="form-select" name="principal2_subject" required>
                        <option value="">Select Subject</option>
                        <optgroup label="Sciences">
                            <option value="Mathematics">Mathematics</option>
                            <option value="Physics">Physics</option>
                            <option value="Chemistry">Chemistry</option>
                            <option value="Biology">Biology</option>
                        </optgroup>
                        <optgroup label="Languages">
                            <option value="English">English</option>
                            <option value="Luganda">Luganda</option>
                            <option value="French">French</option>
                            <option value="German">German</option>
                            <option value="Arabic">Arabic</option>
                            <option value="Kiswahili">Kiswahili</option>
                            <option value="Latin">Latin</option>
                        </optgroup>
                        <optgroup label="Humanities">
                            <option value="History">History</option>
                            <option value="Geography">Geography</option>
                            <option value="Divinity">Divinity</option>
                            <option value="Literature in English">Literature in English</option>
                            <option value="CRE">CRE</option>
                            <option value="IRE">IRE</option>
                            <option value="Entrepreneurship Education">Entrepreneurship Education</option>
                        </optgroup>
                        <optgroup label="Business">
                            <option value="Economics">Economics</option>
                            <option value="Entrepreneurship">Entrepreneurship</option>
                            <option value="Accounts">Accounts</option>
                            <option value="Commerce">Commerce</option>
                        </optgroup>
                        <optgroup label="Arts">
                            <option value="Fine Art">Fine Art</option>
                            <option value="Music">Music</option>
                            <option value="Technical Drawing">Technical Drawing</option>
                            <option value="Food & Nutrition">Food & Nutrition</option>
                            <option value="ICT">ICT</option>
                            <option value="Agriculture">Agriculture</option>
                        </optgroup>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Principal Subject 3</label>
                    <select class="form-select" name="principal3_subject" required>
                        <option value="">Select Subject</option>
                        <optgroup label="Sciences">
                            <option value="Mathematics">Mathematics</option>
                            <option value="Physics">Physics</option>
                            <option value="Chemistry">Chemistry</option>
                            <option value="Biology">Biology</option>
                        </optgroup>
                        <optgroup label="Languages">
                            <option value="English">English</option>
                            <option value="Luganda">Luganda</option>
                            <option value="French">French</option>
                            <option value="German">German</option>
                            <option value="Arabic">Arabic</option>
                            <option value="Kiswahili">Kiswahili</option>
                            <option value="Latin">Latin</option>
                        </optgroup>
                        <optgroup label="Humanities">
                            <option value="History">History</option>
                            <option value="Geography">Geography</option>
                            <option value="Divinity">Divinity</option>
                            <option value="Literature in English">Literature in English</option>
                            <option value="CRE">CRE</option>
                            <option value="IRE">IRE</option>
                            <option value="Entrepreneurship Education">Entrepreneurship Education</option>
                        </optgroup>
                        <optgroup label="Business">
                            <option value="Economics">Economics</option>
                            <option value="Entrepreneurship">Entrepreneurship</option>
                            <option value="Accounts">Accounts</option>
                            <option value="Commerce">Commerce</option>
                        </optgroup>
                        <optgroup label="Arts">
                            <option value="Fine Art">Fine Art</option>
                            <option value="Music">Music</option>
                            <option value="Technical Drawing">Technical Drawing</option>
                            <option value="Food & Nutrition">Food & Nutrition</option>
                            <option value="ICT">ICT</option>
                            <option value="Agriculture">Agriculture</option>
                        </optgroup>
                    </select>
                </div>
            </div>

            <!-- Grades Row -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Grade</label>
                    <select class="form-select" name="principal1_grade" required>
                        <option value="">Select Grade</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="O">O</option>
                        <option value="F">F</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Grade</label>
                    <select class="form-select" name="principal2_grade" required>
                        <option value="">Select Grade</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="O">O</option>
                        <option value="F">F</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Grade</label>
                    <select class="form-select" name="principal3_grade" required>
                        <option value="">Select Grade</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="O">O</option>
                        <option value="F">F</option>
                    </select>
                </div>
            </div>

            <!-- General Paper and Subsidiary -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold">General Paper</label>
                    <select class="form-select" name="general_paper" required>
                        <option value="">Select Status</option>
                        <option value="Pass">Pass</option>
                        <option value="Fail">Fail</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Subsidiary Subject</label>
                    <select class="form-select" name="subsidiary" required>
                        <option value="">Select Status</option>
                        <option value="Pass">Pass</option>
                        <option value="Fail">Fail</option>
                    </select>
                </div>
            </div>

            <!-- Interest Selection -->
            <h3 class="mb-4 mt-5">Your Interests (Select up to 3)</h3>
            <div id="interestSelection">
                <div class="row">
                    <div class="col-md-6">
                        <div class="interest-checkbox">
                            <input type="checkbox" name="interests[]" value="Science & Technology" id="int1">
                            <label for="int1">Science & Technology</label>
                        </div>
                        <div class="interest-checkbox">
                            <input type="checkbox" name="interests[]" value="Engineering" id="int2">
                            <label for="int2">Engineering</label>
                        </div>
                        <div class="interest-checkbox">
                            <input type="checkbox" name="interests[]" value="Medicine & Health Sciences" id="int3">
                            <label for="int3">Medicine & Health Sciences</label>
                        </div>
                        <div class="interest-checkbox">
                            <input type="checkbox" name="interests[]" value="Business & Management" id="int4">
                            <label for="int4">Business & Management</label>
                        </div>
                        <div class="interest-checkbox">
                            <input type="checkbox" name="interests[]" value="Law & Legal Studies" id="int5">
                            <label for="int5">Law & Legal Studies</label>
                        </div>
                        <div class="interest-checkbox">
                            <input type="checkbox" name="interests[]" value="Arts & Humanities" id="int6">
                            <label for="int6">Arts & Humanities</label>
                        </div>
                        <div class="interest-checkbox">
                            <input type="checkbox" name="interests[]" value="Education" id="int7">
                            <label for="int7">Education</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="interest-checkbox">
                            <input type="checkbox" name="interests[]" value="Agriculture & Veterinary" id="int8">
                            <label for="int8">Agriculture & Veterinary</label>
                        </div>
                        <div class="interest-checkbox">
                            <input type="checkbox" name="interests[]" value="Social Sciences" id="int9">
                            <label for="int9">Social Sciences</label>
                        </div>
                        <div class="interest-checkbox">
                            <input type="checkbox" name="interests[]" value="Computing & IT" id="int10">
                            <label for="int10">Computing & IT</label>
                        </div>
                        <div class="interest-checkbox">
                            <input type="checkbox" name="interests[]" value="Creative Arts & Design" id="int11">
                            <label for="int11">Creative Arts & Design</label>
                        </div>
                        <div class="interest-checkbox">
                            <input type="checkbox" name="interests[]" value="Tourism & Hospitality" id="int12">
                            <label for="int12">Tourism & Hospitality</label>
                        </div>
                        <div class="interest-checkbox">
                            <input type="checkbox" name="interests[]" value="Development Studies" id="int13">
                            <label for="int13">Development Studies</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center mt-5">
                <button type="submit" class="btn btn-lg bg-gradient-gold text-white px-5">
                    Find My Courses
                </button>
            </div>

            <!-- Loading Spinner -->
            <div class="text-center mt-3">
                <div class="loading-spinner">
                    <div class="spinner-border text-warning" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Finding your perfect courses...</p>
                </div>
            </div>
        </form>
    </div>

    <!-- Results Section -->
    <div id="resultsSection" style="display: none;">
        <h2 class="mb-4">Your Course Recommendations</h2>
        <div id="resultsContainer"></div>
    </div>
</div>

<script>
// Grade points mapping
const gradePoints = {
    'A': 6,
    'B': 5,
    'C': 4,
    'D': 3,
    'E': 2,
    'O': 1,
    'F': 0
};

// Limit interest selection to 3
const interestCheckboxes = document.querySelectorAll('input[name="interests[]"]');
let selectedInterests = 0;

interestCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        if (this.checked) {
            selectedInterests++;
            if (selectedInterests > 3) {
                this.checked = false;
                selectedInterests--;
                alert('You can only select up to 3 interests');
            }
        } else {
            selectedInterests--;
        }
    });
});

// Load saved form data from localStorage
function loadSavedData() {
    const savedData = localStorage.getItem('courseFinderForm');
    if (savedData) {
        const data = JSON.parse(savedData);
        Object.keys(data).forEach(key => {
            const element = document.querySelector(`[name="${key}"]`);
            if (element) {
                element.value = data[key];
            }
        });
        // Handle checkboxes
        if (data.interests) {
            document.querySelectorAll('input[name="interests[]"]').forEach(cb => {
                cb.checked = data.interests.includes(cb.value);
            });
        }
    }
}

// Save form data to localStorage
function saveFormData() {
    const formData = new FormData(document.getElementById('courseFinderForm'));
    const data = {};
    
    // Get all form values
    for (let [key, value] of formData.entries()) {
        if (data[key]) {
            if (!Array.isArray(data[key])) {
                data[key] = [data[key]];
            }
            data[key].push(value);
        } else {
            data[key] = value;
        }
    }
    
    localStorage.setItem('courseFinderForm', JSON.stringify(data));
}

// Attach save listener to all inputs
document.querySelectorAll('#courseFinderForm input, #courseFinderForm select').forEach(element => {
    element.addEventListener('change', saveFormData);
});

// Calculate course match
function calculateCourseMatch(userResults, userInterests, course) {
    let matchScore = 0;
    let totalPoints = 0;
    
    // Calculate total A-Level points
    totalPoints = userResults.principal1.points + 
                  userResults.principal2.points + 
                  userResults.principal3.points +
                  (userResults.generalPaper === 'Pass' ? 1 : 0) +
                  (userResults.subsidiary === 'Pass' ? 1 : 0);
    
    // Check minimum points requirement
    if (totalPoints < course.minimum_points) return 0;
    
    // Subject combination match (40% weight)
    const requiredSubjects = course.essential_subjects;
    const userSubjects = [
        userResults.principal1.subject,
        userResults.principal2.subject,
        userResults.principal3.subject
    ];
    
    const subjectMatches = requiredSubjects.filter(req => 
        userSubjects.includes(req)
    ).length;
    
    matchScore += (subjectMatches / requiredSubjects.length) * 40;
    
    // Interest alignment (30% weight)
    const interestMatches = course.career_fields.filter(field =>
        userInterests.includes(field)
    ).length;
    
    matchScore += (interestMatches / Math.max(userInterests.length, 1)) * 30;
    
    // Points surplus (20% weight)
    const pointsSurplus = totalPoints - course.minimum_points;
    matchScore += Math.min((pointsSurplus / 5) * 20, 20);
    
    // Grade quality (10% weight)
    const avgGrade = totalPoints / 5;
    matchScore += (avgGrade / 6) * 10;
    
    return Math.round(matchScore);
}

// Get match badge class
function getMatchBadgeClass(matchScore) {
    if (matchScore >= 90) return 'match-excellent';
    if (matchScore >= 75) return 'match-good';
    if (matchScore >= 60) return 'match-fair';
    return '';
}

// Form submission handler
document.getElementById('courseFinderForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validate form inputs
    const principal1Subject = document.querySelector('[name="principal1_subject"]').value;
    const principal2Subject = document.querySelector('[name="principal2_subject"]').value;
    const principal3Subject = document.querySelector('[name="principal3_subject"]').value;
    const principal1Grade = document.querySelector('[name="principal1_grade"]').value;
    const principal2Grade = document.querySelector('[name="principal2_grade"]').value;
    const principal3Grade = document.querySelector('[name="principal3_grade"]').value;
    const generalPaper = document.querySelector('[name="general_paper"]').value;
    const subsidiary = document.querySelector('[name="subsidiary"]').value;
    
    // Check if all required fields are filled
    if (!principal1Subject || !principal2Subject || !principal3Subject || 
        !principal1Grade || !principal2Grade || !principal3Grade || 
        !generalPaper || !subsidiary) {
        alert('Please fill in all required fields.');
        return;
    }
    
    // Check for duplicate subjects
    const subjects = [principal1Subject, principal2Subject, principal3Subject];
    const uniqueSubjects = [...new Set(subjects)];
    if (uniqueSubjects.length !== subjects.length) {
        alert('Please select different subjects for each principal subject.');
        return;
    }
    
    // Show loading spinner
    document.querySelector('.loading-spinner').classList.add('active');
    
    // Get form data
    const formData = new FormData(this);
    
    // Build user results object
    const userResults = {
        principal1: {
            subject: formData.get('principal1_subject'),
            grade: formData.get('principal1_grade'),
            points: gradePoints[formData.get('principal1_grade')]
        },
        principal2: {
            subject: formData.get('principal2_subject'),
            grade: formData.get('principal2_grade'),
            points: gradePoints[formData.get('principal2_grade')]
        },
        principal3: {
            subject: formData.get('principal3_subject'),
            grade: formData.get('principal3_grade'),
            points: gradePoints[formData.get('principal3_grade')]
        },
        generalPaper: formData.get('general_paper'),
        subsidiary: formData.get('subsidiary')
    };
    
    // Get interests
    const userInterests = formData.getAll('interests[]');
    
    if (userInterests.length === 0) {
        alert('Please select at least one interest area');
        document.querySelector('.loading-spinner').classList.remove('active');
        return;
    }
    
    // Fetch courses and calculate matches
    fetch('api/course-matching.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            userResults: userResults,
            userInterests: userInterests
        })
    })
    .then(response => response.json())
    .then(data => {
        document.querySelector('.loading-spinner').classList.remove('active');
        
        if (data.success && data.courses.length > 0) {
            displayResults(data.courses);
        } else {
            document.getElementById('resultsContainer').innerHTML = 
                '<div class="alert alert-warning">No matching courses found. Try adjusting your subjects or interests.</div>';
            document.getElementById('resultsSection').style.display = 'block';
        }
        
        // Scroll to results
        document.getElementById('resultsSection').scrollIntoView({ behavior: 'smooth' });
    })
    .catch(error => {
        console.error('Error:', error);
        document.querySelector('.loading-spinner').classList.remove('active');
        alert('An error occurred. Please try again.');
    });
});

// Display results
function displayResults(courses) {
    const container = document.getElementById('resultsContainer');
    let html = '';
    
    courses.forEach(course => {
        const matchClass = getMatchBadgeClass(course.matchScore);
        
        html += `
            <div class="card results-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h4 class="card-title">${course.name}</h4>
                        ${course.matchScore >= 60 ? 
                            `<span class="match-badge ${matchClass}">${course.matchScore}% Match</span>` : 
                            ''}
                    </div>
                    
                    <p class="text-muted mb-3">${course.description}</p>
                    
                    <div class="mb-3">
                        <strong>Career Overview:</strong>
                        <p>${course.description}</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Career Opportunities:</strong>
                        <ul>
                            ${course.career_opportunities.map(career => `<li>${career}</li>`).join('')}
                        </ul>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Essential Subjects:</strong>
                        <p>${course.essential_subjects.join(', ')}</p>
                    </div>
                    
                    ${course.universities && course.universities.length > 0 ? `
                        <div class="mb-3">
                            <strong>Recommended Universities (${course.universities.length}):</strong>
                            <div class="d-flex flex-column gap-2 mt-2">
                                ${course.universities.slice(0, 3).map(uni => 
                                    `<a href="${uni.application_link || '#'}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        ${uni.name} - Apply Now →
                                    </a>`
                                ).join('')}
                            </div>
                        </div>
                    ` : ''}
                    
                    ${course.scholarships && course.scholarships.length > 0 ? `
                        <div>
                            <strong>Available Scholarships:</strong>
                            <ul class="list-unstyled">
                                ${course.scholarships.map(sch => 
                                    `<li>• ${sch.scholarship_name}</li>`
                                ).join('')}
                            </ul>
                        </div>
                    ` : ''}
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
    document.getElementById('resultsSection').style.display = 'block';
}

// Load saved data on page load
loadSavedData();
</script>

<?php require_once 'includes/footer.php'; ?>
