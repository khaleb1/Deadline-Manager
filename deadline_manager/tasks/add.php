<?php
/* Owned by: [Marcel] — Presenter: [Marcel] */
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}
$pdo = require __DIR__ . '/../db.php';
$userId = $_SESSION['user_id'];

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $deadline = $_POST['deadline'] ?? null;
    $urgency = $_POST['urgency'] ?? 'GREY';

    if ($title === '') $errors[] = 'Title is required.';

    if (empty($errors)) {
        $stmt = $pdo->prepare('INSERT INTO tasks (user_id, title, description, deadline, urgency) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$userId, $title, $description, $deadline, $urgency]);
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
    <title>Add Task - Deadline Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4" style="max-width:700px;">
    <h2>Add Task</h2>
    <?php if ($errors): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars(implode('<br>', $errors)); ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Deadline</label>
            <input name="deadline" type="datetime-local" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Urgency</label>
            <select name="urgency" class="form-select">
                <option value="GREY">GREY</option>
                <option value="BLUE">BLUE</option>
                <option value="RED">RED</option>
            </select>
        </div>
        <button class="btn btn-success">Add Task</button>
        <a href="../dashboard.php" class="btn btn-link">Back</a>
    </form>
</div>
</body>
</html>
