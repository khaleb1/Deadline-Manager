<?php
/* Owned by: [Diego] — Presenter: [Diego] / Backup: [Marcel]
   Simple dashboard showing a user's tasks and a link to manage tasks.
*/
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit;
}
$pdo = require __DIR__ . '/db.php';
$userId = $_SESSION['user_id'];

// Fetch tasks for user
$stmt = $pdo->prepare('SELECT * FROM tasks WHERE user_id = ? ORDER BY deadline ASC');
$stmt->execute([$userId]);
$tasks = $stmt->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Deadline Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Your Tasks</h2>
        <div>
            <a href="tasks/add.php" class="btn btn-success">Add Task</a>
            <a href="auth/logout.php" class="btn btn-outline-secondary">Logout</a>
        </div>
    </div>
    <hr>
    <?php if (empty($tasks)): ?>
        <p>No tasks yet. <a href="tasks/add.php">Create one</a>.</p>
    <?php else: ?>
        <div class="list-group">
            <?php foreach ($tasks as $t): ?>
                <?php
                    $badgeClass = 'secondary';
                    if ($t['urgency'] === 'RED') $badgeClass = 'danger';
                    if ($t['urgency'] === 'BLUE') $badgeClass = 'primary';
                ?>
                <div class="list-group-item d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fw-bold"><?php echo htmlspecialchars($t['title']); ?></div>
                        <div class="small text-muted"><?php echo htmlspecialchars($t['description']); ?></div>
                        <div class="small">Deadline: <?php echo htmlspecialchars($t['deadline']); ?></div>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-<?php echo $badgeClass; ?> mb-2"><?php echo htmlspecialchars($t['urgency']); ?></span>
                        <div>
                            <a href="tasks/edit.php?id=<?php echo $t['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                            <a href="tasks/delete.php?id=<?php echo $t['id']; ?>" class="btn btn-sm btn-outline-danger">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
