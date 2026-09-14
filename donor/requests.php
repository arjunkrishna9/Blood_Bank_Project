<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_donor_login();
require_once __DIR__ . '/../includes/header.php';

$donor_id = $_SESSION['donor_id'];
$stmt = $mysqli->prepare("SELECT patient_name, patient_email, patient_phone, city, message, created_at 
                          FROM blood_requests 
                          WHERE donor_id = ? ORDER BY created_at DESC");
$stmt->bind_param('i', $donor_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<h1 class="mb-4">Requests Received</h1>
<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>City</th>
                        <th>Message</th>
                        <th>Requested On</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo e($row['patient_name']); ?></td>
                            <td><?php echo e($row['patient_email']); ?></td>
                            <td><?php echo e($row['patient_phone']); ?></td>
                            <td><?php echo e($row['city']); ?></td>
                            <td><?php echo nl2br(e($row['message'])); ?></td>
                            <td><?php echo e($row['created_at']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center">No requests found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
$stmt->close();
require_once __DIR__ . '/../includes/footer.php';
?>
