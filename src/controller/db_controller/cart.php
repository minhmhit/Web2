<?php
session_start();
header('Content-Type: application/json');

include('api.php');

// --- Check login ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'check_login') {
    echo json_encode([
        'success' => isset($_SESSION['user']) && isset($_SESSION['user']['userID']),
        'title' => 'Login requested!',
        'message' => 'Please login or sign up to purchase.',
        'type' => 'info'
    ]);
    exit();
}

// --- Nếu chưa login ---
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['userID'])) {
    if (isset($_GET['action']) && $_GET['action'] === 'get_cart') {
        echo json_encode(['login_required' => true]);
        exit();
    }
    echo json_encode(['success' => false, 'message' => 'Bạn chưa đăng nhập.']);
    exit();
}

$user_id = $_SESSION['user']['userID'];
$data = json_decode(file_get_contents("php://input"));

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if ($_GET['action'] == 'get_cart') {
            $cart_items = getAll("SELECT c.ProductSizeID, c.Quantity, c.UnitPrice AS Price, 
                                        p.ProductName AS product_name, p.ImageURL AS product_image, 
                                        ps.size AS Size
                                  FROM cart c
                                  JOIN productsize ps ON c.ProductSizeID = ps.ProductSizeID
                                  JOIN product p ON ps.ProductID = p.ProductID
                                  WHERE c.UserID = $user_id");

            if (count($cart_items) > 0) {
                echo json_encode(['success' => true, 'cart' => $cart_items]);
            } else {
                echo json_encode(['success' => false, 'cart' => []]);
            }
            exit();
        }

        if ($_GET['action'] == 'get_cart_summary') {
            $summary = getOne("SELECT SUM(Quantity) AS totalQty, SUM(Quantity * UnitPrice) AS totalPrice
                               FROM cart WHERE UserID = $user_id");

            echo json_encode([
                'success' => true,
                'totalQty' => (int)$summary['totalQty'],
                'totalPrice' => (int)$summary['totalPrice']
            ]);
            exit();
        }
        break;

    case 'POST':
        // --- Add to cart ---
        if ($_GET['action'] == 'add_to_cart') {
            if (empty($data->productsizeid) || empty($data->quantity) || empty($data->price)) {
                echo json_encode(['success' => false, 'message' => 'Vui lòng chọn size, số lượng và giá.']);
                exit();
            }

            $productsizeid = $data->productsizeid;
            $quantity = $data->quantity;
            $price = $data->price;

            $existing_item = getOne("SELECT Quantity FROM cart 
                                     WHERE UserID = $user_id AND ProductSizeID = $productsizeid");

            if ($existing_item) {
                $new_quantity = $existing_item['Quantity'] + $quantity;
                executeQuery("UPDATE cart SET Quantity = ? WHERE UserID = ? AND ProductSizeID = ?", 
                             [$new_quantity, $user_id, $productsizeid]);
            } else {
                executeQuery("INSERT INTO cart (UserID, ProductSizeID, Quantity, UnitPrice) 
                              VALUES (?, ?, ?, ?)", 
                              [$user_id, $productsizeid, $quantity, $price]);
            }

            echo json_encode(['success' => true, 'message' => 'Đã thêm vào giỏ hàng.']);
            exit();
        }

        if ($_GET['action'] == 'get_checkout_session') {
            ob_clean(); // 💥 Dọn rác output
            header('Content-Type: application/json'); // 👈 Đảm bảo header đúng
        
            if (isset($_SESSION['checkout_products'])) {
                $product = $_SESSION['checkout_products'];
                echo json_encode([
                    'success' => true,
                    'product' => $product
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không có sản phẩm.']);
            }
            exit();
        }
        

        if ($_GET['action'] == 'clear_checkout_session') {
            unset($_SESSION['checkout_products']);
            echo json_encode(['success' => true, 'message' => 'Đã xoá session checkout.']);
            exit();
        }
        
        
        
        // Case: BUY NOW
        if ($_GET['action'] == 'buy_now') {
            if (empty($data->productsizeid) || empty($data->quantity) || empty($data->price)) {
                echo json_encode(['success' => false, 'message' => 'Thiếu thông tin sản phẩm.']);
                exit();
            }
        
            $productsizeid = $data->productsizeid;
            $quantity = $data->quantity;
            $price = $data->price;
        
            // Lấy thông tin sản phẩm từ database
            $item = getOne("SELECT p.ProductName AS product_name, p.ImageURL AS product_image, ps.size AS Size
                            FROM productsize ps
                            JOIN product p ON ps.ProductID = p.ProductID
                            WHERE ps.ProductSizeID = $productsizeid");
        
            // Tạo sản phẩm checkout
            $checkout_item = [
                'ProductSizeID' => $productsizeid,
                'Quantity' => $quantity,
                'Price' => $price,
                'product_name' => $item['product_name'],
                'product_image' => $item['product_image'],
                'Size' => $item['Size']
            ];
        
            // Chỉ lưu một sản phẩm duy nhất vào session
            $_SESSION['checkout_products'] = $checkout_item;  

            echo json_encode([
                'success' => true,
                'message' => 'Chuẩn bị mua ngay thành công.',
                'data' => [$checkout_item]
            ]);
            exit();
        }
              
    case 'PUT':
        if ($_GET['action'] == 'update_cart') {
            if (empty($data->productsizeid) || empty($data->quantity)) {
                echo json_encode(['success' => false, 'message' => 'Thiếu thông tin cập nhật.']);
                exit();
            }

            $productsizeid = $data->productsizeid;
            $quantity = $data->quantity;

            executeQuery("UPDATE cart SET Quantity = ? WHERE UserID = ? AND ProductSizeID = ?", 
                         [$quantity, $user_id, $productsizeid]);

            echo json_encode(['success' => true, 'message' => 'Cập nhật giỏ hàng thành công.']);
            exit();
        }
        break;

    case 'DELETE':
        if ($_GET['action'] == 'delete_cart_item') {
            if (empty($data->productsizeid)) {
                echo json_encode(['success' => false, 'message' => 'Thiếu ID sản phẩm để xoá.']);
                exit();
            }

            $productsizeid = $data->productsizeid;

            executeQuery("DELETE FROM cart WHERE UserID = ? AND ProductSizeID = ?", 
                         [$user_id, $productsizeid]);

            echo json_encode(['success' => true, 'message' => 'Đã xoá sản phẩm khỏi giỏ hàng.']);
            exit();
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Phương thức không hỗ trợ.']);
        break;
}
