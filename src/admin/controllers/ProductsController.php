<?php
require_once 'models/Product.php';
require_once 'db_connection.php';

$productModel = new Product($pdo);

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'list':
            $products = $productModel->getAll();
            include 'views/products/list.php';
            break;
        case 'add':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $data = [
                    'ProductName' => $_POST['ProductName'],
                    'CategoryID' => $_POST['CategoryID'],
                    'BrandID' => $_POST['BrandID'],
                    'Gender' => $_POST['Gender'],
                    'Price' => $_POST['Price'],
                    'ImageURL' => $_POST['ImageURL']
                ];
                $productModel->add($data);
                header('Location: admin.php?page=products&action=list');
                exit;
            } else {
                include 'views/products/add.php';
            }
            break;
        case 'edit':
            $id = $_GET['id'];
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $data = [
                    'ProductName' => $_POST['ProductName'],
                    'CategoryID' => $_POST['CategoryID'],
                    'BrandID' => $_POST['BrandID'],
                    'Gender' => $_POST['Gender'],
                    'Price' => $_POST['Price'],
                    'ImageURL' => $_POST['ImageURL']
                ];
                $productModel->update($id, $data);
                header('Location: admin.php?page=products&action=list');
                exit;
            } else {
                $product = $productModel->getById($id);
                include 'views/products/edit.php';
            }
            break;
        case 'delete':
            $id = $_GET['id'];
            $productModel->delete($id);
            header('Location: admin.php?page=products&action=list');
            exit;
    }
}