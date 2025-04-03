<?php
session_start();
header('Content-Type: application/json');
include('db_connection.php');
include('functions.php'); // Import các hàm getAll(), getOne(), executeQuery()

if (!isset($_SESSION['user']['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'You need to login first!']);
    exit();
}

$user_id = $_SESSION['user']['user_id'];
$data = json_decode(file_get_contents("php://input"));

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if ($_GET['action'] == 'get_cart') {
            $cart_items = getAll("
                SELECT c.ProductSizeID, c.Quantity, p.Price, 
                       p.ProductName AS product_name, p.ImageURL AS product_image, 
                       ps.size AS Size
                FROM cart c
                JOIN product_sizes ps ON c.productsizeid = ps.id
                JOIN products p ON ps.product_id = p.id
                WHERE c.user_id = $user_id
            ");
            echo json_encode(['success' => true, 'cart' => $cart_items]);
        }
        break;

    case 'POST':
        if ($_GET['action'] == 'add_to_cart') {
            if (empty($data->productsizeid)) {
                echo json_encode(['success' => false, 'message' => 'Please choose a size.']);
                exit();
            }

            $productsizeid = $data->productsizeid;
            $quantity = $data->quantity;
            $price = $data->price;

            $existing_item = getOne("
                SELECT Quantity FROM cart 
                WHERE UserID = $user_id AND ProductSizeID = $productsizeid
            ");

            if ($existing_item) {
                $new_quantity = $existing_item['quantity'] + $quantity;
                executeQuery("UPDATE cart SET Quantity = ? WHERE UserID = ? AND ProductSizeID = ?", 
                             [$new_quantity, $user_id, $productsizeid]);
            } else {
                executeQuery("INSERT INTO cart (UserID, ProductSizeID, Quantity, Price) VALUES (?, ?, ?, ?)", 
                             [$user_id, $productsizeid, $quantity, $price]);
            }

            echo json_encode(['success' => true, 'message' => 'Added to cart successful.']);
        }
        break;

    case 'PUT':
        if ($_GET['action'] == 'update_cart') {
            if (empty($data->productsizeid)) {
                echo json_encode(['success' => false, 'message' => 'Please choose a size.']);
                exit();
            }

            $productsizeid = $data->productsizeid;
            $quantity = $data->quantity;

            executeQuery("UPDATE cart SET Quantity = ? WHERE UserID = ? AND ProductSizeID = ?", 
                         [$quantity, $user_id, $productsizeid]);

            echo json_encode(['success' => true, 'message' => 'Cart updated.']);
        }
        break;

    case 'DELETE':
        if ($_GET['action'] == 'delete_cart_item') {
            if (empty($data->productsizeid)) {
                echo json_encode(['success' => false, 'message' => 'Please choose a size.']);
                exit();
            }

            $productsizeid = $data->productsizeid;

            executeQuery("DELETE FROM cart WHERE UserID = ? AND ProductSizeID = ?", 
                         [$user_id, $productsizeid]);

            echo json_encode(['success' => true, 'message' => 'Deleted successful.']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Request method không hợp lệ.']);
        break;
}
?>
