<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['PermissionID'] != 1) {
    header('Location: login.php');
    exit;
}

$page = $_GET['page'] ?? 'home';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <aside class="admin-sidebar__content">
        <ul>
            <li><a href="admin.php?page=home">TRANG CHỦ</a></li>
            <li><a href="admin.php?page=orders&action=list">ĐƠN HÀNG</a></li>
            <li><a href="admin.php?page=products&action=list">SẢN PHẨM</a></li>
            <li><a href="admin.php?page=users&action=list">NGƯỜI DÙNG</a></li>
            <li><a href="admin.php?page=employees&action=list">NHÂN VIÊN</a></li>
            <li><a href="admin.php?page=imports&action=list">NHẬP HÀNG</a></li>
            <li><a href="logout.php">ĐĂNG XUẤT</a></li>
        </ul>
    </aside>
    <main>
        <?php
        switch ($page) {
            case 'products':
                include 'controllers/ProductsController.php';
                break;
            case 'orders':
                include 'controllers/OrdersController.php';
                break;
            case 'users':
                include 'controllers/UsersController.php';
                break;
            case 'employees':
                include 'controllers/EmployeesController.php';
                break;
            case 'imports':
                include 'controllers/ImportsController.php';
                break;
            default:
                echo "<h2>Chào mừng đến với Trang quản trị</h2>";
                break;
        }
        ?>
    </main>
</body>
</html>