<?php
session_start();
header('Content-Type: application/json');

include('api.php');

// --- Trường hợp gọi để check login ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'check_login') {
    echo json_encode([
        'success' => isset($_SESSION['user']) && isset($_SESSION['user']['userID']),
        'title' => 'Yêu cầu đăng nhập',
        'message' => 'Bạn cần đăng nhập để tiếp tục.',
        'type' => 'info'
    ]);
    exit();
}

// Nếu chưa login và chỉ gọi get_cart thì trả về cart rỗng
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
        break;

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
