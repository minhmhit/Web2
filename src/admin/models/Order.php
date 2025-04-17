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
                                   (SELECT SUM(od.Subtotal) FROM `orderdetail` od WHERE od.OrderID = o.OrderID) AS Total
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
        return true;
    }

    public function updateOrderInfo($id, $status, $total = null)
    {
        try {
            // Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
            $this->pdo->beginTransaction();

            // Nếu chỉ cập nhật trạng thái
            if ($total === null) {
                $stmt = $this->pdo->prepare("UPDATE `orders` SET Status = ? WHERE OrderID = ?");
                $stmt->execute([$status, $id]);
            }
            // Nếu cập nhật cả trạng thái và tổng tiền
            else {
                $stmt = $this->pdo->prepare("UPDATE `orders` SET Status = ? WHERE OrderID = ?");
                $stmt->execute([$status, $id]);

                // Cập nhật tổng tiền bằng cách điều chỉnh subtotal của mỗi chi tiết đơn hàng
                $details = $this->getOrderDetails($id);
                if (!empty($details)) {
                    // Tính tổng hiện tại
                    $currentTotal = 0;
                    foreach ($details as $detail) {
                        $currentTotal += $detail['Subtotal'];
                    }

                    if ($currentTotal > 0) {
                        // Tỷ lệ điều chỉnh
                        $ratio = $total / $currentTotal;

                        // Cập nhật mỗi chi tiết đơn hàng
                        $updateDetailStmt = $this->pdo->prepare("UPDATE `orderdetail` SET Subtotal = ? WHERE OrderID = ? AND ProductSizeID = ?");
                        foreach ($details as $detail) {
                            $newSubtotal = $detail['Subtotal'] * $ratio;
                            $updateDetailStmt->execute([$newSubtotal, $id, $detail['ProductSizeID']]);
                        }
                    }
                }
            }

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    public function getOrderDetails($orderId)
    {
        // Kiểm tra và debug dữ liệu
        $sql = "SELECT od.*, ps.size, p.ProductName, p.ImageURL 
                FROM `orderdetail` od
                JOIN `productsize` ps ON od.ProductSizeID = ps.ProductSizeID
                JOIN `product` p ON ps.ProductID = p.ProductID
                WHERE od.OrderID = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$orderId]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Làm rõ giá trị Subtotal
        foreach ($result as &$item) {
            // Đảm bảo Subtotal là số thực
            if (isset($item['Subtotal'])) {
                $item['Subtotal'] = floatval($item['Subtotal']);
                // Debug
                // error_log("Subtotal for product " . $item['ProductName'] . ": " . $item['Subtotal']);
            }
        }

        return $result;
    }
}
