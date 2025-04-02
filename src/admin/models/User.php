<?php
require_once 'db_connection.php'; 

class User {
    private $pdo;

    public function __construct() {
        global $pdo;  
        $this->pdo = $pdo;
    }
    public function add($data) {
        $stmt = $this->pdo->prepare("INSERT INTO user (Username, Fullname, PhoneNumber, Email, Address, PasswordHash, isActivate) 
                                     VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['Username'], 
            $data['Fullname'], 
            $data['PhoneNumber'], 
            $data['Email'], 
            $data['Address'], 
            $data['PasswordHash'], 
            $data['isActivate']
        ]);
    }

    public function update($data) {
        $stmt = $this->pdo->prepare("UPDATE user SET Fullname = ?, PhoneNumber = ?, Email = ?, Address = ?, isActivate = ? 
                                     WHERE UserID = ?");
        $stmt->execute([
            $data['Fullname'], 
            $data['PhoneNumber'], 
            $data['Email'], 
            $data['Address'], 
            $data['isActivate'], 
            $data['UserID']
        ]);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE UserID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM user");
        return $stmt->fetchAll();
    }
}