<?php
$page_title = 'Scholarship Form';
require_once '../config.php';
require_once '../includes/Database.php';
require_once '../includes/Auth.php';
require_once '../includes/Institution.php';
require_once '../includes/Sanitizer.php';
require_once '../includes/scholarship.php';

Auth::requireAdmin();

$scholarship_model = new Scholarship();
$institution_model = new Institution();
$message = '';
$message_type = '';
$scholarship = null;
$is_edit = false;

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id) {
    $scholarship = $scholarship_model->getScholarshipById($id);
    $is_edit = true;
}

$institutions = $institution_model->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = Sanitizer::sanitize($_POST['title'] ?? '');
    $institution_id = !empty($_POST['institution_id']) ? (int)$_POST['institution_id'] : null;
    $amount = Sanitizer::sanitize($_POST['amount'] ?? '');
    $description = Sanitizer::sanitize($_POST['description'] ?? '');
    $requirements = Sanitizer::sanitize($_POST['requirements'] ?? '');
    $deadline = Sanitizer::sanitize($_POST['deadline'] ?? '');
    $category = Sanitizer::sanitize($_POST['category'] ?? '');
    $application_url = Sanitizer::sanitize($_POST['application_url'] ?? '');

    // Validation
    $errors = [];
    
    if (empty($title)) {
        $errors[] = 'Scholarship title is required.';
    }
    
    if (!empty($application_url) && !filter_var($application_url, FILTER_VALIDATE_URL)) {
        $errors[] = 'Please provide a valid application URL.';
    }
    
    if (!empty($deadline)) {
        $deadline_date = DateTime::createFromFormat('Y-m-d', $deadline);
        if (!$deadline_date) {
            $errors[] = 'Please provide a valid deadline date.';
        } else {
            $today = new DateTime();
            if ($deadline_date < $today) {
                $errors[] = 'Deadline date must be in the future.';
            }
        }
    }

    if (empty($errors)) {
        if ($is_edit) {
            if ($scholarship_model->updateScholarship($id, $institution_id, $title, $amount, $description, $requirements, $deadline, $application_url)) {
                $message = 'Scholarship updated successfully.';
                $message_type = 'success';
                $scholarship = $scholarship_model->getScholarshipById($id);
            } else {
                $message = 'Error updating scholarship.';
                $message_type = 'danger';
            }
        } else {
            if ($scholarship_model->addScholarship($institution_id, $title, $amount, $description, $requirements, $deadline, $application_url)) {
                $message = 'Scholarship created successfully.';
                $message_type = 'success';
                header('Location: scholarships.php');
                exit;
            } else {
                $message = 'Error creating scholarship.';
                $message_type = 'danger';
            }
        }
    } else {
        $message = implode('<br>', $errors);
        $message_type = 'danger';
    }
}
?>
<?php require_once '../includes/header.php'; ?>

<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="mb-4"><?php echo $is_edit ? 'Edit Scholarship' : 'Add New Scholarship'; ?></h1>
        </div>
    </div>

    <?php if ($message): ?>
    <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
        <?php echo $message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="title" class="form-label">Scholarship Title *</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?php echo $scholarship ? Sanitizer::escape($scholarship['title']) : ''; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="institution_id" class="form-label">Institution (Optional)</label>
                            <select class="form-select" id="institution_id" name="institution_id">
                                <option value="">All Institutions</option>
                                <?php foreach ($institutions as $inst): ?>
                                <option value="<?php echo $inst['id']; ?>" <?php echo ($scholarship && $scholarship['institution_id'] == $inst['id']) ? 'selected' : ''; ?>>
                                    <?php echo Sanitizer::escape($inst['name']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="text" class="form-control" id="amount" name="amount" value="<?php echo $scholarship ? Sanitizer::escape($scholarship['amount']) : ''; ?>" placeholder="e.g., Full Tuition, 50% Tuition, UGX 2,000,000">
                        </div>
                        
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category">
                                <option value="Government" <?php echo ($scholarship && $scholarship['category'] == 'Government') ? 'selected' : ''; ?>>Government</option>
                                <option value="International" <?php echo ($scholarship && $scholarship['category'] == 'International') ? 'selected' : ''; ?>>International</option>
                                <option value="Merit" <?php echo ($scholarship && $scholarship['category'] == 'Merit') ? 'selected' : ''; ?>>Merit</option>
                                <option value="Gender" <?php echo ($scholarship && $scholarship['category'] == 'Gender') ? 'selected' : ''; ?>>Gender</option>
                                <option value="Rural" <?php echo ($scholarship && $scholarship['category'] == 'Rural') ? 'selected' : ''; ?>>Rural</option>
                                <option value="Sports" <?php echo ($scholarship && $scholarship['category'] == 'Sports') ? 'selected' : ''; ?>>Sports</option>
                                <option value="Need-based" <?php echo ($scholarship && $scholarship['category'] == 'Need-based') ? 'selected' : ''; ?>>Need-based</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="deadline" class="form-label">Application Deadline</label>
                            <input type="date" class="form-control" id="deadline" name="deadline" value="<?php echo $scholarship ? $scholarship['deadline'] : ''; ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="application_url" class="form-label">Application URL</label>
                            <input type="url" class="form-control" id="application_url" name="application_url" value="<?php echo $scholarship ? Sanitizer::escape($scholarship['application_url']) : ''; ?>" placeholder="https://example.com/apply">
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4"><?php echo $scholarship ? Sanitizer::escape($scholarship['description']) : ''; ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="requirements" class="form-label">Requirements</label>
                            <textarea class="form-control" id="requirements" name="requirements" rows="3"><?php echo $scholarship ? Sanitizer::escape($scholarship['requirements']) : ''; ?></textarea>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Save Scholarship</button>
                            <a href="scholarships.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>