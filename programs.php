<?php
$page_title = 'Programs';
require_once 'includes/header.php';
require_once 'includes/Program.php';

$program = new Program();
$level = isset($_GET['level']) ? trim($_GET['level']) : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Get programs based on filters
if ($search) {
    $programs = $program->search($search);
} elseif ($level) {
    $programs = $program->getByLevel($level);
} else {
    $programs = $program->getAll();
}
?>

<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="mb-4">All Programs</h1>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <form method="GET" class="row g-3">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="search" placeholder="Search programs..." value="<?php echo Sanitizer::escape($search); ?>">
                </div>
                <div class="col-md-4">
                    <select class="form-select" name="level">
                        <option value="">All Levels</option>
                        <option value="Certificate" <?php echo $level === 'Certificate' ? 'selected' : ''; ?>>Certificate</option>
                        <option value="Diploma" <?php echo $level === 'Diploma' ? 'selected' : ''; ?>>Diploma</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Results -->
    <div class="row">
        <?php if (empty($programs)): ?>
        <div class="col-12">
            <div class="alert alert-info">No programs found. Try adjusting your search criteria.</div>
        </div>
        <?php else: ?>
            <?php foreach ($programs as $prog): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo Sanitizer::escape($prog['name']); ?></h5>
                        <p class="card-text">
                            <small class="text-muted">
                                <strong>Institution:</strong> <?php echo Sanitizer::escape($prog['institution_name']); ?><br>
                                <strong>Level:</strong> <span class="badge bg-info"><?php echo Sanitizer::escape($prog['level']); ?></span><br>
                                <strong>Duration:</strong> <?php echo Sanitizer::escape($prog['duration']); ?><br>
                                <strong>Fee:</strong> <?php echo Sanitizer::escape($prog['fee_estimate']); ?>
                            </small>
                        </p>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="institution-detail.php?id=<?php echo $prog['institution_id']; ?>" class="btn btn-sm btn-primary">View Institution</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
