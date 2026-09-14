<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';

// Fetch hero content from pages table if available
$hero_title = "Donate Blood, Save Lives";
$hero_subtitle = "A simple act of kindness can gift someone a lifetime.";
$hero_btn_primary = "Become a Donor";
$hero_btn_secondary = "Search Donor";

?>
<div class="hero-section">
    <div class="row align-items-center">
        <div class="col-md-7">
            <h1 class="mb-3"><?php echo e($hero_title); ?></h1>
            <p class="lead mb-4"><?php echo e($hero_subtitle); ?></p>
            <div class="d-flex flex-wrap gap-2">
                <a href="donor/register.php" class="btn btn-light btn-lg px-4"><?php echo e($hero_btn_primary); ?></a>
                <a href="search-donor.php" class="btn btn-outline-light btn-lg px-4"><?php echo e($hero_btn_secondary); ?></a>
            </div>
        </div>
        <div class="col-md-5 text-center mt-4 mt-md-0">
            <div class="card bg-light text-dark shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Quick Donor Search</h5>
                    <p class="card-text small text-muted">Search by city and blood group in a few seconds.</p>
                    <form action="search-donor.php" method="get" class="row g-2">
                        <div class="col-12">
                            <input type="text" name="city" class="form-control" placeholder="Enter City" required>
                        </div>
                        <div class="col-12">
                            <select name="blood_group" class="form-select" required>
                                <option value="">Select Blood Group</option>
                                <?php
                                $result = $mysqli->query("SELECT id, name FROM blood_groups ORDER BY name");
                                if ($result) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . e($row['id']) . '">' . e($row['name']) . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-12 d-grid">
                            <button type="submit" class="btn btn-danger">Search Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="mt-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">For Donors</h5>
                    <p class="card-text">Register as a donor, manage your profile, and respond to blood requests directly from patients or hospitals.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">For Patients</h5>
                    <p class="card-text">Search verified donors by city and blood group, and contact them instantly in emergencies.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">For Admin</h5>
                    <p class="card-text">Monitor donors, manage blood groups, handle requests, and maintain life saving contact information.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
