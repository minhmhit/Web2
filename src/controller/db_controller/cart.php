<?php
session_start();
header('Content-Type: application/json');
// include('db_connect.php');
include('api.php');


if (isset($_GET['action']) && $_GET['action'] === 'check_login') {
    if (!isset($_SESSION['user']['userID'])) {
        echo json_encode([
            'success' => false,
            'title' => 'Info',
            'message' => 'You need to login first!',
            'type' => 'info'
        ]);
    } else {
        echo json_encode(['success' => true]);
    }
    exit();
}

$user_id = $_SESSION['user']['userID'];
$data = json_decode(file_get_contents("php://input"));

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Lấy giỏ hàng của người dùng
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
                echo json_encode(['success' => false, 'message' => 'Cart is empty.']);
            }
        }

        // GET /cart.php?action=get_cart_summary
        if ($_GET['action'] == 'get_cart_summary') {
            $summary = getOne("SELECT SUM(Quantity) AS totalQty, SUM(Quantity * UnitPrice) AS totalPrice
                            FROM cart WHERE UserID = ?", [$user_id]);

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
                echo json_encode(['success' => false, 'message' => 'Please choose size, quantity, and price.']);
                exit();
            }

            $productsizeid = $data->productsizeid;
            $quantity = $data->quantity;
            $price = $data->price;

            // Kiểm tra nếu item đã có trong giỏ
            $existing_item = getOne("SELECT Quantity FROM cart 
                                     WHERE UserID = $user_id AND ProductSizeID = $productsizeid");

            if ($existing_item) {
                // Cập nhật số lượng
                $new_quantity = $existing_item['Quantity'] + $quantity;
                executeQuery("UPDATE cart SET Quantity = ? WHERE UserID = ? AND ProductSizeID = ?", 
                             [$new_quantity, $user_id, $productsizeid]);
            } else {
                // Thêm sản phẩm vào giỏ
                executeQuery("INSERT INTO cart (UserID, ProductSizeID, Quantity, UnitPrice) VALUES (?, ?, ?, ?)", 
                             [$user_id, $productsizeid, $quantity, $price]);
            }

            echo json_encode(['success' => true, 'message' => 'Added to cart successfully.']);
        }
        break;

    case 'PUT':
        // Cập nhật giỏ hàng
        if ($_GET['action'] == 'update_cart') {
            if (empty($data->productsizeid) || empty($data->quantity)) {
                echo json_encode(['success' => false, 'message' => 'Vui lòng chọn size và số lượng.']);
                exit();
            }

            $productsizeid = $data->productsizeid;
            $quantity = $data->quantity;

            executeQuery("UPDATE cart SET Quantity = ? WHERE UserID = ? AND ProductSizeID = ?", 
                        [$quantity, $user_id, $productsizeid]);

            echo json_encode(['success' => true, 'message' => 'Giỏ hàng đã được cập nhật.']);
        }
        break;

    case 'DELETE':
        // Xóa sản phẩm khỏi giỏ hàng
        if ($_GET['action'] == 'delete_cart_item') {
            if (empty($data->productsizeid)) {
                echo json_encode(['success' => false, 'message' => 'Vui lòng chọn sản phẩm để xóa.']);
                exit();
            }

            $productsizeid = $data->productsizeid;

            executeQuery("DELETE FROM cart WHERE UserID = ? AND ProductSizeID = ?", 
                        [$user_id, $productsizeid]);

            echo json_encode(['success' => true, 'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng.']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Request method not supported.']);
        break;
}
?>
