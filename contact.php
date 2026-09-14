<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';

$success = $error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name && $email && $message) {
        $stmt = $mysqli->prepare("INSERT INTO contact_queries (name, email, phone, message) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param('ssss', $name, $email, $phone, $message);
            if ($stmt->execute()) {
                $success = "Your query has been submitted. We will get back to you soon.";
            } else {
                $error = "Failed to submit your query. Please try again.";
            }
            $stmt->close();
        } else {
            $error = "Unexpected error. Please try again.";
        }
    } else {
        $error = "Name, Email and Message are required.";
    }
}

// fetch contact info from settings
$contact_email = $contact_phone = $contact_address = "";
$res = $mysqli->query("SELECT contact_email, contact_phone, contact_address FROM site_settings WHERE id = 1");
if ($res && $row = $res->fetch_assoc()) {
    $contact_email = $row['contact_email'];
    $contact_phone = $row['contact_phone'];
    $contact_address = $row['contact_address'];
}
?>
<h1 class="mb-4">Contact Us</h1>
<div class="row g-4">
    <div class="col-md-6">
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo e($success); ?></div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger"><?php echo e($error); ?></div>
        <?php endif; ?>
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Name *</label>
                        <input type="text" name="name" class="form-control" required value="<?php echo isset($_POST['name']) ? e($_POST['name']) : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control" required value="<?php echo isset($_POST['email']) ? e($_POST['email']) : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="<?php echo isset($_POST['phone']) ? e($_POST['phone']) : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message *</label>
                        <textarea name="message" class="form-control" rows="4" required><?php echo isset($_POST['message']) ? e($_POST['message']) : ''; ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger">Submit Query</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5>Contact Information</h5>
                <p><strong>Email:</strong> <?php echo e($contact_email ?: 'info@bloodbankpro.local'); ?></p>
                <p><strong>Phone:</strong> <?php echo e($contact_phone ?: '+91-XXXXXXXXXX'); ?></p>
                <p><strong>Address:</strong><br><?php echo nl2br(e($contact_address ?: 'Your City, Your State, India')); ?></p>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
