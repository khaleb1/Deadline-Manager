<?php
/* Owned by: [Amina] — Presenter: [Amina]
   Simple PDO connection helper. Replace config.php with real secrets.
*/
// Prefer a local config.php; if it doesn't exist, fall back to config.example.php
$configPath = __DIR__ . '/config.php';
if (!file_exists($configPath)) {
    $configPath = __DIR__ . '/config.example.php';
}
$config = require $configPath;

try {
    $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4";
    $pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    // In production, do not echo errors. For student demo, show minimal info.
    echo "Database connection failed: " . htmlspecialchars($e->getMessage());
    exit;
}

return $pdo;
