<?php
require_once 'models/Import.php';
require_once 'db_connection.php';

$importModel = new Import($pdo);

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'list':
            $imports = $importModel->getAll();
            include 'views/imports/list.php';
            break;
        case 'add':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $data = [
                    'EmployeeID' => $_POST['EmployeeID'],
                    'Total' => $_POST['Total']
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