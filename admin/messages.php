<?php
$page_title = 'Contact Messages';
require_once '../config.php';
require_once '../includes/Database.php';
require_once '../includes/Auth.php';
require_once '../includes/Contact.php';
require_once '../includes/Sanitizer.php';

Auth::requireAdmin();

$contact = new Contact();
$message = '';
$message_type = '';

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($contact->delete($id)) {
        $message = 'Message deleted successfully.';
        $message_type = 'success';
    } else {
        $message = 'Error deleting message.';
        $message_type = 'danger';
    }
}

// Handle mark as read
if (isset($_GET['mark_read'])) {
    $id = (int)$_GET['mark_read'];
    if ($contact->updateStatus($id, 'read')) {
        $message = 'Message marked as read.';
        $message_type = 'success';
    }
}

$messages = $contact->getAll();
?>

<?php require_once '../includes/header.php'; ?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="mb-4">Contact Messages</h1>
        </div>
    </div>

    <?php if ($message): ?>
    <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
        <?php echo $message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $msg): ?>
                <tr>
                    <td><?php echo $msg['id']; ?></td>
                    <td><?php echo Sanitizer::escape($msg['name']); ?></td>
                    <td><?php echo Sanitizer::escape($msg['email']); ?></td>
                    <td><?php echo Sanitizer::escape($msg['subject']); ?></td>
                    <td>
                        <?php if ($msg['status'] === 'new'): ?>
                        <span class="badge bg-danger">New</span>
                        <?php elseif ($msg['status'] === 'read'): ?>
                        <span class="badge bg-info">Read</span>
                        <?php else: ?>
                        <span class="badge bg-success">Replied</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo date('M d, Y', strtotime($msg['created_at'])); ?></td>
                    <td>
                        <a href="message-detail.php?id=<?php echo $msg['id']; ?>" class="btn btn-sm btn-info">View</a>
                        <?php if ($msg['status'] === 'new'): ?>
                        <a href="?mark_read=<?php echo $msg['id']; ?>" class="btn btn-sm btn-warning">Mark Read</a>
                        <?php endif; ?>
                        <a href="?delete=<?php echo $msg['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
