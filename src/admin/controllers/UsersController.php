<?php
require_once 'models/User.php';
require_once 'db_connection.php';

$userModel = new User($pdo);

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'list':
            $users = $userModel->getAll();
            include 'views/users/list.php';
            break;
        case 'edit':
            $id = $_GET['id'];
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $data = [
                    'Fullname' => $_POST['Fullname'],
                    'PhoneNumber' => $_POST['PhoneNumber'],
                    'Email' => $_POST['Email'],
                    'Address' => $_POST['Address'],
                    'isActivate' => $_POST['isActivate']
                ];
                $userModel->update($id, $data);
                header('Location: admin.php?page=users&action=list');
                exit;
            } else {
                $user = $userModel->getById($id);
                include 'views/users/edit.php';
            }
            break;
    }
}