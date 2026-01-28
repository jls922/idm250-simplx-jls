<?php
// database connection settings for my own phpmyadmin and MAMP ONLY.... once i find the drexel admin thing again ill do it there
$host = 'localhost';
$dbname = 'simplx_db';
$username = 'root';
$password = 'root'; 
// MAMP pass is root... not empty

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!-- <////?php
$host = 'localhost';  // whatever drexel provides
$dbname = 'your_drexel_database_name';
$username = 'your_drexel_username';
$password = 'your_drexel_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage())////;
}
?> -->