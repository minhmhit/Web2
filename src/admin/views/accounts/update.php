<h2>Cập nhật thông tin tài khoản</h2>
<form method="POST" action="admin.php?page=accounts&action=update">
    <label>Họ tên: <input type="text" name="Fullname" value="<?= $_SESSION['user']['Fullname'] ?>" required></label><br>
    <label>Email: <input type="email" name="Email" value="<?= $_SESSION['user']['Email'] ?>" required></label><br>
    <label>Số điện thoại: <input type="text" name="PhoneNumber" value="<?= $_SESSION['user']['PhoneNumber'] ?>" required></label><br>
    <button type="submit">Cập nhật</button>
</form>