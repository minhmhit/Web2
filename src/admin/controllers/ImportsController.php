<?php
require_once 'models/Import.php';
require_once 'models/Employee.php';
require_once 'db_connection.php';

$importModel = new Import($pdo);
$employeeModel = new Employee($pdo);

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'list':
            $imports = $importModel->getAll();
            include 'views/imports/list.php';
            break;

        case 'detail':
            $id = $_GET['id'];
            $import = $importModel->getById($id);
            $importDetails = $importModel->getImportDetails($id);
            include 'views/imports/detail.php';
            break;

        case 'add':
            $employees = $employeeModel->getAll();
            $productSizes = $importModel->getProductSizes();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $details = [];
                $total = 0;

                // Xử lý chi tiết sản phẩm
                if (isset($_POST['productSizeID']) && is_array($_POST['productSizeID'])) {
                    for ($i = 0; $i < count($_POST['productSizeID']); $i++) {
                        if (!empty($_POST['productSizeID'][$i]) && !empty($_POST['quantity'][$i]) && !empty($_POST['unitPrice'][$i])) {
                            $subtotal = $_POST['quantity'][$i] * $_POST['unitPrice'][$i];
                            $total += $subtotal;

                            $details[] = [
                                'ProductSizeID' => $_POST['productSizeID'][$i],
                                'Quantity' => $_POST['quantity'][$i],
                                'UnitPrice' => $_POST['unitPrice'][$i]
                            ];
                        }
                    }
                }

                $data = [
                    'EmployeeID' => $_POST['EmployeeID'],
                    'Total' => $total,
                    'details' => $details
                ];

                $importModel->add($data);
                header('Location: admin.php?page=imports&action=list');
                exit;
            } else {
                include 'views/imports/add.php';
            }
            break;
    }
}
