<?php
require_once 'models/Employee.php';
require_once 'db_connection.php';

$employeeModel = new Employee($pdo);

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'list':
            $employees = $employeeModel->getAll();
            include 'views/employees/list.php';
            break;
        case 'add':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $data = [
                    'Username' => $_POST['Username'],
                    'Fullname' => $_POST['Fullname'],
                    'PhoneNumber' => $_POST['PhoneNumber'],
                    'Email' => $_POST['Email'],
                    'Address' => $_POST['Address'],
                    'Password' => $_POST['Password'],
                    'PermissionID' => $_POST['PermissionID'],
                    'isActivate' => $_POST['isActivate']
                ];
                $employeeModel->add($data);
                header('Location: admin.php?page=employees&action=list');
                exit;
            } else {
                include 'views/employees/add.php';
            }
            break;
        case 'edit':
            $id = $_GET['id'];
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $data = [
                    'Fullname' => $_POST['Fullname'],
                    'PhoneNumber' => $_POST['PhoneNumber'],
                    'Email' => $_POST['Email'],
                    'Address' => $_POST['Address'],
                    'PermissionID' => $_POST['PermissionID'],
                    'isActivate' => $_POST['isActivate']
                ];
                $employeeModel->update($id, $data);
                header('Location: admin.php?page=employees&action=list');
                exit;
            } else {
                $employee = $employeeModel->getById($id);
                include 'views/employees/edit.php';
            }
            break;
        case 'delete':
            $id = $_GET['id'];
            $employeeModel->delete($id);
            header('Location: admin.php?page=employees&action=list');
            exit;
    }
}