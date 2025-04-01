<?php
session_start();
require_once 'db_connection.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM employee WHERE Username = ? AND isActivate = 1 ");
    $stmt->execute([$username]);
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($employee && password_verify($password, $employee['PasswordHash']) && $employee['PermissionID'] == 1) {
        $_SESSION['user'] = $employee;
        header('Location: admin.php');
        exit;
    } else {
        echo "Đăng nhập thất bại. Vui lòng kiểm tra lại thông tin.";
    }
}
?>

<form method="POST" action="login.php">
    <label>Tên đăng nhập: <input type="text" name="username" required></label><br>
    <label>Mật khẩu: <input type="password" name="password" required></label><br>
    <button type="submit">Đăng nhập</button>
</form>