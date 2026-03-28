<?php
$page_title = 'Admin Dashboard';
require_once '../config.php';
require_once '../includes/Database.php';
require_once '../includes/Auth.php';
require_once '../includes/Institution.php';
require_once '../includes/Program.php';
require_once '../includes/Contact.php';

Auth::requireAdmin();

$institution = new Institution();
$program = new Program();
$contact = new Contact();

$total_institutions = count($institution->getAll());
$total_programs = count($program->getAll());
$total_messages = count($contact->getAll());
$unread_messages = $contact->getUnreadCount();
?>

<?php require_once '../includes/header.php'; ?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="mb-4">Admin Dashboard</h1>
        </div>
    </div>

    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Institutions</h5>
                    <h2><?php echo $total_institutions; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Programs</h5>
                    <h2><?php echo $total_programs; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Messages</h5>
                    <h2><?php echo $total_messages; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Unread</h5>
                    <h2><?php echo $unread_messages; ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Links -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-black">
                    <h5 class="mb-0">Institutions Management</h5>
                </div>
                <div class="card-body">
                    <p>Manage educational institutions in the system.</p>
                    <a href="institutions.php" class="btn btn-primary">Manage Institutions</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-success text-black">
                    <h5 class="mb-0">Programs Management</h5>
                </div>
                <div class="card-body">
                    <p>Manage certificate and diploma programs.</p>
                    <a href="programs.php" class="btn btn-success">Manage Programs</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Contact Messages</h5>
                </div>
                <div class="card-body">
                    <p>View and manage contact form submissions.</p>
                    <a href="messages.php" class="btn btn-warning">View Messages</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-info text-black">
                    <h5 class="mb-0">User Management</h5>
                </div>
                <div class="card-body">
                    <p>Manage admin users and permissions.</p>
                    <a href="users.php" class="btn btn-info">Manage Users</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-secondary text-black">
                    <h5 class="mb-0">Scholarship Management</h5>
                </div>
                <div class="card-body">
                    <p>Manage scholarships and financial aid programs.</p>
                    <a href="scholarships.php" class="btn btn-secondary">Manage Scholarships</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
