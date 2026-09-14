<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';

$sql = "SELECT d.id, d.full_name, d.city, d.phone, d.email, bg.name AS blood_group 
        FROM donors d 
        JOIN blood_groups bg ON d.blood_group_id = bg.id 
        WHERE d.is_hidden = 0
        ORDER BY d.city, bg.name, d.full_name";
$result = $mysqli->query($sql);
?>
<h1 class="mb-4">Registered Donors</h1>
<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Blood Group</th>
                        <th>City</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Request Blood</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo e($row['full_name']); ?></td>
                            <td><span class="badge bg-danger"><?php echo e($row['blood_group']); ?></span></td>
                            <td><?php echo e($row['city']); ?></td>
                            <td><?php echo e($row['phone']); ?></td>
                            <td><?php echo e($row['email']); ?></td>
                            <td>
                                <a href="request-blood.php?donor_id=<?php echo e($row['id']); ?>" class="btn btn-sm btn-outline-danger">Request</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center">No donors found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
