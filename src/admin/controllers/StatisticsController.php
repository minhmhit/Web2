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

// tính tổng thu nhập dựa trên order[total]
$totalIncome = 0;
foreach ($orders as $order) {
    $totalIncome += $order['total'];
}

include 'views/statistics/index.php';