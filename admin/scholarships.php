<?php
$page_title = 'Manage Scholarships';
require_once '../config.php';
require_once '../includes/Database.php';
require_once '../includes/Auth.php';
require_once '../includes/Sanitizer.php';
require_once '../includes/scholarship.php';

Auth::requireAdmin();

$scholarship_model = new Scholarship();
$message = '';
$message_type = '';

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($scholarship_model->deleteScholarship($id)) {
        $message = 'Scholarship deleted successfully.';
        $message_type = 'success';
    } else {
        $message = 'Error deleting scholarship.';
        $message_type = 'danger';
    }
}

$scholarships = $scholarship_model->getAllScholarships();
?>
<?php require_once '../includes/header.php'; ?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="mb-4">Manage Scholarships</h1>
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
            <a href="scholarship-form.php" class="btn btn-primary">+ Add New Scholarship</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Institution</th>
                    <th>Amount</th>
                    <th>Deadline</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($scholarships as $scholarship): ?>
                <tr>
                    <td><?php echo $scholarship['id']; ?></td>
                    <td><?php echo Sanitizer::escape($scholarship['title']); ?></td>
                    <td><?php echo $scholarship['institution_name'] ? Sanitizer::escape($scholarship['institution_name']) : 'All Institutions'; ?></td>
                    <td><?php echo Sanitizer::escape($scholarship['amount']); ?></td>
                    <td><?php echo $scholarship['deadline'] ? date('M d, Y', strtotime($scholarship['deadline'])) : 'N/A'; ?></td>
                    <td><?php echo Sanitizer::escape($scholarship['category']); ?></td>
                    <td>
                        <a href="scholarship-form.php?id=<?php echo $scholarship['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="?delete=<?php echo $scholarship['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>