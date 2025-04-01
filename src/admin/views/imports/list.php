<h2>Danh sách nhập hàng</h2>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nhân viên</th>
            <th>Tổng tiền</th>
            <th>Ngày nhập</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($imports as $import): ?>
        <tr>
            <td><?= $import['ImportID'] ?></td>
            <td><?= htmlspecialchars($import['EmployeeFullname']) ?></td>
            <td><?= number_format($import['Total'], 0, ',', '.') ?> VND</td>
            <td><?= $import['ImportDate'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a href="admin.php?page=imports&action=add">Thêm nhập hàng</a>