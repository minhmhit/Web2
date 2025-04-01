<h2>Thêm sản phẩm</h2>
<form method="POST" action="admin.php?page=products&action=add">
    <label>Tên sản phẩm: <input type="text" name="ProductName" required></label><br>
    <label>Danh mục: <input type="number" name="CategoryID" required></label><br>
    <label>Thương hiệu: <input type="number" name="BrandID" required></label><br>
    <label>Giới tính: <input type="text" name="Gender" required></label><br>
    <label>Giá: <input type="number" name="Price" required></label><br>
    <label>URL hình ảnh: <input type="text" name="ImageURL" required></label><br>
    <button type="submit">Thêm</button>
</form>