<?php
$page_title = 'Message Detail';
require_once '../config.php';
require_once '../includes/Database.php';
require_once '../includes/Auth.php';
require_once '../includes/Contact.php';
require_once '../includes/Sanitizer.php';

Auth::requireAdmin();

$contact = new Contact();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$message = $contact->getById($id);

if (!$message) {
    header('Location: messages.php');
    exit;
}

// Mark as read
if ($message['status'] === 'new') {
    $contact->updateStatus($id, 'read');
}
?>

<?php require_once '../includes/header.php'; ?>

<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <a href="messages.php" class="btn btn-outline-secondary mb-3">← Back to Messages</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Message Details</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>From:</strong> <?php echo Sanitizer::escape($message['name']); ?> (<?php echo Sanitizer::escape($message['email']); ?>)
                    </div>
                    <div class="mb-3">
                        <strong>Subject:</strong> <?php echo Sanitizer::escape($message['subject']); ?>
                    </div>
                    <div class="mb-3">
                        <strong>Date:</strong> <?php echo date('M d, Y H:i', strtotime($message['created_at'])); ?>
                    </div>
                    <div class="mb-3">
                        <strong>Status:</strong>
                        <?php if ($message['status'] === 'new'): ?>
                        <span class="badge bg-danger">New</span>
                        <?php elseif ($message['status'] === 'read'): ?>
                        <span class="badge bg-info">Read</span>
                        <?php else: ?>
                        <span class="badge bg-success">Replied</span>
                        <?php endif; ?>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <strong>Message:</strong>
                        <p><?php echo nl2br(Sanitizer::escape($message['message'])); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
