<?php
require_once 'models/Order.php';
require_once 'db_connection.php';
require_once 'models/Permission.php';
$orderModel = new Order($pdo);
$permissionModel = new Permission($pdo);
$userRoleId = $_SESSION['user']['RoleID'] ?? null;
$permissions = $permissionModel->getPermissionsByRole($userRoleId);
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'list':      
            // Kiểm tra có quyền xem đơn hàng hay không
            $hasOrderViewPermission = in_array('order_view', $permissions);
            $orders = $orderModel->getAll();
            include 'views/orders/list.php';
            break;
        case 'detail':
            $hasOrderViewPermission = in_array('order_view', $permissions);
            if(!$hasOrderViewPermission) {
                header('Location: admin.php?page=orders&action=list');
                exit;
            }
            // Kiểm tra có quyền cập nhật đơn hàng hay không
            $hasOrderEditPermission = in_array('order_edit', $permissions);
            $id = $_GET['id'];
            $order = $orderModel->getById($id);
            $orderDetails = $orderModel->getOrderDetails($id);
            include 'views/orders/detail.php';
            break;
        case 'update':
            // Kiểm tra có quyền cập nhật đơn hàng hay không
            $hasOrderEditPermission = in_array('order_edit', $permissions);
            if(!$hasOrderEditPermission) {
                header('Location: admin.php?page=orders&action=list');
                exit;
            }
            // Xử lý từ form cập nhật nhanh trong detail.php
            if (isset($_POST['id']) && isset($_POST['status'])) {
                $id = $_POST['id'];
                $status = $_POST['status'];
                $orderModel->updateStatus($id, $status);
                header("Location: admin.php?page=orders&action=detail&id=$id&success=Cập nhật trạng thái thành công");
                exit;
            }
            // Xử lý từ form chính trong update.php
            else if (isset($_GET['id']) && isset($_POST['Status'])) {
                $id = $_GET['id'];
                $status = $_POST['Status'];
                $total = isset($_POST['Total']) ? $_POST['Total'] : null;

                // Kiểm tra nếu trạng thái là "Completed" hoặc "Pending", giảm tồn kho
                if ($success && ($status === 'Completed' || $status === 'Pending')) {
                    $orderDetails = $orderModel->getOrderDetails($id);
                    foreach ($orderDetails as $detail) {
                        $productSizeID = $detail['ProductSizeID'];
                        $quantity = $detail['Quantity'];
                        $orderModel->decreaseStock($productSizeID, $quantity);
                    }
                }

                // Cập nhật cả trạng thái và tổng tiền (nếu có)
                $success = $orderModel->updateOrderInfo($id, $status, $total);

                if ($success) {
                    header("Location: admin.php?page=orders&action=detail&id=$id&success=Cập nhật đơn hàng thành công");
                } else {
                    header("Location: admin.php?page=orders&action=update&id=$id&error=Có lỗi xảy ra khi cập nhật đơn hàng");
                }
                exit;
            }
            // Hiển thị form cập nhật
            else if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $order = $orderModel->getById($id);
                $orderDetails = $orderModel->getOrderDetails($id);
                include 'views/orders/update.php';
            }
            // Xử lý lỗi
            else {
                header('Location: admin.php?page=orders&action=list');
                exit;
            }
            break;
    }
}
