<?php
require_once 'models/User.php';

$userModel = new User($pdo);
$page = $_GET['page'] ?? '';
$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'add':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'Username' => $_POST['Username'],
                'Fullname' => $_POST['Fullname'],
                'PhoneNumber' => $_POST['PhoneNumber'],
                'Email' => $_POST['Email'],
                'Address' => $_POST['Address'],
                'PasswordHash' => password_hash($_POST['Password'], PASSWORD_DEFAULT),
                'isActivate' => $_POST['isActivate']
            ];
            $userModel->add($data);
            header('Location: admin.php?page=users&action=list');
            exit;
        } else {
            include 'views/users/add.php';
        }
        break;

    case 'edit':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'UserID' => $_POST['UserID'],
                'Fullname' => $_POST['Fullname'],
                'PhoneNumber' => $_POST['PhoneNumber'],
                'Email' => $_POST['Email'],
                'Address' => $_POST['Address'],
                'isActivate' => $_POST['isActivate']
            ];
            $userModel->update($data);
            header('Location: admin.php?page=users&action=list');
            exit;
        } else {
            $user = $userModel->getById($_GET['id']);
            include 'views/users/edit.php';
        }
        break;

    case 'list':
    default:
        $users = $userModel->getAll();
        include 'views/users/list.php';
        break;
}