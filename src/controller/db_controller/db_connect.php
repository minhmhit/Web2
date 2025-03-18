<?php

    function connectdb() {
        $host = 'localhost'; 
        $dbname = 'broshoes'; 
        $username = 'root'; 
        $password = ''; 

        try {
            $pdo = new PDO("mysql:host=$host;port=3307;dbname=$dbname;charset=utf8", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo 'kết nối thành công';
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
        return $pdo;
    }


    function getAll ($sql) {
        $pdo = connectdb();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $arrproduct = $stmt->fetchAll();
        $pdo = null;
        return $arrproduct;
    }

    function getOne ($sql) {
        $pdo = connectdb();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $arrproduct = $stmt->fetch();
        $pdo = null;
        return $arrproduct;
    }

?>