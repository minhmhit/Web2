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
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex h-screen">
    <aside class="admin-sidebar__content w-64 bg-blue-800 text-white shadow-lg">
        <div class="p-4 border-b border-blue-700">
            <h1 class="text-xl font-bold text-center">BROSHOE</h1>
        </div>
        <ul class="py-4">
            <li class="mb-1">
                <a href="admin.php?page=home" class="block px-6 py-3 hover:bg-blue-700 transition duration-200 flex items-center">
                    <i class="fas fa-home mr-3"></i>TRANG CHỦ
                </a>
            </li>
            <li class="mb-1">
                <a href="admin.php?page=orders&action=list" class="block px-6 py-3 hover:bg-blue-700 transition duration-200 flex items-center">
                    <i class="fas fa-shopping-cart mr-3"></i>ĐƠN HÀNG
                </a>
            </li>
            <li class="mb-1">
                <a href="admin.php?page=products&action=list" class="block px-6 py-3 hover:bg-blue-700 transition duration-200 flex items-center">
                    <i class="fas fa-box-open mr-3"></i>SẢN PHẨM
                </a>
            </li>
            <li class="mb-1">
                <a href="admin.php?page=users&action=list" class="block px-6 py-3 hover:bg-blue-700 transition duration-200 flex items-center">
                    <i class="fas fa-users mr-3"></i>NGƯỜI DÙNG
                </a>
            </li>
            <li class="mb-1">
                <a href="admin.php?page=employees&action=list" class="block px-6 py-3 hover:bg-blue-700 transition duration-200 flex items-center">
                    <i class="fas fa-user-tie mr-3"></i>NHÂN VIÊN
                </a>
            </li>
            <li class="mb-1">
                <a href="admin.php?page=suppliers&action=list" class="block px-6 py-3 hover:bg-blue-700 transition duration-200 flex items-center">
                    <i class="fas fa-user-tie mr-3"></i>NHÀ CUNG CẤP
                </a>
            </li>
            <li class="mb-1">
                <a href="admin.php?page=imports&action=list" class="block px-6 py-3 hover:bg-blue-700 transition duration-200 flex items-center">
                    <i class="fas fa-truck mr-3"></i>NHẬP HÀNG
                </a>
            </li>
            <li class="mb-1">
                <a href="admin.php?page=statistics&action=index" class="block px-6 py-3 hover:bg-blue-700 transition duration-200 flex items-center">
                    <i class="fas fa-truck mr-3"></i>THỐNG KÊ
                </a>
            </li>
            <li class="mb-1">
                <a href="admin.php?page=reports&action=summary" class="block px-6 py-3 hover:bg-blue-700 transition duration-200 flex items-center">
                    <i class="fas fa-truck mr-3"></i>BÁO CÁO
                </a>
            </li>
            <li class="mt-8 border-t border-blue-700 pt-2">
                <a href="logout.php" class="block px-6 py-3 hover:bg-red-600 transition duration-200 flex items-center text-red-200 hover:text-white">
                    <i class="fas fa-sign-out-alt mr-3"></i>ĐĂNG XUẤT
                </a>
            </li>
        </ul>
    </aside>
    <main class="flex-1 overflow-y-auto p-8">
        <div class="bg-white rounded-lg shadow-md p-6">
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
                case 'statistics':
                    include 'controllers/StatisticsController.php';
                    break;
                case 'reports':
                    include 'controllers/ReportsController.php';
                    break;
                case 'cart':
                    include 'controllers/CartController.php';
                    break;
                case 'suppliers':
                    include 'controllers/SupplierController.php';
                    break;
                default:
                    echo '<h2 class="text-2xl font-semibold text-gray-800 mb-4">Chào mừng đến với Trang quản trị hệ thống bán giày BROSHOE</h2>
                          <p class="text-gray-600">Vui lòng chọn một mục từ menu bên trái để bắt đầu.</p>';
                    break;
            }
            ?>
        </div>
    </main>
</body>
</html>
