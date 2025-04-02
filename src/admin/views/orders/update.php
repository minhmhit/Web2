<h2>Cập nhật đơn hàng</h2>
<form method="POST" action="admin.php?page=orders&action=update&id=<?= $order['OrderID'] ?>">
    <label>Mã đơn hàng: <input type="text" name="OrderID" value="<?= $order['OrderID'] ?>" readonly></label><br>
    <label>Tổng tiền: <input type="number" name="Total" value="<?= $order['Total'] ?>" required></label><br>
    <label>Trạng thái: <input type="text" name="Status" value="<?= $order['Status'] ?>" required></label><br>
    <button type="submit">Cập nhật</button>
</form>