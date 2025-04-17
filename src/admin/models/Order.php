<?php
class Order
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT o.*, u.Fullname AS UserFullname, u.Email AS UserEmail, u.PhoneNumber AS UserPhoneNumber,
                                  e.Fullname AS EmployeeFullname
                                  FROM `orders` o 
                                  LEFT JOIN `user` u ON o.UserID = u.UserID 
                                  LEFT JOIN `employee` e ON o.SaleID = e.EmployeeID");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT o.*, u.Fullname AS UserFullname, u.Email AS UserEmail, u.PhoneNumber AS UserPhoneNumber,
                                   e.Fullname AS EmployeeFullname,
                                   (SELECT SUM(od.UnitPrice * od.Quantity) FROM `orderdetail` od WHERE od.OrderID = o.OrderID) AS Total
                                   FROM `orders` o 
                                   LEFT JOIN `user` u ON o.UserID = u.UserID 
                                   LEFT JOIN `employee` e ON o.SaleID = e.EmployeeID
                                   WHERE o.OrderID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO `order` (UserID, ShippingAddress, ProvinceID, DistrictID, WardID, Status, SaleID, WarehouseID) 
                                     VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['UserID'],
            $data['ShippingAddress'],
            $data['ProvinceID'],
            $data['DistrictID'],
            $data['WardID'],
            $data['Status'] ?? 'Pending',
            $data['SaleID'] ?? null,
            $data['WarehouseID'] ?? null,
            $data['ExportDate'] ?? null
            
        ]);
        return $this->pdo->lastInsertId();
    }

    public function updateStatus($id, $status)
    {
        $stmt = $this->pdo->prepare("UPDATE `orders` SET Status = ? WHERE OrderID = ?");
        $stmt->execute([$status, $id]);
    }

    public function getOrderDetails($orderId)
    {
        $stmt = $this->pdo->prepare("SELECT od.*, p.ProductName, p.ImageURL 
                                    FROM `orderdetail` od
                                    JOIN `product` p ON od.ProductSizeID = p.ProductID
                                    WHERE od.OrderID = ?");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
