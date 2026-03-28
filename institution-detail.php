<?php
$page_title = 'Institution Details';
require_once 'includes/header.php';
require_once 'includes/Institution.php';
require_once 'includes/Program.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$institution_model = new Institution();
$program_model = new Program();

$institution = $institution_model->getById($id);
if (!$institution) {
    header('Location: institutions.php');
    exit;
}

$programs = $program_model->getByInstitution($id);
?>

<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <a href="institutions.php" class="btn btn-outline-secondary mb-3">← Back to Institutions</a>
        </div>
    </div>

    <!-- Institution Header -->
    <div class="row mb-5">
        <div class="col-lg-8">
            <h1 class="mb-3"><?php echo Sanitizer::escape($institution['name']); ?></h1>
            <p class="lead text-muted"><?php echo Sanitizer::escape($institution['short_description']); ?></p>
        </div>
    </div>

    <!-- Institution Info -->
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Contact Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Address:</strong> <?php echo Sanitizer::escape($institution['address']); ?></p>
                    <p><strong>Region:</strong> <?php echo Sanitizer::escape($institution['region']); ?></p>
                    <p><strong>Email:</strong> <a href="mailto:<?php echo Sanitizer::escape($institution['contact_email']); ?>"><?php echo Sanitizer::escape($institution['contact_email']); ?></a></p>
                    <p><strong>Phone:</strong> <?php echo Sanitizer::escape($institution['phone']); ?></p>
                    <?php if ($institution['website']): ?>
                    <p><strong>Website:</strong> <a href="<?php echo Sanitizer::escape($institution['website']); ?>" target="_blank"><?php echo Sanitizer::escape($institution['website']); ?></a></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Programs Offered</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($programs)): ?>
                    <p class="text-muted">No programs available.</p>
                    <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($programs as $prog): ?>
                        <li class="list-group-item">
                            <strong><?php echo Sanitizer::escape($prog['name']); ?></strong><br>
                            <small class="text-muted">Level: <?php echo Sanitizer::escape($prog['level']); ?> | Duration: <?php echo Sanitizer::escape($prog['duration']); ?></small>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Programs Details -->
    <?php if (!empty($programs)): ?>
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="mb-4">Program Details</h2>
        </div>
        <?php foreach ($programs as $prog): ?>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo Sanitizer::escape($prog['name']); ?></h5>
                </div>
                <div class="card-body">
                    <p><strong>Level:</strong> <span class="badge bg-info"><?php echo Sanitizer::escape($prog['level']); ?></span></p>
                    <p><strong>Duration:</strong> <?php echo Sanitizer::escape($prog['duration']); ?></p>
                    <p><strong>Fee Estimate:</strong> <?php echo Sanitizer::escape($prog['fee_estimate']); ?></p>
                    <p><strong>Entry-Level Cut-off:</strong></p>
                    <div class="alert alert-warning">
                        <?php echo Sanitizer::escape($prog['cutoff_info']); ?>
                    </div>
                    <p><strong>Description:</strong></p>
                    <p><?php echo Sanitizer::escape($prog['description']); ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>
