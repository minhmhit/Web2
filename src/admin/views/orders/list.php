<h2>Danh sách đơn hàng</h2>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Khách hàng</th>
            <th>Ngày đặt</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= $order['OrderID'] ?></td>
            <td><?= htmlspecialchars($order['UserFullname']) ?></td>
            <td><?= $order['OrderDate'] ?></td>
            <td><?= htmlspecialchars($order['PaymentStatus']) ?></td>
            <td><a href="admin.php?page=orders&action=detail&id=<?= $order['OrderID'] ?>">Chi tiết</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>