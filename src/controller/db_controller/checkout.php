<?php
include_once "db_connect.php";
session_start();

header("Content-Type: application/json");

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['userID'])) {
    echo json_encode(['success' => false, 'message' => 'Bạn chưa đăng nhập.']);
    exit();
}

$userId = $_SESSION['user']['userID'];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'init') {
    $defaultAddress = getOne("SELECT Address, ProvinceID, DistrictID, WardID FROM user WHERE UserID = $userId");
    $savedCard = getOne("SELECT CardOwner, CardNumber, CVV, ExpiryDate FROM savedpayments WHERE UserID = $userId");
    echo json_encode([
        "success" => true,
        "defaultAddress" => $defaultAddress,
        "savedCard" => $savedCard
    ]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['action']) && ($data['action'] === 'checkout' || $data['action'] === 'buy_now_checkout')) {
    if (!isset($data['address']) || !isset($data['payment'])) {
        http_response_code(400);
        echo json_encode(["error" => "Dữ liệu không hợp lệ."]);
        exit();
    }

    // 📦 Thông tin địa chỉ
    $address = $data["address"]["address"];
    $provinceId = $data["address"]["region"]["province"];
    $districtId = $data["address"]["region"]["district"];
    $wardId = $data["address"]["region"]["ward"];

    // 💳 Thông tin thanh toán
    $paymentMethod = $data["payment"]["method"];
    $cardOwner = $cardNumber = $cvv = $expiryDate = null;

    if ($paymentMethod === 'Card') {
        $cardOwner = $data["payment"]["cardOwner"] ?? null;
        $cardNumber = $data["payment"]["cardNumber"] ?? null;
        $cvv = $data["payment"]["cvv"] ?? null;
        $expiryDate = $data["payment"]["expiryDate"] ?? null;  // Dạng YYYY-MM

        // ⏺️ Lưu thẻ nếu có tick checkbox
        if (!empty($data["payment"]["saveCard"])) {
            $saveCardSuccess = executeQuery(
                "INSERT INTO savedpayments (UserID, CardOwner, CardNumber, CVV, ExpiryDate)
                 VALUES (?, ?, ?, ?, ?)
                 ON DUPLICATE KEY UPDATE
                    CardOwner = VALUES(CardOwner),
                    CardNumber = VALUES(CardNumber),
                    CVV = VALUES(CVV),
                    ExpiryDate = VALUES(ExpiryDate),
                    CreatedAt = NOW()",
                [$userId, $cardOwner, $cardNumber, $cvv, $expiryDate]
            );
            if (!$saveCardSuccess) {
                echo json_encode(["success" => false, "message" => "Lưu thông tin thẻ thất bại."]);
                exit();
            }
        }        
    }

    // 🛒 Lấy sản phẩm, nếu là "Buy Now" thì lấy sản phẩm từ request
    if ($data['action'] === 'buy_now_checkout') {
        if (!isset($_SESSION['checkout_products'])) {
            http_response_code(400);
            echo json_encode(["error" => "Không có sản phẩm trong phiên Buy Now."]);
            exit();
        }
    
        $product = $_SESSION['checkout_products'];
    
        if (!isset($product['ProductSizeID']) || !isset($product['Price']) || !isset($product['Quantity'])) {
            http_response_code(400);
            echo json_encode(["error" => "Dữ liệu sản phẩm không hợp lệ."]);
            exit();
        }
    
        $productSizeId = $product['ProductSizeID'];
        $quantity = $product['Quantity'];
    
        $unitPrice = $product['Price'];
        $subtotal = $unitPrice * $quantity;
    
        $cart = [
            [
                'ProductSizeID' => $productSizeId,
                'Quantity' => $quantity,
                'UnitPrice' => $unitPrice,
                'Subtotal' => $subtotal
            ]
        ];  
    } else {
        // Nếu là "checkout" thông thường, lấy giỏ hàng
        $cart = getAll("SELECT * FROM cart WHERE UserID = $userId");
        if (empty($cart)) {
            echo json_encode(["success" => false, "message" => "Giỏ hàng trống."]);
            exit();
        }
    }

    // 🧾 Tạo đơn hàng
    $success = executeQuery(
        "INSERT INTO orders (UserID, ShippingAddress, ProvinceID, DistrictID, WardID) 
         VALUES (?, ?, ?, ?, ?)", 
        [$userId, $address, $provinceId, $districtId, $wardId]
    );

    if (!$success) {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Tạo đơn hàng thất bại."]);
        exit();
    }

    $orderId = getOne("SELECT MAX(OrderID) as id FROM orders WHERE UserID = $userId")['id'];

    // 📦 Ghi từng item vào orderdetail
    foreach ($cart as $item) {
        $productSizeId = $item['ProductSizeID'];
        $quantity = $item['Quantity'];
        $unitPrice = $item['UnitPrice'];
        $subtotal = $quantity * $unitPrice;

        executeQuery(
            "INSERT INTO orderdetail (OrderID, ProductSizeID, Quantity, UnitPrice, Subtotal)
             VALUES (?, ?, ?, ?, ?)",
            [$orderId, $productSizeId, $quantity, $unitPrice, $subtotal]
        );
    }

    // 💸 Lưu thông tin thanh toán
    $paymentSuccess = executeQuery(
        "INSERT INTO paymentdetail (OrderID, PaymentMethod, CardOwner, CardNumber, CVV, ExpiryDate)
         VALUES (?, ?, ?, ?, ?, ?)",
        [$orderId, $paymentMethod, $cardOwner, $cardNumber, $cvv, $expiryDate]
    );

    if (!$paymentSuccess) {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Lưu thông tin thanh toán thất bại."]);
        exit();
    }

    // 🧹 Xoá giỏ hàng nếu là checkout thông thường
    if ($data['action'] === 'checkout') {
        executeQuery("DELETE FROM cart WHERE UserID = ?", [$userId]);
    }

    echo json_encode(["success" => true, "orderId" => $orderId, "message" => "Đặt hàng thành công!"]);
    exit();
}
?>
