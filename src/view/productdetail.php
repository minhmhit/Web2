<?php
require_once __DIR__ . "/../controller/db_controller/api.php";
// Lấy ID từ URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("<h2>Error: Could not find the product's id</h2>");
}

$idProduct = intval($_GET['id']);
$product = getProductDetail($idProduct);

if (!$product) {
    die("<h2>Could not find the product</h2>");
}
?>
<div class="container toast" id="toast"></div>
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
    
    <!-- Phần hiển thị size -->
    <div class="size-container">
        <?php
        // Kiểm tra xem size có phải là mảng không
        if (isset($product['size']) && is_array($product['size'])) {
            foreach ($product['size'] as $size) {
                echo "<button class='size-button' data-sizeid='{$size}'>
                        {$size}
                    </button>";
            }
        } else {
            echo "<p>Không có thông tin về size cho sản phẩm này.</p>";
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

<script>

document.addEventListener("DOMContentLoaded", function() {
        let sizeButtons = document.querySelectorAll('.size-button'); // Lấy tất cả các nút size
        let selectedSizeID = null; // Khởi tạo biến để lưu size đã chọn

        // Thêm sự kiện click cho mỗi nút size
        sizeButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Bỏ class 'active' cho tất cả các nút size
                sizeButtons.forEach(btn => btn.classList.remove('active'));

                // Thêm class 'active' cho nút vừa được click
                this.classList.add('active');

                // Lưu lại size đã chọn
                selectedSizeID = this.getAttribute('data-sizeid');

                console.log("Size đã chọn:", selectedSizeID); // Kiểm tra giá trị đã chọn
            });
        });
    });

    // Xử lý sự kiện thêm vào giỏ hàng
document.querySelector("#add-cart").addEventListener("click", function() {
    if (!selectedSizeID) {
        alert("Vui lòng chọn size trước khi thêm vào giỏ hàng!");
        return;
    }

    // Lấy số lượng từ input
    let quantity = parseInt(document.querySelector(".input-qty").value);
    
    // Gửi thông tin vào API
    fetch("../../../controller/db_controller/cart.api.php?action=add_to_cart", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ productsizeid: selectedSizeID, quantity: quantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Sản phẩm đã được thêm vào giỏ hàng!");
        } else {
            alert("Lỗi khi thêm vào giỏ hàng.");
        }
    })
    .catch(error => console.error("Lỗi:", error));
});


    // CATALOGUE - CART - BEGIN DEFINE /////////////////////////////////////////////////////

//Get product from the the "products" array

function getCartTotalAmount() {
    let currentuser = JSON.parse(localStorage.getItem("currentuser"));
    let amount = 0;
    currentuser.cart.forEach(element => {
        amount += parseInt(element.quantity);
    });
    return amount;
}

function updateCartTotalAmount() {
    if (!localStorage.getItem("currentuser")) {
        console.log("updateCartTotalAmount(): Not logged in.");
        return;
    }

    let amount = getCartTotalAmount();
    document.querySelectorAll(".display-cart-total-amount").forEach(ele => ele.innerText = amount);
    console.log("updateCartTotalAmount(): ", amount);
}

// Display/update the totalprice of the cart
function updateCartTotalPrice() {
    const total = vnd(getCartTotalPrice());
    document.querySelectorAll(".display-totalprice").forEach(ele => {
        ele.innerText = total;
    });
    document.querySelectorAll(".display-totalorder").forEach(ele => {
        ele.innerText = vnd(getCartTotalPrice() + DELIVERY_FEE);
    })
}

// Get the totalprice of the cart
function getCartTotalPrice() {
    let currentuser = JSON.parse(localStorage.getItem("currentuser"));
    let totalprice = 0;
    if (currentuser != null || currentuser.cart.length) {
        currentuser.cart.forEach(item => {
            totalprice += (parseInt(item.quantity) * parseInt(item.originalPrice));
        });
    }
    return totalprice;
}

// Update total cart amount when changing cartItem quantity
function updateCartAll(productsizeid, ele, change) {
    let inputQty = ele.closest(".cart-item").querySelector(".input-qty");
    let quantity = parseInt(inputQty.value.trim());

    // Nếu là + hoặc -, thì cập nhật số lượng
    if (change !== 0) {
        quantity += change;
        if (quantity < 1) quantity = 1;
        inputQty.value = quantity;
    }

    fetch("../../../controller/db_controller/cart.api.php?action=update_cart", {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ productsizeid, quantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showCart();
        } else {
            toastMsg({ title: "ERROR", message: data.message, type: "error" });
        }
    });
}


