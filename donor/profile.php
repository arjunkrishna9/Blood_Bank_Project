<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_donor_login();
require_once __DIR__ . '/../includes/header.php';

$donor_id = $_SESSION['donor_id'];
$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $blood_group_id = intval($_POST['blood_group_id'] ?? 0);

    if ($full_name && $city && $blood_group_id) {
        $stmt = $mysqli->prepare("UPDATE donors SET full_name = ?, phone = ?, city = ?, blood_group_id = ? WHERE id = ?");
        $stmt->bind_param('sssii', $full_name, $phone, $city, $blood_group_id, $donor_id);
        if ($stmt->execute()) {
            $_SESSION['donor_name'] = $full_name;
            $success = "Profile updated successfully.";
        } else {
            $error = "Failed to update profile.";
        }
        $stmt->close();
    } else {
        $error = "Name, City and Blood Group are required.";
    }
}

// fetch current data
$stmt = $mysqli->prepare("SELECT full_name, email, phone, city, blood_group_id FROM donors WHERE id = ?");
$stmt->bind_param('i', $donor_id);
$stmt->execute();
$stmt->bind_result($full_name, $email, $phone, $city, $blood_group_id);
$stmt->fetch();
$stmt->close();
?>
<h1 class="mb-4">My Profile</h1>
<div class="card shadow-sm">
    <div class="card-body">
        <?php if ($success): ?><div class="alert alert-success"><?php echo e($success); ?></div><?php endif; ?>
        <?php if ($error): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>
        <form method="post" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Full Name *</label>
                <input type="text" name="full_name" class="form-control" required value="<?php echo e($full_name); ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Email (read-only)</label>
                <input type="email" class="form-control" value="<?php echo e($email); ?>" disabled>
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="<?php echo e($phone); ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">City *</label>
                <input type="text" name="city" class="form-control" required value="<?php echo e($city); ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Blood Group *</label>
                <select name="blood_group_id" class="form-select" required>
                    <option value="">Select Blood Group</option>
                    <?php
                    $resultBg = $mysqli->query("SELECT id, name FROM blood_groups ORDER BY name");
                    if ($resultBg) {
                        while ($row = $resultBg->fetch_assoc()) {
                            $selected = ($blood_group_id == $row['id']) ? 'selected' : '';
                            echo '<option value="' . e($row['id']) . '" ' . $selected . '>' . e($row['name']) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-danger">Save Changes</button>
            </div>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
