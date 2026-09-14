<?php
require_once __DIR__ . '/includes/admin_header.php';

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    if ($name) {
        $stmt = $mysqli->prepare("INSERT INTO blood_groups (name) VALUES (?)");
        $stmt->bind_param('s', $name);
        if ($stmt->execute()) {
            $success = "Blood group added.";
        } else {
            $error = "Failed to add blood group.";
        }
        $stmt->close();
    } else {
        $error = "Blood group name is required.";
    }
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $mysqli->query("DELETE FROM blood_groups WHERE id = " . $id);
    $success = "Blood group deleted.";
}

$result = $mysqli->query("SELECT id, name FROM blood_groups ORDER BY name");
?>
<h1 class="mb-4">Manage Blood Groups</h1>
<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5>Add Blood Group</h5>
                <?php if ($success): ?><div class="alert alert-success"><?php echo e($success); ?></div><?php endif; ?>
                <?php if ($error): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Blood Group Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g., A+, O-" required>
                    </div>
                    <button type="submit" class="btn btn-danger">Add</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5>Existing Blood Groups</h5>
                <div class="table-responsive mt-3">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th width="120">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo e($row['id']); ?></td>
                                    <td><?php echo e($row['name']); ?></td>
                                    <td>
                                        <a href="?delete=<?php echo e($row['id']); ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this blood group?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="3" class="text-center">No blood groups found.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
