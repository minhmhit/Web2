<?php
class Import {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT i.*, e.Fullname AS EmployeeFullname 
                                   FROM import i 
                                   JOIN employee e ON i.EmployeeID = e.EmployeeID");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($data) {
        $stmt = $this->pdo->prepare("INSERT INTO import (EmployeeID, Total) VALUES (?, ?)");
        $stmt->execute([$data['EmployeeID'], $data['Total']]);
        return $this->pdo->lastInsertId();
    }
}