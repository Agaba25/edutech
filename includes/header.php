<?php
/**
 * Header Template
 */
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Auth.php';
require_once __DIR__ . '/Sanitizer.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? Sanitizer::escape($page_title) . ' - ' : ''; ?><?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?php echo APP_URL; ?>/">
                <i class="bi bi-mortarboard"></i> <?php echo APP_NAME; ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo APP_URL; ?>/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo APP_URL; ?>/institutions.php">Institutions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo APP_URL; ?>/programs.php">Programs</a>
                    </li>
                    <!-- Removed Enhanced Search navigation link -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo APP_URL; ?>/course-finder.php">Course Finder</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo APP_URL; ?>/scholarship-hub.php">Scholarship Hub</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo APP_URL; ?>/career-guidance.php">Career Guidance</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo APP_URL; ?>/contact.php">Contact</a>
                    </li>
<?php if (Auth::isLoggedIn()): ?>
<li class="nav-item">
    <a class="nav-link" href="<?php echo APP_URL; ?>/admin/logout.php">Logout</a>
</li>
<?php else: ?>
<li class="nav-item">
    <a class="nav-link" href="<?php echo APP_URL; ?>/admin/login.php">Admin Login</a>
</li>
<?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">
        <div class="container mb-3">
    <button onclick="window.history.length > 1 ? history.back() : window.location.href='<?php echo APP_URL; ?>/'"
        class="btn btn-outline-primary btn-sm">
        <i class="bi bi-arrow-left"></i> Back
    </button>
</div>
