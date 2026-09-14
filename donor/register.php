<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/header.php';

$success = $error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $blood_group_id = intval($_POST['blood_group_id'] ?? 0);
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    if ($full_name && $email && $city && $blood_group_id && $password) {
        if ($password !== $confirm_password) {
            $error = "Password and Confirm Password do not match.";
        } else {
            // check if email already exists
            $stmt = $mysqli->prepare("SELECT id FROM donors WHERE email = ? LIMIT 1");
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $error = "Email is already registered as donor.";
            } else {
                $stmt->close();
                $password_hash = md5($password); // simple hashing for demo
                $stmt = $mysqli->prepare("INSERT INTO donors (full_name, email, phone, city, blood_group_id, password_hash) VALUES (?, ?, ?, ?, ?, ?)");
                if ($stmt) {
                    $stmt->bind_param('ssssis', $full_name, $email, $phone, $city, $blood_group_id, $password_hash);
                    if ($stmt->execute()) {
                        $success = "Registration successful. You can now login.";
                    } else {
                        $error = "Failed to register. Please try again.";
                    }
                    $stmt->close();
                } else {
                    $error = "Unexpected error. Please try again.";
                }
            }
        }
    } else {
        $error = "All fields marked with * are required.";
    }
}
?>
<h1 class="mb-4">Donor Registration</h1>
<div class="card shadow-sm">
    <div class="card-body">
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo e($success); ?></div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger"><?php echo e($error); ?></div>
        <?php endif; ?>
        <form method="post" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Full Name *</label>
                <input type="text" name="full_name" class="form-control" required value="<?php echo isset($_POST['full_name']) ? e($_POST['full_name']) : ''; ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Email *</label>
                <input type="email" name="email" class="form-control" required value="<?php echo isset($_POST['email']) ? e($_POST['email']) : ''; ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="<?php echo isset($_POST['phone']) ? e($_POST['phone']) : ''; ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">City *</label>
                <input type="text" name="city" class="form-control" required value="<?php echo isset($_POST['city']) ? e($_POST['city']) : ''; ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Blood Group *</label>
                <select name="blood_group_id" class="form-select" required>
                    <option value="">Select Blood Group</option>
                    <?php
                    $resultBg = $mysqli->query("SELECT id, name FROM blood_groups ORDER BY name");
                    if ($resultBg) {
                        while ($row = $resultBg->fetch_assoc()) {
                            $selected = (isset($_POST['blood_group_id']) && $_POST['blood_group_id'] == $row['id']) ? 'selected' : '';
                            echo '<option value="' . e($row['id']) . '" ' . $selected . '>' . e($row['name']) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Password *</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Confirm Password *</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-danger">Register</button>
                <a href="login.php" class="btn btn-link">Already registered? Login</a>
            </div>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
