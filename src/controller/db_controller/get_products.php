<?php
header('Content-Type: application/json'); 
require_once 'api.php'; // Gọi API để lấy dữ liệu sản phẩm từ DB

$products = getNewProduct(); // Lấy danh sách sản phẩm từ DB

echo json_encode($products); // Trả về JSON cho JavaScript xử lý
?>
