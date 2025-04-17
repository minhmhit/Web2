<?php
require_once 'db_connection.php';

if (isset($_GET['action']) && $_GET['action'] == 'summary') {
    // Tổng nhập
    $totalImport = $pdo->query("SELECT SUM(Total) as total FROM import")->fetch()['total'] ?? 0;
    // Tổng bán
    $totalSales = $pdo->query("SELECT SUM(Total) as total FROM orders")->fetch()['total'] ?? 0;
    // Số user
    $userCount = $pdo->query("SELECT COUNT(*) as count FROM user")->fetch()['count'];
    // Số admin (giả sử employee với PermissionID = 1 là admin)
    $adminCount = $pdo->query("SELECT COUNT(*) as count FROM employee WHERE PermissionID = 1")->fetch()['count'];
    // Số product trong kho
    $productCount = $pdo->query("SELECT COUNT(*) as count FROM product WHERE IsDeleted = 0")->fetch()['count'];
    // Số employee
    $employeeCount = $pdo->query("SELECT COUNT(*) as count FROM employee")->fetch()['count'];

    // Số phiếu nhập
    $importCount = $pdo->query("SELECT COUNT(*) as count FROM import")->fetch()['count'];

    // Số đơn hàng
    $orderCount = $pdo->query("SELECT COUNT(*) as count FROM orders")->fetch()['count'];

    // Phân loại đơn hàng theo trạng thái
    $pendingOrderCount = $pdo->query("SELECT COUNT(*) as count FROM orders WHERE Status = 'Pending'")->fetch()['count'];
    $processedOrderCount = $pdo->query("SELECT COUNT(*) as count FROM orders WHERE Status = 'Processed'")->fetch()['count'];
    $cancelledOrderCount = $pdo->query("SELECT COUNT(*) as count FROM orders WHERE Status = 'Cancelled'")->fetch()['count'];

    include 'views/reports/summary.php';
}
