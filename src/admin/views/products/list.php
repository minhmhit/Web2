<h2>Danh sách sản phẩm</h2>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Danh mục</th>
            <th>Thương hiệu</th>
            <th>Giá</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
        <tr>
            <td><?= $product['ProductID'] ?></td>
            <td><?= htmlspecialchars($product['ProductName']) ?></td>
            <td><?= htmlspecialchars($product['CategoryName']) ?></td>
            <td><?= htmlspecialchars($product['BrandName']) ?></td>
            <td><?= number_format($product['Price'], 0, ',', '.') ?> VND</td>
            <td>
                <a href="admin.php?page=products&action=edit&id=<?= $product['ProductID'] ?>">Sửa</a>
                <a href="admin.php?page=products&action=delete&id=<?= $product['ProductID'] ?>" onclick="return confirm('Xóa sản phẩm?')">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a href="admin.php?page=products&action=add">Thêm sản phẩm</a>