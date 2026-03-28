<?php
$page_title = 'Manage Institutions';
require_once '../config.php';
require_once '../includes/Database.php';
require_once '../includes/Auth.php';
require_once '../includes/Institution.php';
require_once '../includes/Sanitizer.php';

Auth::requireAdmin();

$institution = new Institution();
$message = '';
$message_type = '';

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($institution->delete($id)) {
        $message = 'Institution deleted successfully.';
        $message_type = 'success';
    } else {
        $message = 'Error deleting institution.';
        $message_type = 'danger';
    }
}

$institutions = $institution->getAll();
?>

<?php require_once '../includes/header.php'; ?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="mb-4">Manage Institutions</h1>
        </div>
    </div>

    <?php if ($message): ?>
    <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
        <?php echo $message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="row mb-4">
        <div class="col-12">
            <a href="institution-form.php" class="btn btn-primary">+ Add New Institution</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Region</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($institutions as $inst): ?>
                <tr>
                    <td><?php echo $inst['id']; ?></td>
                    <td><?php echo Sanitizer::escape($inst['name']); ?></td>
                    <td><?php echo Sanitizer::escape($inst['region']); ?></td>
                    <td><?php echo Sanitizer::escape($inst['contact_email']); ?></td>
                    <td><?php echo Sanitizer::escape($inst['phone']); ?></td>
                    <td>
                        <a href="institution-form.php?id=<?php echo $inst['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="?delete=<?php echo $inst['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
