<?php
require_once __DIR__ . '/includes/admin_header.php';

if (isset($_GET['hide'])) {
    $id = intval($_GET['hide']);
    $mysqli->query("UPDATE donors SET is_hidden = 1 WHERE id = " . $id);
}
if (isset($_GET['show'])) {
    $id = intval($_GET['show']);
    $mysqli->query("UPDATE donors SET is_hidden = 0 WHERE id = " . $id);
}
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $mysqli->query("DELETE FROM donors WHERE id = " . $id);
}

$sql = "SELECT d.id, d.full_name, d.email, d.phone, d.city, d.is_hidden, bg.name AS blood_group
        FROM donors d 
        JOIN blood_groups bg ON d.blood_group_id = bg.id
        ORDER BY d.created_at DESC";
$result = $mysqli->query($sql);
?>
<h1 class="mb-4">Donor List</h1>
<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Blood Group</th>
                        <th>City</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo e($row['id']); ?></td>
                            <td><?php echo e($row['full_name']); ?></td>
                            <td><span class="badge bg-danger"><?php echo e($row['blood_group']); ?></span></td>
                            <td><?php echo e($row['city']); ?></td>
                            <td><?php echo e($row['email']); ?></td>
                            <td><?php echo e($row['phone']); ?></td>
                            <td>
                                <?php if ($row['is_hidden']): ?>
                                    <span class="badge bg-secondary">Hidden</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Visible</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($row['is_hidden']): ?>
                                    <a href="?show=<?php echo e($row['id']); ?>" class="btn btn-sm btn-outline-success">Show</a>
                                <?php else: ?>
                                    <a href="?hide=<?php echo e($row['id']); ?>" class="btn btn-sm btn-outline-warning">Hide</a>
                                <?php endif; ?>
                                <a href="?delete=<?php echo e($row['id']); ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this donor?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="8" class="text-center">No donors found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
