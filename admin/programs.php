<?php
$page_title = 'Manage Programs';
require_once '../config.php';
require_once '../includes/Database.php';
require_once '../includes/Auth.php';
require_once '../includes/Program.php';
require_once '../includes/Institution.php';
require_once '../includes/Sanitizer.php';

Auth::requireAdmin();

$program = new Program();
$institution = new Institution();
$message = '';
$message_type = '';

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($program->delete($id)) {
        $message = 'Program deleted successfully.';
        $message_type = 'success';
    } else {
        $message = 'Error deleting program.';
        $message_type = 'danger';
    }
}

$programs = $program->getAll();
?>

<?php require_once '../includes/header.php'; ?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="mb-4">Manage Programs</h1>
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
            <a href="program-form.php" class="btn btn-success">+ Add New Program</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Program Name</th>
                    <th>Institution</th>
                    <th>Level</th>
                    <th>Duration</th>
                    <th>Fee</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($programs as $prog): ?>
                <tr>
                    <td><?php echo $prog['id']; ?></td>
                    <td><?php echo Sanitizer::escape($prog['name']); ?></td>
                    <td><?php echo Sanitizer::escape($institution->getById($prog['institution_id'])['name']); ?></td>
                    <td><span class="badge bg-info"><?php echo Sanitizer::escape($prog['level']); ?></span></td>
                    <td><?php echo Sanitizer::escape($prog['duration']); ?></td>
                    <td><?php echo Sanitizer::escape($prog['fee_estimate']); ?></td>
                    <td>
                        <a href="program-form.php?id=<?php echo $prog['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="?delete=<?php echo $prog['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
