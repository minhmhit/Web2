<?php
// header('Content-Type: application/json');
require_once 'db_connect.php';

/*************************** PRODUCT START ***************************/

function getNewProduct() {
    $sql = "
        SELECT p.ProductID AS id, p.ProductName AS name, p.Price AS price, p.ImageURL AS image, 
               c.CategoryName AS category, b.BrandName AS brand, p.Gender AS sex,
               GROUP_CONCAT(ps.Size) AS size
        FROM Product p
        LEFT JOIN Categories c ON p.CategoryID = c.CategoryID
        LEFT JOIN Brand b ON p.BrandID = b.BrandID
        LEFT JOIN ProductSize ps ON p.ProductID = ps.ProductID
        GROUP BY p.ProductID;
    ";

    $products = getAll($sql);

    // Chuyển kích thước thành mảng và thêm thuộc tính isDeleted
    foreach ($products as &$product) {
        $product['size'] = !empty($product['size']) ? explode(',', $product['size']) : [];
        $product['isDeleted'] = false;
    }

    return $products;
}


function getProductDetail($idProduct) {
    $sql = "
        SELECT p.ProductID AS id, p.ProductName AS name, p.Price AS price, p.ImageURL AS image, 
               c.CategoryName AS category, b.BrandName AS brand, p.Gender AS sex,
               GROUP_CONCAT(DISTINCT ps.Size ORDER BY ps.Size ASC) AS size
        FROM Product p
        LEFT JOIN Categories c ON p.CategoryID = c.CategoryID
        LEFT JOIN Brand b ON p.BrandID = b.BrandID
        LEFT JOIN ProductSize ps ON p.ProductID = ps.ProductID
        WHERE p.ProductID = $idProduct
        GROUP BY p.ProductID;
    ";

    $product = getOne($sql); // Không cần truyền tham số

    if ($product) {
        $product['size'] = !empty($product['size']) ? explode(',', $product['size']) : [];
    }

    return $product;
}



// function getIDCatalog ($idCatalog) {
//     $sql = "SELECT CategoryID FROM categories WHERE CategoryID =".$idCatalog;
//     $getone = getOne ($sql);
//     extract($getone);
//     return $CategoryID;
// }

function getProducts($pdo)
{
    $stmt = $pdo->prepare("
        SELECT p.ProductID AS id, p.ProductName AS name, p.Price AS price, p.ImageURL AS image, 
               c.CategoryName AS category, b.BrandName AS brand, p.Gender AS sex,
               GROUP_CONCAT(ps.Size) AS size
        FROM Product p
        LEFT JOIN Categories c ON p.CategoryID = c.CategoryID
        LEFT JOIN Brand b ON p.BrandID = b.BrandID
        LEFT JOIN ProductSize ps ON p.ProductID = ps.ProductID
        GROUP BY p.ProductID
    ");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Chuyển kích thước thành mảng
    foreach ($products as &$product) {
        $product['size'] = explode(',', $product['size']);
        $product['isDeleted'] = false;
    }

    return $products;
}
function getSuppliers($pdo)
{
    $stmt = $pdo->prepare("SELECT SupplierID AS id, SupplierName AS name FROM Supplier");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getEmployees($pdo)
{
    $stmt = $pdo->prepare("
        SELECT e.EmployeeID AS id, e.Username AS username, e.Fullname AS fullname, e.PhoneNumber AS phone,
               e.Email AS email, e.Address AS address, e.CreatedAt AS join, p.PermissionName AS permission
        FROM Employee e
        LEFT JOIN Permission p ON e.PermissionID = p.PermissionID
    ");
    $stmt->execute();
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($employees as &$employee) {
        $employee['join'] = date('Y/m/d', strtotime($employee['join']));
    }

    return $employees;
}


function getCarts($pdo)
{
    $stmt = $pdo->prepare("
        SELECT c.CartID AS id, u.Username AS username, p.ProductName AS product_name, c.Size AS size, 
               c.Quantity AS quantity, c.AddedAt AS added_at
        FROM Cart c
        LEFT JOIN User u ON c.UserID = u.UserID
        LEFT JOIN Product p ON c.ProductID = p.ProductID
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getProductSizes($pdo)
{
    $stmt = $pdo->prepare("
        SELECT ps.ProductSizeID AS id, p.ProductName AS product_name, ps.Size AS size, ps.StockQuantity AS stock
        FROM ProductSize ps
        LEFT JOIN Product p ON ps.ProductID = p.ProductID
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getBrands($pdo)
{
    $stmt = $pdo->prepare("SELECT BrandID AS id, BrandName AS name FROM Brand");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getCategories($pdo)
{
    $stmt = $pdo->prepare("SELECT CategoryID AS id, CategoryName AS name FROM Categories");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// Lấy danh sách tài khoản
function getAccounts($pdo)
{
    $stmt = $pdo->prepare("
        SELECT UserID AS id, Username AS username, Fullname AS fullname, PhoneNumber AS phone,
               Email AS email, Address AS address, PasswordHash AS password, 
               CreatedAt AS join
        FROM User
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


// Lấy danh sách đơn hàng
function getOrders($pdo)
{
    $stmt = $pdo->prepare("
        SELECT o.OrderID AS id, o.UserID AS customerId, o.OrderDate AS orderDate, 
               o.ShippingAddress AS fullAddress, o.Province, o.Ward, o.PaymentStatus AS method, 
               o.OrderStatus AS status, od.ProductID AS product_id, od.Size, 
               od.Quantity AS quantity, od.UnitPrice AS originalPrice
        FROM Orders o
        LEFT JOIN OrderDetail od ON o.OrderID = od.OrderID
    ");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Xử lý dữ liệu đơn hàng
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
                        'ward' => $row['Ward']
                    ]
                ],
                'payment' => ['method' => $row['method']],
                'orderDate' => $row['orderDate'],
                'status' => $row['status'],
                'total' => 0 // Tính tổng từ OrderDetail
            ];
        }
        if ($row['product_id']) {
            $orders[$orderId]['cart'][] = [
                'id' => $row['product_id'],
                'quantity' => $row['quantity'],
                'size' => $row['Size'],
                'originalPrice' => $row['originalPrice']
            ];
            // Tính tổng tiền
            $orders[$orderId]['total'] += $row['quantity'] * $row['originalPrice'] + 30000;
        }
    }

    // Lấy thông tin thanh toán thẻ
    $stmt = $pdo->prepare("SELECT OrderID, CardOwner, CardNumber, CVV FROM PaymentDetail");
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





/*************************** PRODUCT END ***************************/


/*
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
    case 'get_categories':
        echo json_encode(getCategories($pdo));
        break;
    case 'get_brands':
        echo json_encode(getBrands($pdo));
        break;
    case 'get_product_sizes':
        echo json_encode(getProductSizes($pdo));
        break;
    case 'get_carts':
        echo json_encode(getCarts($pdo));
        break;
    case 'get_employees':
        echo json_encode(getEmployees($pdo));
        break;
    case 'get_suppliers':
        echo json_encode(getSuppliers($pdo));
        break;
    default:
        echo json_encode(['error' => 'Invalid action']);
        break;
}
*/
