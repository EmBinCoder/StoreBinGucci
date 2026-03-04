<?php
require_once __DIR__ . '/app/config/database.php';
$db = (new Database())->getConnection();
$db->exec("set names utf8mb4");

// Create users table
$db->exec("
CREATE TABLE IF NOT EXISTS users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(100) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    fullname    VARCHAR(200) DEFAULT '',
    role        ENUM('admin','customer') NOT NULL DEFAULT 'customer',
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");
echo "Table 'users' ready.\n";

// Seed admin
$adminPass = password_hash('Admin@123', PASSWORD_DEFAULT);
$stmt = $db->prepare("INSERT IGNORE INTO users (username, password, fullname, role) VALUES (:u, :p, :f, 'admin')");
$stmt->execute([':u' => 'admin', ':p' => $adminPass, ':f' => 'Quản trị viên']);
echo "Admin seeded (username=admin, password=Admin@123)\n";

// Show all users
$users = $db->query("SELECT id, username, role FROM users")->fetchAll(PDO::FETCH_OBJ);
echo "\nAll users:\n";
foreach ($users as $u) echo "  id={$u->id} username={$u->username} role={$u->role}\n";
echo "Done.\n";
