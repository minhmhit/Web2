<?php
require_once 'models/Order.php';
require_once 'db_connection.php';

$orderModel = new Order($pdo);

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'list':
            $orders = $orderModel->getAll();
            include 'views/orders/list.php';
            break;
        case 'detail':
            $id = $_GET['id'];
            $order = $orderModel->getById($id);
            $orderDetails = $orderModel->getOrderDetails($id);
            include 'views/orders/detail.php';
            break;
        case 'update':
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
