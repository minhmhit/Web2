<h2>Chỉnh sửa người dùng</h2>
<form method="POST" action="admin.php?page=users&action=edit&id=<?= $user['UserID'] ?>">
    <input type="hidden" name="UserID" value="<?= $user['UserID'] ?>">
    <label>Họ tên: <input type="text" name="Fullname" value="<?= $user['Fullname'] ?>" required></label><br>
    <label>Số điện thoại: <input type="text" name="PhoneNumber" value="<?= $user['PhoneNumber'] ?>" required></label><br>
    <label>Email: <input type="email" name="Email" value="<?= $user['Email'] ?>" required></label><br>
    <label>Địa chỉ: <input type="text" name="Address" value="<?= $user['Address'] ?>" required></label><br>
    <label>Trạng thái: <input type="number" name="isActivate" value="<?= $user['isActivate'] ?>" required></label><br>
    <button type="submit">Cập nhật</button>
</form>