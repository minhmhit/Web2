<h2>Thêm nhân viên</h2>
<form method="POST" action="admin.php?page=employees&action=add">
    <label>Tên đăng nhập: <input type="text" name="Username" required></label><br>
    <label>Họ tên: <input type="text" name="Fullname" required></label><br>
    <label>Số điện thoại: <input type="text" name="PhoneNumber" required></label><br>
    <label>Email: <input type="email" name="Email" required></label><br>
    <label>Địa chỉ: <input type="text" name="Address" required></label><br>
    <label>Mật khẩu: <input type="password" name="Password" required></label><br>
    <label>Quyền: <input type="number" name="PermissionID" required></label><br>
    <label>Trạng thái: <input type="number" name="isActivate" required></label><br>
    <button type="submit">Thêm</button>
</form>