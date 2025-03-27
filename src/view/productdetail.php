<?php
require_once __DIR__ . "/../controller/db_controller/api.php";
// Lấy ID từ URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("<h2>Lỗi: Không tìm thấy ID sản phẩm</h2>");
}

$idProduct = intval($_GET['id']);
$product = getProductDetail($idProduct);

if (!$product) {
    die("<h2>Không tìm thấy sản phẩm</h2>");
}
?>
<div class="product-detail-content">
    <div class="img-container">
        <img src="<?= $product['image'] ?>" alt="" onerror="this.src='view/layout/asset/img/catalogue/coming-soon.jpg'">
    </div>
    <h2 class="product-title"><?= $product['name'] ?></h2>
    <div class="product-control">
        <div class="priceBox">
            <span class="current-price"><?= number_format($product['price'], 0, ',', '.') ?> ₫</span>
        </div>
        <div class="buttons_added">
            <button class="minus is-form" type="button" value="-" onclick="decreasingNumber(this)">
                <i class="fa-solid fa-minus"></i>
            </button>
            <input class="input-qty" max="100" min="1" type="number" value="1">
            <button class="plus is-form" type="button" value="+" onclick="increasingNumber(this)">
                <i class="fa-solid fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="size-container">
        <?php
        if (!empty($product['size']) && is_array($product['size'])) {
            foreach ($product['size'] as $size) {
                echo "<button class='size-button'>$size</button>";
            }
        }        
        ?>
    </div>
    <div class="modal-footer">
        <div class="price-total">
            <span class="thanhtien">Total</span>
            <span class="price"><?= number_format($product['price'], 0, ',', '.') ?> ₫</span>
        </div>
        <div class="modal-footer-control">
            <button class="checkout-btn">Buy now</button>
            <button class="button-dat" id="add-cart"><i class="fa-solid fa-cart-shopping"></i></button>
        </div>
    </div>
</div>

