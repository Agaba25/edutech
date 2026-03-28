<?php
$page_title = 'Institution Form';
require_once '../config.php';
require_once '../includes/Database.php';
require_once '../includes/Auth.php';
require_once '../includes/Institution.php';
require_once '../includes/Sanitizer.php';

Auth::requireAdmin();

$institution_model = new Institution();
$message = '';
$message_type = '';
$institution = null;
$is_edit = false;

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id) {
    $institution = $institution_model->getById($id);
    $is_edit = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => Sanitizer::sanitize($_POST['name'] ?? ''),
        'short_description' => Sanitizer::sanitize($_POST['short_description'] ?? ''),
        'address' => Sanitizer::sanitize($_POST['address'] ?? ''),
        'region' => Sanitizer::sanitize($_POST['region'] ?? ''),
        'logo_path' => Sanitizer::sanitize($_POST['logo_path'] ?? ''),
        'contact_email' => Sanitizer::sanitize($_POST['contact_email'] ?? ''),
        'phone' => Sanitizer::sanitize($_POST['phone'] ?? ''),
        'website' => Sanitizer::sanitize($_POST['website'] ?? '')
    ];

    // Validation
    $errors = [];
    
    if (empty($data['name'])) {
        $errors[] = 'Institution name is required.';
    }
    
    if (!empty($data['contact_email']) && !filter_var($data['contact_email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please provide a valid email address.';
    }
    
    if (!empty($data['website']) && !filter_var($data['website'], FILTER_VALIDATE_URL)) {
        $errors[] = 'Please provide a valid website URL.';
    }
    
    if (!empty($data['phone']) && !preg_match('/^[\+]?[0-9\s\-\(\)]+$/', $data['phone'])) {
        $errors[] = 'Please provide a valid phone number.';
    }

    if (empty($errors)) {
        if ($is_edit) {
            if ($institution_model->update($id, $data)) {
                $message = 'Institution updated successfully.';
                $message_type = 'success';
                $institution = $institution_model->getById($id);
            } else {
                $message = 'Error updating institution.';
                $message_type = 'danger';
            }
        } else {
            if ($institution_model->create($data)) {
                $message = 'Institution created successfully.';
                $message_type = 'success';
                header('Location: institutions.php');
                exit;
            } else {
                $message = 'Error creating institution.';
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
            <h1 class="mb-4"><?php echo $is_edit ? 'Edit Institution' : 'Add New Institution'; ?></h1>
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
                            <label for="name" class="form-label">Institution Name *</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $institution ? Sanitizer::escape($institution['name']) : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="short_description" class="form-label">Short Description</label>
                            <textarea class="form-control" id="short_description" name="short_description" rows="3"><?php echo $institution ? Sanitizer::escape($institution['short_description']) : ''; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?php echo $institution ? Sanitizer::escape($institution['address']) : ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="region" class="form-label">Region</label>
                            <input type="text" class="form-control" id="region" name="region" value="<?php echo $institution ? Sanitizer::escape($institution['region']) : ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="contact_email" class="form-label">Contact Email</label>
                            <input type="email" class="form-control" id="contact_email" name="contact_email" value="<?php echo $institution ? Sanitizer::escape($institution['contact_email']) : ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $institution ? Sanitizer::escape($institution['phone']) : ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="website" class="form-label">Website</label>
                            <input type="url" class="form-control" id="website" name="website" value="<?php echo $institution ? Sanitizer::escape($institution['website']) : ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="logo_path" class="form-label">Logo Path</label>
                            <input type="text" class="form-control" id="logo_path" name="logo_path" value="<?php echo $institution ? Sanitizer::escape($institution['logo_path']) : ''; ?>" placeholder="/images/logo.png">
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Save Institution</button>
                            <a href="institutions.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
