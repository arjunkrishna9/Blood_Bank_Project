<?php
require_once __DIR__ . '/includes/admin_header.php';

// basic counts
$total_blood_groups = $mysqli->query("SELECT COUNT(*) AS c FROM blood_groups")->fetch_assoc()['c'] ?? 0;
$total_donors = $mysqli->query("SELECT COUNT(*) AS c FROM donors")->fetch_assoc()['c'] ?? 0;
$total_requests = $mysqli->query("SELECT COUNT(*) AS c FROM blood_requests")->fetch_assoc()['c'] ?? 0;
$total_queries = $mysqli->query("SELECT COUNT(*) AS c FROM contact_queries")->fetch_assoc()['c'] ?? 0;
?>
<h1 class="mb-4">Dashboard Overview</h1>
<div class="row g-4">
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted text-uppercase">Blood Groups</h6>
                <h3><?php echo $total_blood_groups; ?></h3>
                <p class="small text-muted mb-0">Total blood groups listed.</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted text-uppercase">Registered Donors</h6>
                <h3><?php echo $total_donors; ?></h3>
                <p class="small text-muted mb-0">Active donors in the system.</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted text-uppercase">Blood Requests</h6>
                <h3><?php echo $total_requests; ?></h3>
                <p class="small text-muted mb-0">Requests sent to donors.</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted text-uppercase">Contact Queries</h6>
                <h3><?php echo $total_queries; ?></h3>
                <p class="small text-muted mb-0">Queries received via website.</p>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
