<?php
// api
header('Content-Type: application/json');
require_once 'db_connect.php';

// Lấy ds spham từ db
function getProducts($pdo)
{
    $stmt = $pdo->prepare("
        SELECT p.ProductID AS id, p.ProductName AS name, p.Price AS price, p.ImageURL AS image, 
               c.CategoryName AS category, b.BrandName AS brand, p.Gender AS sex,
               GROUP_CONCAT(ps.Size) AS size
        FROM Products p
        LEFT JOIN Categories c ON p.CategoryID = c.CategoryID
        LEFT JOIN Brands b ON p.BrandID = b.BrandID
        LEFT JOIN ProductSizes ps ON p.ProductID = ps.ProductID
        GROUP BY p.ProductID
    ");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //chuyển thành mảng
    foreach ($products as &$product) {
        $product['size'] = explode(',', $product['size']);
        $product['isDeleted'] = false;
    }

    return $products;
}

// lấy ds account
function getAccounts($pdo)
{
    $stmt = $pdo->prepare("
        SELECT UserID AS id, Username AS username, FullName AS fullname, PhoneNumber AS phone,
               Email AS email, Address AS address, PasswordHash AS password, 
               IsAdmin AS isAdmin, CreatedAt AS join
        FROM Users
    ");
    $stmt->execute();
    $accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);


    foreach ($accounts as &$account) {
        $account['cart'] = [];
        $account['status'] = 1;
        $account['join'] = date('Y/m/d', strtotime($account['join']));
    }

    return $accounts;
}


function getOrders($pdo)
{
    $stmt = $pdo->prepare("
        SELECT o.OrderID AS id, o.UserID AS customerId, o.OrderDate AS orderDate, 
               o.TotalAmount AS total, o.DeliveryFee, o.ShippingAddress AS fullAddress,
               o.Province, o.District, o.Ward, o.PaymentMethod AS method, o.OrderStatus AS status,
               od.ProductID AS product_id, od.Size, od.Quantity AS quantity, od.UnitPrice AS originalPrice
        FROM Orders o
        LEFT JOIN OrderDetails od ON o.OrderID = od.OrderID
    ");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // đơn hàng
    $orders = [];
    foreach ($rows as $row) {
        $orderId = $row['id'];
        if (!isset($orders[$orderId])) {
            $orders[$orderId] = [
                'id' => $orderId,
                'customerId' => $row['customerId'],
                'cart' => [],
                'address' => [
                    'fullAddress' => $row['fullAddress'],
                    'region' => [
                        'province' => $row['Province'],
                        'district' => $row['District'],
                        'ward' => $row['Ward']
                    ]
                ],
                'payment' => ['method' => $row['method']],
                'orderDate' => $row['orderDate'],
                'status' => $row['status'],
                'total' => $row['total'] + $row['DeliveryFee']
            ];
        }
        if ($row['product_id']) {
            $orders[$orderId]['cart'][] = [
                'id' => $row['product_id'],
                'quantity' => $row['quantity'],
                'size' => $row['Size'],
                'originalPrice' => $row['originalPrice']
            ];
        }
    }

    //thanh toán thẻ
    $stmt = $pdo->prepare("SELECT OrderID, CardOwnerName AS cardOwner, CardNumber AS cardNumber, CVV AS cvv FROM PaymentDetails");
    $stmt->execute();
    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($payments as $payment) {
        $orderId = $payment['OrderID'];
        if (isset($orders[$orderId])) {
            $orders[$orderId]['payment'] = array_merge($orders[$orderId]['payment'], $payment);
        }
    }

    return array_values($orders);
}

/*
lấy từ url
$action = $_GET['action'] ?? '';
switch ($action) {
    case 'get_products':
        echo json_encode(getProducts($pdo));
        break;
    case 'get_accounts':
        echo json_encode(getAccounts($pdo));
        break;
    case 'get_orders':
        echo json_encode(getOrders($pdo));
        break;
    default:
        echo json_encode(['error' => 'Invalid action']);
        break;
}


có thể include vào các controller khác để xử lý dữ liệu
        */
