<h2>Chi tiết tài khoản</h2>
<form method="POST" action="admin.php?page=accounts&action=update">
    <input type="hidden" name="id" value="<?= $account['id'] ?>">
    <label>Tên đăng nhập: <input type="text" name="username" value="<?= $account['username'] ?>" required></label><br>
    <label>Họ tên: <input type="text" name="full_name" value="<?= $account['full_name'] ?>" required></label><br>
    <label>Số điện thoại: <input type="text" name="phone" value="<?= $account['phone'] ?>" required></label><br>
    <label>Email: <input type="email" name="email" value="<?= $account['email'] ?>" required></label><br>
    <label>Địa chỉ: <input type="text" name="address" value="<?= $account['address'] ?>" required></label><br>
    <label>Trạng thái: 
        <select name="status">
            <option value="1" <?= $account['status'] ? 'selected' : '' ?>>Hoạt động</option>
            <option value="0" <?= !$account['status'] ? 'selected' : '' ?>>Khóa</option>
        </select>
    </label><br>
    <button type="submit">Lưu</button>
</form>