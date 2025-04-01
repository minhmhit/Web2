<h2>Danh sách người dùng</h2>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Email</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['UserID'] ?></td>
            <td><?= htmlspecialchars($user['Fullname']) ?></td>
            <td><?= htmlspecialchars($user['Email']) ?></td>
            <td><?= $user['isActivate'] ? 'Hoạt động' : 'Khóa' ?></td>
            <td><a href="admin.php?page=users&action=edit&id=<?= $user['UserID'] ?>">Sửa</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>