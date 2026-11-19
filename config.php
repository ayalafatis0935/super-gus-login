<?php
// Completa estos datos con los que proporciona tu hosting o XAMPP.
define('DB_HOST', 'localhost');
define('DB_NAME', 'super_gus');
define('DB_USER', 'root');
define('DB_PASS', '');
define('APP_NAME', 'Super Gus');
session_start();
function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
    }
    return $pdo;
}
function h($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function require_login(): void {
    if (empty($_SESSION['user_id'])) { header('Location: index.php'); exit; }
}
