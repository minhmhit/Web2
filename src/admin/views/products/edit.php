<h2>Sửa sản phẩm</h2>
<form method="POST" action="admin.php?page=products&action=edit&id=<?= $product['ProductID'] ?>">
    <label>Tên sản phẩm: <input type="text" name="ProductName" value="<?= $product['ProductName'] ?>" required></label><br>
    <label>Danh mục: <input type="number" name="CategoryID" value="<?= $product['CategoryID'] ?>" required></label><br>
    <label>Thương hiệu: <input type="number" name="BrandID" value="<?= $product['BrandID'] ?>" required></label><br>
    <label>Giới tính: <input type="text" name="Gender" value="<?= $product['Gender'] ?>" required></label><br>
    <label>Giá: <input type="number" name="Price" value="<?= $product['Price'] ?>" required></label><br>
    <label>URL hình ảnh: <input type="text" name="ImageURL" value="<?= $product['ImageURL'] ?>" required></label><br>
    <button type="submit">Lưu</button>
</form>