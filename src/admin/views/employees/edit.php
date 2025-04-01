<h2>Sửa nhân viên</h2>
<form method="POST" action="admin.php?page=employees&action=edit&id=<?= $employee['EmployeeID'] ?>">
    <label>Họ tên: <input type="text" name="Fullname" value="<?= $employee['Fullname'] ?>" required></label><br>
    <label>Số điện thoại: <input type="text" name="PhoneNumber" value="<?= $employee['PhoneNumber'] ?>" required></label><br>
    <label>Email: <input type="email" name="Email" value="<?= $employee['Email'] ?>" required></label><br>
    <label>Địa chỉ: <input type="text" name="Address" value="<?= $employee['Address'] ?>" required></label><br>
    <label>Quyền: <input type="number" name="PermissionID" value="<?= $employee['PermissionID'] ?>" required></label><br>
    <label>Trạng thái: <input type="number" name="isActivate" value="<?= $employee['isActivate'] ?>" required></label><br>
    <button type="submit">Lưu</button>
</form>