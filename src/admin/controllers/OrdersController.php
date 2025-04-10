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
            include 'views/orders/detail.php';
            break;
        case 'update':
            $id = $_GET['id'];
            $status = $_POST['status'];
            $orderModel->updateStatus($id, $status);
            header('Location: admin.php?page=orders&action=list');
            exit;
    }
}