<?php
require_once 'models/Supplier.php';
require_once 'db_connection.php';

$supplierModel = new Supplier($pdo);

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'list':
            $suppliers = $supplierModel->getAll();
            include 'views/suppliers/list.php';
            break;
        case 'detail':
            $id = $_GET['id'];
            $supplier = $supplierModel->getById($id);
            include 'views/suppliers/detail.php';
            break;
        case 'add':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = $_POST['name'];
                $supplierModel->add($name);
                header('Location: admin.php?page=suppliers&action=list');
                exit;
            } else {
                include 'views/suppliers/add.php';
            }
            break;
        case 'update':
            $id = $_GET['id'] ?? $_POST['id'];
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = $_POST['name'];
                $supplierModel->update($id, $name);
                header('Location: admin.php?page=suppliers&action=list');
                exit;
            } else {
                $supplier = $supplierModel->getById($id);
                include 'views/suppliers/edit.php';
            }
            break;
        case 'delete':
            $id = $_GET['id'];
            $supplierModel->delete($id);
            header('Location: admin.php?page=suppliers&action=list');
            exit;
    }
}