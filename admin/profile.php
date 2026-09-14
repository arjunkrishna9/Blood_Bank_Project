<?php
require_once __DIR__ . '/includes/admin_header.php';

$admin_id = $_SESSION['admin_id'];
$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    if ($full_name && $email) {
        $stmt = $mysqli->prepare("UPDATE admins SET full_name = ?, email = ? WHERE id = ?");
        $stmt->bind_param('ssi', $full_name, $email, $admin_id);
        if ($stmt->execute()) {
            $_SESSION['admin_name'] = $full_name;
            $success = "Profile updated.";
        } else {
            $error = "Failed to update profile.";
        }
        $stmt->close();
    } else {
        $error = "Name and Email are required.";
    }
}

$stmt = $mysqli->prepare("SELECT username, full_name, email FROM admins WHERE id = ?");
$stmt->bind_param('i', $admin_id);
$stmt->execute();
$stmt->bind_result($username, $full_name, $email);
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
                <label class="form-label">Username (read-only)</label>
                <input type="text" class="form-control" value="<?php echo e($username); ?>" disabled>
            </div>
            <div class="col-md-6">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" required value="<?php echo e($full_name); ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required value="<?php echo e($email); ?>">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-danger">Save Changes</button>
            </div>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
