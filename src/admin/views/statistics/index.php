<?php
// Đảm bảo các biến $totalIncome, $products, $accounts, $orders đã được định nghĩa từ StatisticsController.php
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0px;
        }
        h2 {
            color: #333;
        }
        .stats-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }
        .stat-box {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 20px;
            width: 200px;
            text-align: center;
            border-radius: 5px;
        }
        .stat-box p {
            margin: 5px 0;
        }
        .stat-box .value {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>
    <h2>Thống kê</h2>
    <div class="stats-container">
        <div class="stat-box">
            <p>Tổng thu nhập</p>
            <p class="value"><?= number_format($totalIncome, 0, ',', '.') ?> VND</p>
        </div>
        <div class="stat-box">
            <p>Tổng số sản phẩm</p>
            <p class="value"><?= count($products) ?></p>
        </div>
        <div class="stat-box">
            <p>Tổng số tài khoản</p>
            <p class="value"><?= count($accounts) ?></p>
        </div>
        <div class="stat-box">
            <p>Tổng số đơn hàng</p>
            <p class="value"><?= count($orders) ?></p>
        </div>
    </div>
</body>
</html>