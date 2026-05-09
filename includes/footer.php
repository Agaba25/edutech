<?php
/**
 * Footer Template
 */
$base_url = rtrim(APP_URL, '/');
?>
    </main>
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5><?php echo APP_NAME; ?></h5>
                    <p class="text-muted">Discover your ideal course and find the perfect university match based on your A-Level results and interests.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo Sanitizer::escape($base_url . '/'); ?>" class="text-muted text-decoration-none">Home</a></li>
                        <li><a href="<?php echo Sanitizer::escape($base_url . '/course-finder.php'); ?>" class="text-muted text-decoration-none">Course Finder</a></li>
                        <li><a href="<?php echo Sanitizer::escape($base_url . '/institutions.php'); ?>" class="text-muted text-decoration-none">Institutions</a></li>
                        <li><a href="<?php echo Sanitizer::escape($base_url . '/programs.php'); ?>" class="text-muted text-decoration-none">Programs</a></li>
                        <li><a href="<?php echo Sanitizer::escape($base_url . '/scholarship-hub.php'); ?>" class="text-muted text-decoration-none">Scholarships</a></li>
                        <li><a href="<?php echo Sanitizer::escape($base_url . '/contact.php'); ?>" class="text-muted text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Contact Info</h5>
                    <p class="text-muted">
                        Email: info@educareerguide.ug<br>
                        Phone: +256-700-000-000
                    </p>
                </div>
            </div>
            <hr class="bg-secondary">
            <div class="text-center text-muted">
                <p>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo Sanitizer::escape($base_url . '/assets/js/main.js'); ?>"></script>
</body>
</html>
