<?php
$page_title = 'Program Form';
require_once '../config.php';
require_once '../includes/Database.php';
require_once '../includes/Auth.php';
require_once '../includes/Program.php';
require_once '../includes/Institution.php';
require_once '../includes/Sanitizer.php';

Auth::requireAdmin();

$program_model = new Program();
$institution_model = new Institution();
$message = '';
$message_type = '';
$program = null;
$is_edit = false;

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id) {
    $program = $program_model->getById($id);
    $is_edit = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'institution_id' => (int)($_POST['institution_id'] ?? 0),
        'level' => Sanitizer::sanitize($_POST['level'] ?? ''),
        'name' => Sanitizer::sanitize($_POST['name'] ?? ''),
        'duration' => Sanitizer::sanitize($_POST['duration'] ?? ''),
        'fee_estimate' => Sanitizer::sanitize($_POST['fee_estimate'] ?? ''),
        'cutoff_info' => Sanitizer::sanitize($_POST['cutoff_info'] ?? ''),
        'description' => Sanitizer::sanitize($_POST['description'] ?? '')
    ];

    // Validation
    $errors = [];
    
    if (empty($data['name'])) {
        $errors[] = 'Program name is required.';
    }
    
    if (empty($data['institution_id'])) {
        $errors[] = 'Institution is required.';
    }
    
    if (empty($data['level'])) {
        $errors[] = 'Program level is required.';
    }
    
    if (!empty($data['fee_estimate']) && !preg_match('/^[0-9,\sUGX]+$/', $data['fee_estimate'])) {
        $errors[] = 'Fee estimate should contain only numbers, commas, spaces and UGX.';
    }

    if (empty($errors)) {
        if ($is_edit) {
            if ($program_model->update($id, $data)) {
                $message = 'Program updated successfully.';
                $message_type = 'success';
                $program = $program_model->getById($id);
            } else {
                $message = 'Error updating program.';
                $message_type = 'danger';
            }
        } else {
            if ($program_model->create($data)) {
                $message = 'Program created successfully.';
                $message_type = 'success';
                header('Location: programs.php');
                exit;
            } else {
                $message = 'Error creating program.';
                $message_type = 'danger';
            }
        }
    } else {
        $message = implode('<br>', $errors);
        $message_type = 'danger';
    }
}

$institutions = $institution_model->getAll();
?>

<?php require_once '../includes/header.php'; ?>

<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="mb-4"><?php echo $is_edit ? 'Edit Program' : 'Add New Program'; ?></h1>
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
                            <label for="institution_id" class="form-label">Institution *</label>
                            <select class="form-select" id="institution_id" name="institution_id" required>
                                <option value="">Select Institution</option>
                                <?php foreach ($institutions as $inst): ?>
                                <option value="<?php echo $inst['id']; ?>" <?php echo $program && $program['institution_id'] == $inst['id'] ? 'selected' : ''; ?>>
                                    <?php echo Sanitizer::escape($inst['name']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="level" class="form-label">Level *</label>
                            <select class="form-select" id="level" name="level" required>
                                <option value="">Select Level</option>
                                <option value="Certificate" <?php echo $program && $program['level'] === 'Certificate' ? 'selected' : ''; ?>>Certificate</option>
                                <option value="Diploma" <?php echo $program && $program['level'] === 'Diploma' ? 'selected' : ''; ?>>Diploma</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Program Name *</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $program ? Sanitizer::escape($program['name']) : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="duration" class="form-label">Duration</label>
                            <input type="text" class="form-control" id="duration" name="duration" value="<?php echo $program ? Sanitizer::escape($program['duration']) : ''; ?>" placeholder="e.g., 2 years">
                        </div>
                        <div class="mb-3">
                            <label for="fee_estimate" class="form-label">Fee Estimate</label>
                            <input type="text" class="form-control" id="fee_estimate" name="fee_estimate" value="<?php echo $program ? Sanitizer::escape($program['fee_estimate']) : ''; ?>" placeholder="e.g., 5,000,000 UGX">
                        </div>
                        <div class="mb-3">
                            <label for="cutoff_info" class="form-label">Entry-Level Cut-off Points</label>
                            <textarea class="form-control" id="cutoff_info" name="cutoff_info" rows="3" placeholder="e.g., Minimum: 2 A-levels (including Math)"><?php echo $program ? Sanitizer::escape($program['cutoff_info']) : ''; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4"><?php echo $program ? Sanitizer::escape($program['description']) : ''; ?></textarea>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">Save Program</button>
                            <a href="programs.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
