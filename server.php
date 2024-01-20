<?php

$host = 'localhost';
$dbname = 'blog';
$user = 'root';
$password = '';


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'blog');

?>
