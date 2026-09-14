<?php
require_once __DIR__ . '/includes/admin_header.php';

$sql = "SELECT r.id, r.patient_name, r.patient_email, r.patient_phone, r.city, r.message, r.created_at,
               d.full_name AS donor_name, bg.name AS blood_group
        FROM blood_requests r
        JOIN donors d ON r.donor_id = d.id
        JOIN blood_groups bg ON d.blood_group_id = bg.id
        ORDER BY r.created_at DESC";
$result = $mysqli->query($sql);
?>
<h1 class="mb-4">Requests Received by Donors</h1>
<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Donor</th>
                        <th>Blood Group</th>
                        <th>Patient</th>
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
                            <td><?php echo e($row['id']); ?></td>
                            <td><?php echo e($row['donor_name']); ?></td>
                            <td><span class="badge bg-danger"><?php echo e($row['blood_group']); ?></span></td>
                            <td><?php echo e($row['patient_name']); ?></td>
                            <td><?php echo e($row['patient_email']); ?></td>
                            <td><?php echo e($row['patient_phone']); ?></td>
                            <td><?php echo e($row['city']); ?></td>
                            <td><?php echo nl2br(e($row['message'])); ?></td>
                            <td><?php echo e($row['created_at']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="9" class="text-center">No requests found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
