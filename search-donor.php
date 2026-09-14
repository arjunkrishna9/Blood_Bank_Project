<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';

$city = trim($_GET['city'] ?? '');
$blood_group_id = trim($_GET['blood_group'] ?? '');
$donors = [];
if ($city && $blood_group_id) {
    $stmt = $mysqli->prepare("SELECT d.id, d.full_name, d.city, d.phone, d.email, bg.name AS blood_group
                              FROM donors d
                              JOIN blood_groups bg ON d.blood_group_id = bg.id
                              WHERE d.city LIKE CONCAT('%', ?, '%') AND d.blood_group_id = ? AND d.is_hidden = 0");
    if ($stmt) {
        $stmt->bind_param('si', $city, $blood_group_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $donors[] = $row;
        }
        $stmt->close();
    }
}
?>
<h1 class="mb-4">Search Donor</h1>
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="search-donor.php" method="get" class="row g-3">
            <div class="col-md-5">
                <label class="form-label">City</label>
                <input type="text" name="city" class="form-control" required value="<?php echo e($city); ?>">
            </div>
            <div class="col-md-5">
                <label class="form-label">Blood Group</label>
                <select name="blood_group" class="form-select" required>
                    <option value="">Select Blood Group</option>
                    <?php
                    $resultBg = $mysqli->query("SELECT id, name FROM blood_groups ORDER BY name");
                    if ($resultBg) {
                        while ($row = $resultBg->fetch_assoc()) {
                            $selected = ($blood_group_id == $row['id']) ? 'selected' : '';
                            echo '<option value="' . e($row['id']) . '" ' . $selected . '>' . e($row['name']) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-danger w-100">Search</button>
            </div>
        </form>
    </div>
</div>
<?php if ($city && $blood_group_id): ?>
<div class="card shadow-sm">
    <div class="card-body">
        <h5>Search Results</h5>
        <div class="table-responsive mt-3">
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
                <?php if (count($donors) > 0): ?>
                    <?php foreach ($donors as $d): ?>
                        <tr>
                            <td><?php echo e($d['full_name']); ?></td>
                            <td><span class="badge bg-danger"><?php echo e($d['blood_group']); ?></span></td>
                            <td><?php echo e($d['city']); ?></td>
                            <td><?php echo e($d['phone']); ?></td>
                            <td><?php echo e($d['email']); ?></td>
                            <td><a href="request-blood.php?donor_id=<?php echo e($d['id']); ?>" class="btn btn-sm btn-outline-danger">Request</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center">No donors found for this search. Please contact life-saving helpline numbers in your city.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
