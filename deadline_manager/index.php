<?php
/* Owned by: [Diego] — Presenter: [Diego] / Backup: [Caleb]
   Simple landing page; redirects to login or dashboard depending on session.
*/
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Deadline Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center" style="min-height:100vh;">
<div class="container text-center">
    <h1 class="mb-4">Deadline Manager</h1>
    <p class="mb-4">Student project demo</p>
    <a href="auth/register.php" class="btn btn-primary me-2">Register</a>
    <a href="auth/login.php" class="btn btn-outline-primary">Login</a>
</div>
</body>
</html>
