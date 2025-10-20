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
if ($id) {
    $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = ? AND user_id = ?');
    $stmt->execute([$id, $userId]);
}
header('Location: ../dashboard.php');
exit;
