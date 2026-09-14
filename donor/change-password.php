<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_donor_login();
require_once __DIR__ . '/../includes/header.php';

$donor_id = $_SESSION['donor_id'];
$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = trim($_POST['current_password'] ?? '');
    $new_password = trim($_POST['new_password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    if ($new_password !== $confirm_password) {
        $error = "New password and confirm password do not match.";
    } else {
        $stmt = $mysqli->prepare("SELECT password_hash FROM donors WHERE id = ?");
        $stmt->bind_param('i', $donor_id);
        $stmt->execute();
        $stmt->bind_result($password_hash);
        if ($stmt->fetch()) {
            if ($password_hash === md5($current_password)) {
                $stmt->close();
                $new_hash = md5($new_password);
                $stmt = $mysqli->prepare("UPDATE donors SET password_hash = ? WHERE id = ?");
                $stmt->bind_param('si', $new_hash, $donor_id);
                if ($stmt->execute()) {
                    $success = "Password updated successfully.";
                } else {
                    $error = "Failed to update password.";
                }
                $stmt->close();
            } else {
                $error = "Current password is incorrect.";
                $stmt->close();
            }
        } else {
            $error = "Unexpected error.";
        }
    }
}
?>
<h1 class="mb-4">Change Password</h1>
<div class="card shadow-sm">
    <div class="card-body">
        <?php if ($success): ?><div class="alert alert-success"><?php echo e($success); ?></div><?php endif; ?>
        <?php if ($error): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>
        <form method="post" class="row g-3">
            <div class="col-md-12">
                <label class="form-label">Current Password</label>
                <input type="password" name="current_password" class="form-control" required>
            </div>
            <div class="col-md-12">
                <label class="form-label">New Password</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>
            <div class="col-md-12">
                <label class="form-label">Confirm New Password</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-danger">Update Password</button>
            </div>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
