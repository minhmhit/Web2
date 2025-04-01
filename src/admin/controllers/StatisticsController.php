<?php
require_once 'models/Order.php';
require_once 'models/Product.php';
require_once 'models/Account.php';
require_once 'db_connection.php';

$orderModel = new Order($pdo);
$productModel = new Product($pdo);
$accountModel = new Account($pdo);

$orders = $orderModel->getAll();
$products = $productModel->getAll();
$accounts = $accountModel->getAll();

// Tính tổng thu nhập
$totalIncome = 0;
foreach ($orders as $order) {
    if (($order['payment_method'] == 'cash' && $order['status'] == 2) || ($order['payment_method'] == 'card' && $order['status'] == 1)) {
        $totalIncome += $order['total'];
    }
}

include 'views/statistics/index.php';