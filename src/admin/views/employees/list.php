<h2>Danh sách nhân viên</h2>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Quyền</th>
            <th>Email</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($employees as $employee): ?>
        <tr>
            <td><?= $employee['EmployeeID'] ?></td>
            <td><?= htmlspecialchars($employee['Fullname']) ?></td>
            <td><?= htmlspecialchars($employee['PermissionName']) ?></td>
            <td><?= htmlspecialchars($employee['Email']) ?></td>
            <td>
                <a href="admin.php?page=employees&action=edit&id=<?= $employee['EmployeeID'] ?>">Sửa</a>
                <a href="admin.php?page=employees&action=delete&id=<?= $employee['EmployeeID'] ?>" onclick="return confirm('Xóa nhân viên?')">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a href="admin.php?page=employees&action=add">Thêm nhân viên</a>