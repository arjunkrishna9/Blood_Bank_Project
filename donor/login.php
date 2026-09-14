<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/header.php';

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    if ($email && $password) {
        $stmt = $mysqli->prepare("SELECT id, full_name, password_hash FROM donors WHERE email = ? AND is_hidden = 0 LIMIT 1");
        if ($stmt) {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->bind_result($id, $full_name, $password_hash);
            if ($stmt->fetch()) {
                if ($password_hash === md5($password)) {
                    $_SESSION['donor_id'] = $id;
                    $_SESSION['donor_name'] = $full_name;
                    redirect('dashboard.php');
                } else {
                    $error = "Invalid email or password.";
                }
            } else {
                $error = "Invalid email or password.";
            }
            $stmt->close();
        } else {
            $error = "Unexpected error. Please try again.";
        }
    } else {
        $error = "Email and Password are required.";
    }
}
?>
<h1 class="mb-4">Donor Login</h1>
<div class="card shadow-sm">
    <div class="card-body">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo e($error); ?></div>
        <?php endif; ?>
        <form method="post" class="row g-3">
            <div class="col-md-12">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required value="<?php echo isset($_POST['email']) ? e($_POST['email']) : ''; ?>">
            </div>
            <div class="col-md-12">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-danger">Login</button>
                <a href="register.php" class="btn btn-link">New donor? Register</a>
            </div>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
