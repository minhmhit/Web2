<h2>Danh sách tài khoản</h2>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($accounts as $account): ?>
        <tr>
            <td><?= $account['id'] ?></td>
            <td><?= $account['full_name'] ?></td>
            <td><?= $account['status'] ? 'Hoạt động' : 'Khóa' ?></td>
            <td><a href="admin.php?page=accounts&action=detail&id=<?= $account['id'] ?>">Chi tiết</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>