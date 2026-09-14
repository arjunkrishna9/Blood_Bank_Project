<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_donor_login();
require_once __DIR__ . '/../includes/header.php';

$donor_id = $_SESSION['donor_id'];

// Count requests received
$count_requests = 0;
$stmt = $mysqli->prepare("SELECT COUNT(*) FROM blood_requests WHERE donor_id = ?");
$stmt->bind_param('i', $donor_id);
$stmt->execute();
$stmt->bind_result($count_requests);
$stmt->fetch();
$stmt->close();
?>
<h1 class="mb-4">Welcome, <?php echo e($_SESSION['donor_name']); ?></h1>
<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5>Your Profile</h5>
                <p class="text-muted">Update your contact details and availability.</p>
                <a href="profile.php" class="btn btn-outline-danger btn-sm">Manage Profile</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5>Requests Received</h5>
                <h3><?php echo $count_requests; ?></h3>
                <p class="text-muted">Total patient requests received so far.</p>
                <a href="requests.php" class="btn btn-outline-danger btn-sm">View Requests</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5>Security</h5>
                <p class="text-muted">Change your password regularly to keep your account secure.</p>
                <a href="change-password.php" class="btn btn-outline-danger btn-sm">Change Password</a>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
