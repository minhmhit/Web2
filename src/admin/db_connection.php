<?php
$host = 'localhost';
$dbname = 'bangiay_db2';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;port=3306;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}

function connectdb() {
    global $host, $dbname, $username, $password;
    try {
        $pdo = new PDO("mysql:host=$host;port=3307;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Kết nối thất bại: " . $e->getMessage());
    }
}

function getAll ($sql) {
    $pdo = connectdb();
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $arrproduct = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $pdo = null;
    return $arrproduct;
}
function executeQuery($sql, $params = []) {
    $pdo = connectdb();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $pdo = null;
    return $data;
}
