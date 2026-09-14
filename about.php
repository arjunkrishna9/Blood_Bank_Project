<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';

$content = "";
$stmt = $mysqli->prepare("SELECT content FROM pages WHERE slug = 'about' LIMIT 1");
if ($stmt) {
    $stmt->execute();
    $stmt->bind_result($content);
    $stmt->fetch();
    $stmt->close();
}
if (!$content) {
    $content = "BloodBankPro is a web-based Blood Bank & Donor Management System that connects voluntary donors with patients in need. It streamlines donor registration, search, and communication so that blood can reach the right person at the right time.";
}
?>
<h1 class="mb-4">About Us</h1>
<div class="card shadow-sm">
    <div class="card-body">
        <p><?php echo nl2br(e($content)); ?></p>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
