<?php
$host = 'localhost'; 
$dbname = 'bangiay_db'; 
$username = 'root'; 
$password = ''; 
$port=3306;
try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo 'kết nối thành công';
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
return $pdo;
?>