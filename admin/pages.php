<?php
require_once __DIR__ . '/includes/admin_header.php';

$success = $error = "";
$slug = $_GET['slug'] ?? 'about';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $slug = $_POST['slug'];
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if ($title && $content) {
        // upsert
        $stmt = $mysqli->prepare("INSERT INTO pages (slug, title, content) VALUES (?, ?, ?)
                                  ON DUPLICATE KEY UPDATE title = VALUES(title), content = VALUES(content)");
        $stmt->bind_param('sss', $slug, $title, $content);
        if ($stmt->execute()) {
            $success = "Page content saved.";
        } else {
            $error = "Failed to save page.";
        }
        $stmt->close();
    } else {
        $error = "Title and content are required.";
    }
}

// fetch page
$title = $content = "";
$stmt = $mysqli->prepare("SELECT title, content FROM pages WHERE slug = ? LIMIT 1");
$stmt->bind_param('s', $slug);
$stmt->execute();
$stmt->bind_result($title, $content);
$stmt->fetch();
$stmt->close();
if (!$title) {
    $title = ucfirst($slug);
}
?>
<h1 class="mb-4">Manage Pages</h1>
<div class="mb-3">
    <a href="?slug=about" class="btn btn-sm btn-outline-danger">About Page</a>
</div>
<div class="card shadow-sm">
    <div class="card-body">
        <?php if ($success): ?><div class="alert alert-success"><?php echo e($success); ?></div><?php endif; ?>
        <?php if ($error): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>
        <form method="post">
            <input type="hidden" name="slug" value="<?php echo e($slug); ?>">
            <div class="mb-3">
                <label class="form-label">Page Title</label>
                <input type="text" name="title" class="form-control" required value="<?php echo e($title); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea name="content" class="form-control" rows="10" required><?php echo e($content); ?></textarea>
            </div>
            <button type="submit" class="btn btn-danger">Save Page</button>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
