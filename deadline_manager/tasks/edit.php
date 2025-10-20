<?php
/* Owned by: [Marcel] — Presenter: [Marcel] */
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}
$pdo = require __DIR__ . '/../db.php';
$userId = $_SESSION['user_id'];

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: ../dashboard.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM tasks WHERE id = ? AND user_id = ?');
$stmt->execute([$id, $userId]);
$task = $stmt->fetch();
if (!$task) {
    header('Location: ../dashboard.php');
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $deadline = $_POST['deadline'] ?? null;
    $urgency = $_POST['urgency'] ?? 'GREY';

    if ($title === '') $errors[] = 'Title is required.';

    if (empty($errors)) {
        $stmt = $pdo->prepare('UPDATE tasks SET title = ?, description = ?, deadline = ?, urgency = ? WHERE id = ? AND user_id = ?');
        $stmt->execute([$title, $description, $deadline, $urgency, $id, $userId]);
        header('Location: ../dashboard.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Task - Deadline Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4" style="max-width:700px;">
    <h2>Edit Task</h2>
    <?php if ($errors): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars(implode('<br>', $errors)); ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input name="title" class="form-control" value="<?php echo htmlspecialchars($task['title']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control"><?php echo htmlspecialchars($task['description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Deadline</label>
            <input name="deadline" type="datetime-local" class="form-control" value="<?php echo $task['deadline'] ? date('Y-m-d\\TH:i', strtotime($task['deadline'])) : ''; ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Urgency</label>
            <select name="urgency" class="form-select">
                <option value="GREY" <?php echo $task['urgency'] === 'GREY' ? 'selected' : ''; ?>>GREY</option>
                <option value="BLUE" <?php echo $task['urgency'] === 'BLUE' ? 'selected' : ''; ?>>BLUE</option>
                <option value="RED" <?php echo $task['urgency'] === 'RED' ? 'selected' : ''; ?>>RED</option>
            </select>
        </div>
        <button class="btn btn-primary">Save</button>
        <a href="../dashboard.php" class="btn btn-link">Back</a>
    </form>
</div>
</body>
</html>