//Reset the cart
function resetCart() {
    let accounts = JSON.parse(localStorage.getItem("accounts"));
    let currentuser = JSON.parse(localStorage.getItem("currentuser"));
    currentuser.cart = [];
    localStorage.setItem("currentuser", JSON.stringify(currentuser));

    let userIdx = accounts.findIndex(user => user.phone === currentuser.phone);
    if (userIdx != -1) {
        accounts[userIdx] = currentuser;
        localStorage.setItem("accounts", JSON.stringify(accounts));
    }
    updateCartTotalAmount();
    updateCartTotalPrice();
    updateMenuVisibility();
}

// //Add cart item to cart[]
// document.addEventListener("DOMContentLoaded", function () {
//     let addCartBtn = document.querySelector("#add-cart");

//     if (addCartBtn) {
//         addCartBtn.addEventListener("click", function () {
//             let quantity = parseInt(document.querySelector(".input-qty").value);
//             let productsizeid = new URLSearchParams(window.location.search).get("productsizeid");

//             let apiUrl = "../../../controller/db_controller/cart.api.php?action=add_to_cart";

//             fetch(apiUrl, {
//                 method: "POST",
//                 headers: { "Content-Type": "application/json" },
//                 body: JSON.stringify({ productsizeid, quantity })
//             })
//             .then(response => response.json())
//             .then(data => {
//                 if (data.success) {
//                     toastMsg({ title: "SUCCESS", message: "Sản phẩm đã được thêm vào giỏ hàng!", type: "success" });
//                     updateCartModal();
//                 } else {
//                     toastMsg({ title: "ERROR", message: data.message, type: "error" });
//                 }
//             })
//             .catch(error => console.error("Lỗi:", error));
//         });
//     } else {
//         console.error("Không tìm thấy phần tử #add-cart");
//     }
// });



//Delete the cart item
function deleteCartItem(productsizeid) {
    fetch(`../../../controller/db_controller/cart.api.php?action=delete_cart_item&productsizeid=${productsizeid}`, {
        method: "DELETE",
        headers: { "Content-Type": "application/json" }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showCart();
        } else {
            toastMsg({ title: "ERROR", message: data.message, type: "error" });
        }
    });
}


function showCart() {
    fetch("../../../controller/db_controller/cart.api.php.php?action=get_cart")
    .then(response => response.json())
    .then(data => {
        const cartBody = document.querySelector(".cart .cart-body");
        const checkoutBtn = document.getElementById("cart-checkout-btn");

        cartBody.innerHTML = "";

        if (!data.success || data.cart.length === 0) {
            checkoutBtn.classList.remove("active");
            checkoutBtn.disabled = true;
            cartBody.innerHTML = `<p>Giỏ hàng của bạn đang trống.</p>`;
            return;
        }

        checkoutBtn.classList.add("active");
        checkoutBtn.disabled = false;

        let cartHTML = "";
        data.cart.forEach(item => {
            cartHTML += `
                <div class="cart-item" data-productsizeid="${item.productsizeid}">
                    <div class="img-container">
                        <img src="${item.product_image}" onerror="this.src='/assets/img/placeholder.jpg'">
                    </div>
                    <div class="cart-item-info">
                        <p class="product-name">${item.product_name}</p>
                        <p>Size: <span class="product-size">${item.size}</span></p>
                        <p class="product-price">${vnd(item.price)}</p>
                    </div>
                    <div class="cart-item-control">
                        <button onclick="deleteCartItem('${item.productsizeid}')">
                            <i class="fa-regular fa-circle-xmark"></i>
                        </button>
                        <div class="cart-item-amount">
                            <button class="minus" onclick="updateCartAll('${item.productsizeid}', this, -1)">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                            <input class="input-qty" max="100" min="1" type="number" value="${item.quantity}" 
                                   onkeyup="updateCartAll('${item.productsizeid}', this, 0)">
                            <button class="plus" onclick="updateCartAll('${item.productsizeid}', this, 1)">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });

        cartBody.innerHTML = cartHTML;
    });
}


function updateCartModal() {
    fetch("../../../controller/db_controller/cart.api.php.php?action=update_cart", {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ productsizeid, quantity: newQuantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartModal(); // Cập nhật modal giỏ hàng
        } else {
            toastMsg({ title: "ERROR", message: data.message, type: "error" });
        }
    });
    
}
</script>

