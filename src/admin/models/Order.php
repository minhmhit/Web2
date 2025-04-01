<?php
class Order {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT o.*, u.Fullname AS UserFullname, e.Fullname AS EmployeeFullname 
                                   FROM orders o 
                                   LEFT JOIN user u ON o.UserID = u.UserID 
                                   LEFT JOIN employee e ON o.EmployeeID = e.EmployeeID");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE OrderID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($data) {
        $stmt = $this->pdo->prepare("INSERT INTO orders (UserID, ShippingAddress, Province, Ward, PaymentStatus) 
                                     VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['UserID'], 
            $data['ShippingAddress'], 
            $data['Province'], 
            $data['Ward'], 
            $data['PaymentStatus'] ?? 'Pending'
        ]);
        return $this->pdo->lastInsertId();
    }

    public function updateStatus($id, $status) {
        $stmt = $this->pdo->prepare("UPDATE orders SET PaymentStatus = ? WHERE OrderID = ?");
        $stmt->execute([$status, $id]);
    }
}