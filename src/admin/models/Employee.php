<?php
class Employee {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT e.*, p.PermissionName 
                                   FROM employee e 
                                   LEFT JOIN permission p ON e.PermissionID = p.PermissionID 
                                   WHERE e.isActivate = 1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM employee WHERE EmployeeID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($data) {
        $stmt = $this->pdo->prepare("INSERT INTO employee (Username, Fullname, PhoneNumber, Email, Address, PasswordHash, PermissionID, isActivate) 
                                     VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['Username'], 
            $data['Fullname'], 
            $data['PhoneNumber'], 
            $data['Email'], 
            $data['Address'], 
            password_hash($data['Password'], PASSWORD_DEFAULT), 
            $data['PermissionID'], 
            $data['isActivate']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE employee 
                                     SET Fullname = ?, PhoneNumber = ?, Email = ?, Address = ?, PermissionID = ?, isActivate = ? 
                                     WHERE EmployeeID = ?");
        $stmt->execute([
            $data['Fullname'], 
            $data['PhoneNumber'], 
            $data['Email'], 
            $data['Address'], 
            $data['PermissionID'], 
            $data['isActivate'], 
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("UPDATE employee SET isActivate = 0 WHERE EmployeeID = ?");
        $stmt->execute([$id]);
    }
}