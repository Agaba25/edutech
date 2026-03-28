<?php
$page_title = 'Institutions';
require_once 'includes/header.php';
require_once 'includes/Institution.php';

$institution = new Institution();
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$region = isset($_GET['region']) ? trim($_GET['region']) : '';

// Pagination
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$per_page = 12;
$offset = ($page - 1) * $per_page;

// Get institutions based on filters
if ($search) {
    $institutions = $institution->search($search, $region ?: null, $per_page, $offset);
    $total_count = count($institution->search($search, $region ?: null));
} elseif ($region) {
    $institutions = $institution->getByRegion($region, $per_page, $offset);
    $total_count = count($institution->getByRegion($region));
} else {
    $institutions = $institution->getAll($per_page, $offset);
    $total_count = count($institution->getAll());
}

$total_pages = ceil($total_count / $per_page);

$regions = $institution->getAllRegions();
?>

<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="mb-4">Educational Institutions</h1>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <form method="GET" class="row g-3">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="search" placeholder="Search institutions..." value="<?php echo Sanitizer::escape($search); ?>">
                </div>
                <div class="col-md-4">
                    <select class="form-select" name="region">
                        <option value="">All Regions</option>
                        <?php foreach ($regions as $r): ?>
                        <option value="<?php echo Sanitizer::escape($r); ?>" <?php echo $region === $r ? 'selected' : ''; ?>>
                            <?php echo Sanitizer::escape($r); ?>
                        </option>
                        <?php endforeach; ?>
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
        <?php if (empty($institutions)): ?>
        <div class="col-12">
            <div class="alert alert-info">No institutions found. Try adjusting your search criteria.</div>
        </div>
        <?php else: ?>
            <?php foreach ($institutions as $inst): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo Sanitizer::escape($inst['name']); ?></h5>
                        <p class="card-text text-muted"><?php echo Sanitizer::escape($inst['short_description']); ?></p>
                        <p class="card-text">
                            <small class="text-info">📍 <?php echo Sanitizer::escape($inst['region']); ?></small><br>
                            <small class="text-muted">📧 <?php echo Sanitizer::escape($inst['contact_email']); ?></small><br>
                            <small class="text-muted">📞 <?php echo Sanitizer::escape($inst['phone']); ?></small>
                        </p>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="institution-detail.php?id=<?php echo $inst['id']; ?>" class="btn btn-sm btn-primary">View Details</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
    <div class="row mt-4">
        <div class="col-12">
            <nav aria-label="Institutions pagination">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>">Previous</a>
                    </li>
                    <?php endif; ?>
                    
                    <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>
                    
                    <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>">Next</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>
