<?php
require_once __DIR__ . '/includes/admin_header.php';

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $mysqli->query("DELETE FROM contact_queries WHERE id = " . $id);
}

$result = $mysqli->query("SELECT id, name, email, phone, message, created_at FROM contact_queries ORDER BY created_at DESC");
?>
<h1 class="mb-4">Contact Us Queries</h1>
<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Message</th>
                        <th>Submitted On</th>
                        <th width="80">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo e($row['id']); ?></td>
                            <td><?php echo e($row['name']); ?></td>
                            <td><?php echo e($row['email']); ?></td>
                            <td><?php echo e($row['phone']); ?></td>
                            <td><?php echo nl2br(e($row['message'])); ?></td>
                            <td><?php echo e($row['created_at']); ?></td>
                            <td>
                                <a href="?delete=<?php echo e($row['id']); ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this query?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center">No queries found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
