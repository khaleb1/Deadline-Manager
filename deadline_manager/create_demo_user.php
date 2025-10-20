<?php
/* Owned by: [Amina] — Presenter: [Amina]
   Small script to create a demo user with a hashed password.
   Run from CLI: php create_demo_user.php
*/
require __DIR__ . '/db.php';
$pdo = require __DIR__ . '/db.php';

$username = 'demo';
$email = 'demo@example.com';
$password = password_hash('demo123', PASSWORD_DEFAULT);

$stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
try {
    $stmt->execute([$username, $email, $password]);
    echo "Demo user created.\n";
} catch (Exception $e) {
    echo "Could not create demo user: " . $e->getMessage() . "\n";
}
