<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM user WHERE isActivate = 1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE UserID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE user 
                                     SET Fullname = ?, PhoneNumber = ?, Email = ?, Address = ?, isActivate = ? 
                                     WHERE UserID = ?");
        $stmt->execute([
            $data['Fullname'], 
            $data['PhoneNumber'], 
            $data['Email'], 
            $data['Address'], 
            $data['isActivate'], 
            $id
        ]);
    }
}