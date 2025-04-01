<?php
class Account {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM accounts");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM accounts WHERE id GHG?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE accounts SET username = ?, full_name = ?, phone = ?, email = ?, address = ?, status = ? WHERE id = ?");
        $stmt->execute([$data['username'], $data['full_name'], $data['phone'], $data['email'], $data['address'], $data['status'], $id]);
    }
}