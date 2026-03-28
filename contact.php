<?php
$page_title = 'Contact Us';
require_once 'includes/header.php';
require_once 'includes/Contact.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!CSRF::validateToken($_POST['csrf_token'] ?? '')) {
        $message = 'Security token validation failed. Please try again.';
        $message_type = 'danger';
    } else {
        $contact = new Contact();
        
        $name = isset($_POST['name']) ? Sanitizer::sanitize($_POST['name']) : '';
        $email = isset($_POST['email']) ? Sanitizer::sanitize($_POST['email']) : '';
        $subject = isset($_POST['subject']) ? Sanitizer::sanitize($_POST['subject']) : '';
        $msg = isset($_POST['message']) ? Sanitizer::sanitize($_POST['message']) : '';

        if (empty($name) || empty($email) || empty($msg)) {
            $message = 'Please fill in all required fields.';
            $message_type = 'danger';
        } elseif (!Sanitizer::validateEmail($email)) {
            $message = 'Please enter a valid email address.';
            $message_type = 'danger';
        } else {
            $result = $contact->create([
                'name' => $name,
                'email' => $email,
                'subject' => $subject,
                'message' => $msg
            ]);

            if ($result) {
                $message = 'Thank you! Your message has been sent successfully.';
                $message_type = 'success';
            } else {
                $message = 'An error occurred. Please try again later.';
                $message_type = 'danger';
            }
        }
    }
}
?>

<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="mb-4">Contact Us</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-dark">
                    <h5 class="mb-0">Send us a Message</h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <?php echo CSRF::getHiddenInput(); ?>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name *</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject">
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message *</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Email</h5>
                            <p class="card-text"><a href="mailto:info@edutech.local">info@edutech.local</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Phone</h5>
                            <p class="card-text">+256-700-000-000</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
