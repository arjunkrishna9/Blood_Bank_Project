<?php
require_once __DIR__ . '/includes/admin_header.php';

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contact_email = trim($_POST['contact_email'] ?? '');
    $contact_phone = trim($_POST['contact_phone'] ?? '');
    $contact_address = trim($_POST['contact_address'] ?? '');

    $stmt = $mysqli->prepare("INSERT INTO site_settings (id, contact_email, contact_phone, contact_address) 
                              VALUES (1, ?, ?, ?)
                              ON DUPLICATE KEY UPDATE contact_email = VALUES(contact_email),
                                                      contact_phone = VALUES(contact_phone),
                                                      contact_address = VALUES(contact_address)");
    $stmt->bind_param('sss', $contact_email, $contact_phone, $contact_address);
    if ($stmt->execute()) {
        $success = "Contact information updated.";
    } else {
        $error = "Failed to update contact information.";
    }
    $stmt->close();
}

// fetch existing
$contact_email = $contact_phone = $contact_address = "";
$res = $mysqli->query("SELECT contact_email, contact_phone, contact_address FROM site_settings WHERE id = 1");
if ($res && $row = $res->fetch_assoc()) {
    $contact_email = $row['contact_email'];
    $contact_phone = $row['contact_phone'];
    $contact_address = $row['contact_address'];
}
?>
<h1 class="mb-4">Update Contact Information</h1>
<div class="card shadow-sm">
    <div class="card-body">
        <?php if ($success): ?><div class="alert alert-success"><?php echo e($success); ?></div><?php endif; ?>
        <?php if ($error): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>
        <form method="post" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Contact Email</label>
                <input type="email" name="contact_email" class="form-control" value="<?php echo e($contact_email); ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Contact Phone</label>
                <input type="text" name="contact_phone" class="form-control" value="<?php echo e($contact_phone); ?>">
            </div>
            <div class="col-12">
                <label class="form-label">Contact Address</label>
                <textarea name="contact_address" class="form-control" rows="4"><?php echo e($contact_address); ?></textarea>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-danger">Save Contact Info</button>
            </div>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
