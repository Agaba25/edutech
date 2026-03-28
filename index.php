<?php
$page_title = 'Home';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/Institution.php';
require_once __DIR__ . '/includes/Program.php';
require_once __DIR__ . '/includes/header.php';
?>

<!-- Full Background Hero -->
<section class="home-hero" style="background-image:url('https://hebbkx1anhila5yf.public.blob.vercel-storage.com/hero-YDH5bC3dpCIBcvEAsyrVGUsbEP9745.jpeg');">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-9 col-md-10 hero-content text-center">
                <h1 class="display-4 fw-bold mb-3">Welcome to <?php echo APP_NAME; ?></h1>
                <p class="lead mb-4">"Shaping Uganda's Career path" - Find your course, explore institutions, and discover scholarship opportunities.</p>
                <!-- Search Box -->
                <form method="GET" action="institutions.php" class="mb-4">
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control" name="search" placeholder="Search institutions or programs..." required>
                        <button class="btn btn-primary" type="submit">Find Your Course</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</section>

<div class="container">

    <!-- Quick Stats -->
    <div class="row mb-5">
        <?php
        $institution = new Institution();
        $program = new Program();
        $institutions = $institution->getAll();
        $programs = $program->getAll();
        $regions = $institution->getAllRegions();
        ?>
        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="card-title text-primary"><?php echo count($institutions); ?></h3>
                    <p class="card-text">Institutions</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="card-title text-success"><?php echo count($programs); ?></h3>
                    <p class="card-text">Programs</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="card-title text-info"><?php echo count($regions); ?></h3>
                    <p class="card-text">Regions</p>
                </div>
            </div>
        </div>
    </div>


    <!-- What we offer section -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-center mb-5">What we offer:</h2>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="bi bi-search text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="card-title">Course Finder</h5>
                    <p class="card-text">Discover your course by answering a course quiz basing on your combination and interests</p>
                    <a href="course-finder.php" class="btn btn-outline-primary">Explore</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="bi bi-building text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="card-title">Where to study From</h5>
                    <p class="card-text">Explore the Various Universities, essential subjects, cutoff points and institutions you can join with their Tuition fees</p>
                    <a href="institutions.php" class="btn btn-outline-success">Explore</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="bi bi-award text-warning" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="card-title">Scholarship opportunities</h5>
                    <p class="card-text">Providing you with various scholarships currently available in various universities and institutions</p>
                    <a href="scholarship-hub.php" class="btn btn-outline-warning">Explore</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <div class="mb-3">
                        <i class="bi bi-compass text-info" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="card-title">Career Guidance</h5>
                    <p class="card-text">Providing you with career guidance on various potential careers to help you shape your career path</p>
                    <a href="career-guidance.php" class="btn btn-outline-info">Explore</a>
                </div>
            </div>
        </div>
    </div>


    <!-- Are You Confused Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="bg-light p-5 rounded">
                <h3 class="text-center mb-4">Are You Confused?</h3>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-2">• About which career path is right for you?</li>
                            <li class="mb-2">• About which course to take?</li>
                            <li class="mb-2">• Which institution to study from?</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <p><strong><?php echo APP_NAME; ?></strong> is here to guide you in choosing university courses and career paths that align with your subject combinations, personal interests, and the demands of the job market. Our platform aims to reduce confusion, increase awareness, and support students in making informed academic and professional decisions.</p>
                        <a href="course-finder.php" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Featured Institutions -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="mb-4">Featured Institutions</h2>
        </div>
        <?php foreach (array_slice($institutions, 0, 6) as $inst): ?>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><?php echo Sanitizer::escape($inst['name']); ?></h5>
                    <p class="card-text text-muted"><?php echo Sanitizer::escape(substr($inst['short_description'], 0, 100)); ?>...</p>
                    <p class="card-text"><small class="text-info">📍 <?php echo Sanitizer::escape($inst['region']); ?></small></p>
                </div>
                <div class="card-footer bg-white">
                    <a href="institution-detail.php?id=<?php echo $inst['id']; ?>" class="btn btn-sm btn-primary">View Details</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>


    <!-- Student Testimonials -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-center mb-5">What Students Say</h2>
            <p class="text-center text-muted mb-4">Many students across the country have used <?php echo APP_NAME; ?> to navigate through what courses to do, and the universities to study from. This has helped them shape their careers.</p>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-quote text-primary" style="font-size: 2rem;"></i>
                    </div>
                    <p class="card-text">"I discovered careers I never knew existed like data science, this changed my life once for all."</p>
                    <div class="mt-3">
                        <strong>Okello John</strong><br>
                        <small class="text-muted">Data Scientist</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-quote text-primary" style="font-size: 2rem;"></i>
                    </div>
                    <p class="card-text">"MyCareer Link helped me explore courses and universities and I'm excited to pursue Medicine"</p>
                    <div class="mt-3">
                        <strong>Kisakye Aisha</strong><br>
                        <small class="text-muted">Student KIU (BMS)</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-quote text-primary" style="font-size: 2rem;"></i>
                    </div>
                    <p class="card-text">"MyCareer Link helped me choose a Computer Science degree and soon i will be joining my career"</p>
                    <div class="mt-3">
                        <strong>Nansamba Sarah</strong><br>
                        <small class="text-muted">Student (BCS)</small>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Call to Action -->
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto">
            <div class="bg-light p-5 rounded text-center">
                <h3 class="mb-3">Ready to Find Your Ideal Course?</h3>
                <p class="mb-4">Join thousands of Ugandan students making informed decisions about their future.</p>
                <a href="institutions.php" class="btn btn-primary btn-lg">Browse All Institutions</a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
