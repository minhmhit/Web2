<h2>Chi tiết đơn hàng #<?= $order['OrderID'] ?></h2>
<p>Khách hàng: <?= htmlspecialchars($order['UserFullname']) ?></p>
<p>Tổng tiền: <?= number_format($order['Total'], 0, ',', '.') ?> VND</p>
<form method="POST" action="admin.php?page=orders&action=update">
    <input type="hidden" name="id" value="<?= $order['OrderID>'] ?>">
    <label>Trạng thái: 
        <select name="status">
            <option value="Pending" <?= $order['PaymentStatus'] == 'Pending' ? 'selected' : '' ?>>Đang chờ</option>
            <option value="Processed" <?= $order['PaymentStatus'] == 'Processed' ? 'selected' : '' ?>>Đã xử lý</option>
            <option value="Cancelled" <?= $order['PaymentStatus'] == 'Cancelled' ? 'selected' : '' ?>>Đã hủy</option>
        </select>
    </label><br>
    <button type="submit">Cập nhật</button>
</form>