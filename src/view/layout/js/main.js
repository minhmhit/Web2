// VISIBILITY - BEGIN DEFINE /////////////////////////////////////////////////////

function toggleSidebarDropdown(elementId) {
    let x = document.getElementById(elementId);
    x.classList.toggle("hidden");
}

function toggleModal(elementId) {
    let x = document.getElementById(elementId);

    x.classList.toggle("open");

    Array.from(document.getElementsByClassName("modal")).forEach((modal) => {
        if (modal.id !== elementId)
            modal.classList.remove("open");
    });
}

function togglePage(elementId) {
    let selectedPage = document.getElementById(elementId);
    let catalougePage = document.getElementById("catalogue");
    let allPages = document.querySelectorAll(".toggle-page");


    selectedPage.classList.toggle("hidden");

    allPages.forEach((page) => {
        if (page.id !== elementId) {
            page.classList.add("hidden");
        }
    });

    // Now check if any page is active
    let anyActivePage = Array.from(allPages).some(page => !page.classList.contains("hidden"));


    // If no page is active, show catalougePage; otherwise, hide it
    if (!anyActivePage)
        catalougePage.classList.remove("hidden");
    else
        catalougePage.classList.add("hidden");


    window.scrollTo({ top: 0 });
}
// VISIBILITY - END DEFINE /////////////////////////////////////////////////////

// USER - BEGIN DEFINE /////////////////////////////////////////////////////

// Load user info to My Account after user has logged in
function loadUserInfo() {
    event.preventDefault();

    const currentuser = JSON.parse(localStorage.getItem("currentuser"));

    if (currentuser) {
        document.getElementById("infoname").value = currentuser.username || "";
        document.getElementById("fullname").value = currentuser.fullname || "";
        document.getElementById("infophone").value = currentuser.phone || "";
        document.getElementById("infoemail").value = currentuser.email || "";
        document.getElementById("infoaddress").value = currentuser.address || "";
    }
}

// Apply changes to current account in My Acocunt
// function changeAccInfo() {
//     event.preventDefault();
//     // Collect updated values from the form
//     // let username = document.getElementById("infoname").value.trim();
//     let fullname = document.getElementById("fullname").value.trim();
//     let phone = document.getElementById("infophone").value.trim();
//     let email = document.getElementById("infoemail").value.trim();
//     let address = document.getElementById("infoaddress").value.trim();

//     let hasError = false;

//     // Reset form-msg-error classes
//     document.querySelectorAll(".account-user .form-msg-error").forEach(msg => {
//         msg.textContent = "";
//     });

//     // Validation checks
//     // if (!username || username.length < 5 || /\W|\s/.test(username)) {
//     //     errorMsg.innerHTML += "<p>Username must be at least 5 characters long, no spaces or special characters.</p>";
//     // }


//     if (!fullname) {
//         document.querySelector("#fullname + .form-msg-error").innerText = "Full name cannot be empty.";
//         hasError = true;
//     }

//     if (!phone || !/^\d{10}$/.test(phone)) {
//         document.querySelector("#infophone + .form-msg-error").innerText = "Phone number must be exactly 10 digits.";
//         hasError = true;
//     }

//     if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
//         document.querySelector("#infoemail + .form-msg-error").innerText = "Please enter a valid email address.";
//         hasError = true;
//     }

//     if (!address) {
//         document.querySelector("#infoaddress + .form-msg-error").innerText = "Address cannot be empty.";
//         hasError = true;
//     }

//     return !hasError;
// }

function toggleChangePass() {
    let changepass = document.getElementById("user-info-changepass");
    let changeacc = document.getElementById("user-info-changeacc");
    if (changepass.classList.contains("hidden")) {
        changepass.classList.remove("hidden");
        changeacc.classList.add("hidden");
    } else {
        changepass.classList.add("hidden");
        changeacc.classList.remove("hidden");
    }
    window.scrollTo({ top: 0 });
}

// Change current user"s password
function changePassword() {  
    let currentPassword = document.getElementById("password-cur-info").value.trim();
    let newPassword = document.getElementById("password-after-info").value.trim();
    let confirmNewPassword = document.getElementById("password-confirm-info").value.trim();

    let hasError = false;

    // Reset form-msg-error classes
    document.querySelectorAll(".change-password .form-msg-error").forEach(msg => {
        msg.textContent = "";
    });
 

    if (!currentPassword) {
        document.querySelector("#password-cur-info + .form-msg-error").innerText = "Please enter current password";
        hasError = true;
    }

    if (currentPassword !== currentuser.password) {
        document.querySelector("#password-cur-info + .form-msg-error").innerText = "Current password is incorrect.";
        hasError = true;
    }

    if (!newPassword || newPassword.length < 5 || /\s/.test(newPassword)) {
        document.querySelector("#password-after-info + .form-msg-error").innerText = "New password must be at least 5 characters long and cannot contain spaces";
        hasError = true;
    }

    if (newPassword === currentPassword) {
        document.querySelector("#password-after-info + .form-msg-error").innerText = "New password must be different from current password.";
        hasError = true;
    }

    if (newPassword !== confirmNewPassword) {
        document.querySelector("#password-confirm-info + .form-msg-error").innerText = "New password and confirmation do not match.";
        hasError = true;
    }

    if (hasError) {
        toastMsg({ title: "ERROR", message: "Please fill in the form correctly.", type: "error" });
        return;
    }

    return !hasError;
}

// USER - END DEFINE /////////////////////////////////////////////////////

// CATALOGUE - BEGIN DEFINE /////////////////////////////////////////////////////
// Function to toggle visibility of the dropdown menu
function toggleDropdown(menuId) {
    let menu = document.getElementById(menuId);

    // Close other dropdowns
    document.querySelectorAll(".dropdown-menu").forEach(dropdown => {
        if (dropdown.id !== menuId) {
            dropdown.style.display = "none";
        }
    });

    // Toggle the clicked dropdown
    menu.style.display = menu.style.display === "block" ? "none" : "block";
}

// Event listener to close dropdowns when clicking outside
document.addEventListener("click", function (event) {
    let isClickInside = event.target.closest(".dropdown");

    if (!isClickInside) {
        document.querySelectorAll(".dropdown-menu").forEach(dropdown => {
            dropdown.style.display = "none";
        });
    }
});

// Initialize: Hide all dropdowns on page load
window.addEventListener("load", function () {
    document.querySelectorAll(".dropdown-menu").forEach(dropdown => {
        dropdown.style.display = "none";
    });
});

// CATALOGUE - FILTER - BEGIN DEFINE /////////////////////////////////////////////////////
// Toggle filter options
// const filterOptions = document.querySelectorAll(".filter-option");
// const sortbyDisplay = document.getElementById("sortby-mode-display");
// const displayCatalogueName = document.getElementById("display-catalogue-name");

// filterOptions.forEach(option => {
//     option.addEventListener("click", (event) => {
//         let clickedElement = event.target;
//         if (!clickedElement.classList.contains("active")) {
//             clickedElement.classList.add("active");
//         } else {
//             clickedElement.classList.remove("active");
//         }
//     });
// });


// Toggle & display products by category
// document.querySelectorAll(".filter-category").forEach(category => {
//     category.addEventListener("click", (event) => {
//         if(event.target.dataset.filter == "Home"){
//             document.querySelector(".main-container-home").classList.add("Active");
//             document.querySelector(".main-container").classList.remove("Active");
//         }else{
//             document.querySelector(".main-container-home").classList.remove("Active");
//             document.querySelector(".main-container").classList.add("Active");
//         }
//         // If header-sidebar is open, toggle it off
//         let headerSideabar = document.getElementById("header-sidebar");
//         if (parseFloat(window.getComputedStyle(headerSideabar).getPropertyValue("width"))) {
//             toggleModal("header-sidebar");
//         }

//         // If toggle-page is open, toggle it off
//         let isTogglePage = document.querySelector(".toggle-page:not(.hidden)");
//         if (isTogglePage) {
//             if (isTogglePage.classList.contains("account-user")) togglePage("account-user");
//             if (isTogglePage.classList.contains("order-history")) togglePage("order-history");
//         }

//         document.querySelectorAll(".category-menu .filter-category.active").forEach(ele => ele.classList.remove("active"));
//         event.target.classList.add("active");
//         displayCatalogueName.innerText = event.target.innerText.trim();
//     });
// });

// Toggle search by name
// document.getElementById("search-bar").addEventListener("keyup", () => {
//     window.scrollTo({ top: 700, behavior: 'smooth' });
//     showHomeProduct(JSON.parse(localStorage.getItem("products")));

// })



// CATALOGUE - FILTER - END DEFINE /////////////////////////////////////////////////////

// CATALOGUE - ORDER HISTORY - BEGIN DEFINE /////////////////////////////////////////////////////

// function showOrderDetail(orderID) {
//     const orders = JSON.parse(localStorage.getItem("orders")) || [];
//     const order = orders[orders.findIndex(order => order.id == orderID)];
//     const orderDetail = document.getElementById("order-detail");
//     orderDetail.innerHTML = `
//                     <div class="modal-container mdl-cnt">
//                     <h3 class="modal-container-title">ORDER DETAIL</h3>
//                     <a onclick="closeModal()" style="position: absolute; right: 16px"><i class="fa-regular fa-circle-xmark"></i></a>
//                     <div class="order-detail-row">
//                         <span><i class="fa-solid fa-hashtag"></i>Order ID: </span>
//                         <span>${order.id}</span>
//                     </div>
//                     <div class="order-detail-row">
//                         <span><i class="fa-regular fa-calendar"></i>Purchase date: </span>
//                         <span>${formatDate(order.orderDate)}</span>
//                     </div>
//                     <div class="order-detail-row">
//                         <span><i class="fa-solid fa-location-dot"></i>Delivery address: </span>
//                         <span>${order.address.fullAddress}</span>
//                     </div>
//                     <div class="order-detail-row">
//                         <span><i class="fa-solid fa-map-location-dot"></i>Region: </span>
//                         <p>${order.address.region.ward}, ${order.address.region.district}, ${order.address.region.province}</p>
//                     </div>
//                     <div class="order-detail-row">
//                         <span><i class="fa-solid fa-cash-register"></i>Payment method: </span>
//                         <span>${order.payment.method}</span>
//                     </div>
//                     <div class="order-detail-row card-payment">
//                         <span><i class="fa-solid fa-user"></i>Card owner: </span>
//                         <span>${order.payment.cardOwner}</span>
//                     </div>
//                     <div class="order-detail-row card-payment">
//                         <span><i class="fa-regular fa-credit-card"></i>Card number: </span>
//                         <span>${order.payment.cardNumber}</span>
//                     </div>
//                 </div>
//     `;

//     if (order.payment.method.toLowerCase() != "card") {
//         orderDetail.querySelectorAll(".card-payment").forEach(item => item.style.display = "none");
//     }

//     orderDetail.classList.toggle("open");
// }

function getOrderHistoryCart(orderCart) {
    let OHCarthtml = ``;

    orderCart.forEach(item => {
        let product = getProduct(item);
        OHCarthtml += `
                <div class="modal-container cart-item" data-productID="${product.id}">
                    <div class="img-container">
                        <img src="${product.image}" onerror="this.src='./asset/img/catalogue/coming-soon.jpg'">
                    </div>
                    <div class="cart-item-info">
                        <p class="display-product-name">${product.name}</p>
                        <p>Brand: <span class="display-product-brand">${product.brand}</span></p>
                        <p>Size: <span class="display-product-size">${product.size}</span></p>
                        <p class="display-product-price">${vnd(product.originalPrice)}</p>
                    </div>
                    <div class="cart-item-amount">
                        <p>x<span class="display-product-quantity">${item.quantity}</span></p>
                    </div>
                </div>
            `;
    });

    return OHCarthtml;
}

function showOrderHistory() {
    let currentuser = JSON.parse(localStorage.getItem("currentuser"));
    let orders = JSON.parse(localStorage.getItem("orders")) || [];

    if (!currentuser) {
        console.log("showOrderHistory(): User not logged in.")
        return;
    }

    let OHbody = document.querySelector(".order-history .main-account-body-col");
    OHbody.innerHTML = "";
    if (orders.length !== 0) {
        let orderhtml = ``;
        orders.forEach((order, idx) => {
            if (order.customerId != currentuser.id) return;
            orderhtml += `
                    <div class="modal-container order-history" datda-orderID="${order.id}">
                        <div class="cart-main">
                            <div class="cart-body" style="max-height: 520px; overflow-y: auto">
                                ${getOrderHistoryCart(order.cart)}
                            </div>
                            <div class="cart-footer">
                                <div class="cart-totalprice">
                                    <p>GRAND TOTAL</p>
                                    <p class="display-totalprice">${vnd(order.total)}</p>
                                </div>
                                <div class="cart-item-status">
                                    <div style="background-color: var(${order_statusColor[order.status]})">
                                        <p class="display-order-status">Status: <span>${order_statusTitle[order.status]}</span>
                                        <span><i class="${order_statusIcon[order.status]}"></i></span></p>
                                    </div>
                                    <button onclick="showOrderDetail('${order.id}')">Details</button>
                                </div>
                            </div>
                        </div>
                    </div>
            `;
        });

        // Inject generated order history HTML into OHbody
        OHbody.innerHTML = orderhtml;
        console.log(OHbody);
    } else {
        displayWhenEmpty(".order-history .main-account-body-col", displayEmptyHTML_orderhistory);
    }
}

// CATALOGUE - ORDER HISTORY - END DEFINE /////////////////////////////////////////////////////

// CATALOGUE - PRODUCTS - BEGIN DEFINE ////////////////////////////////////////////////////////

function updateTotalPrice(quantity, priceElement, totalElement) {
    let price = parseInt(priceElement.textContent.replace(/\D/g, ""));
    let totalPrice = price * quantity;
    totalElement.textContent = new Intl.NumberFormat("vi-VN").format(totalPrice) + " ₫";
}


function detailProduct(id) {
    let modal = document.querySelector('.modal.product-detail');
    let body = document.body;

    // Gọi API để lấy chi tiết sản phẩm từ `productdetail.php`
    fetch(`view/productdetail.php?id=${id}`)
        .then(response => response.text()) // Lấy HTML từ productdetail.php
        .then(html => {
            document.querySelector('#product-detail-content').innerHTML = html;
            modal.classList.add('open'); // Hiện modal
            body.style.overflow = "hidden"; // Ẩn scroll của body

            // Đăng ký sự kiện chọn size và xử lý add-to-cart sau khi modal được mở
            setupEventListeners();
        })
        .catch(error => console.error("Lỗi khi tải sản phẩm:", error));
}

function increasingNumber(e) {
    let qty = e.parentNode.querySelector('.input-qty');
    let priceElement = document.querySelector('.current-price');
    let totalElement = document.querySelector('.price-total .price');

    let currentVal = parseInt(qty.value) || 1;
    let maxStock = parseInt(qty.getAttribute("max")) || 100;  // Lấy max stock từ thuộc tính max

    if (currentVal < maxStock) {
        qty.value = currentVal + 1;
    } else {
        qty.value = maxStock;  // Nếu vượt quá max, set lại giá trị bằng max
        toastMsg({
            title: "ERROR",
            message: "Cannot exceed stock quantity!",
            type: "error"
        });
    }

    updateTotalPrice(parseInt(qty.value), priceElement, totalElement);
}

function decreasingNumber(e) {
    let qty = e.parentNode.querySelector('.input-qty');
    let priceElement = document.querySelector('.current-price');
    let totalElement = document.querySelector('.price-total .price');

    let currentVal = parseInt(qty.value) || 1;
    let minVal = parseInt(qty.min) || 1;

    if (currentVal > minVal) {
        qty.value = currentVal - 1;
    } else {
        qty.value = minVal;
    }

    updateTotalPrice(parseInt(qty.value), priceElement, totalElement);
}


// Đóng modal khi nhấn vào nút đóng
document.querySelector('.modal-close').addEventListener('click', function () {
    document.querySelector('.modal.product-detail').classList.remove('open');
    document.body.style.overflow = "auto";
});


async function checkLogin() {
    try {
        const res = await fetch("/Web2/src/controller/db_controller/cart.php?action=check_login", {
            method: "POST",
            headers: { "Content-Type": "application/json" }
        });

        // Kiểm tra phản hồi có hợp lệ và là JSON không
        if (!res.ok) throw new Error("Network response was not ok");
        
        const contentType = res.headers.get("content-type");
        if (!contentType || !contentType.includes("application/json")) {
            throw new Error("Expected JSON, got something else!");
        }

        const data = await res.json();

        if (!data.success) {
            toastMsg({
                title: data.title || "REMINDER",
                message: data.message || "Please login first!",
                type: data.type || "info"
            });
            return false;
        }

        return true;
    } catch (err) {
        console.error("Login check error:", err);
        toastMsg({
            title: "ERROR",
            message: "Can not detect the login status!",
            type: "error"
        });
        return false;
    }
}

// Đăng ký sự kiện chọn size và thêm vào giỏ hàng
function setupEventListeners() {
    let selectedSizeId = null;

    // Kiểm tra xem phần tử size-container có tồn tại không
    const sizeContainer = document.querySelector(".size-container");
    if (!sizeContainer) {
        console.error("Không tìm thấy phần tử size-container!");
        return;
    }

    // Xử lý chọn size
    sizeContainer.addEventListener("click", (event) => {
        if (event.target.tagName === "BUTTON") {
            // Loại bỏ active class từ tất cả các button
            document.querySelectorAll(".size-container button").forEach(button => {
                button.classList.remove("active");
            });
            event.target.classList.add("active");

            // Lấy ProductSizeID từ data-sizeid
            selectedSizeId = event.target.getAttribute('data-sizeid');
            if (selectedSizeId) {
                console.log("Selected ProductSizeID: " + selectedSizeId);
            } else {
                console.error("Không thể lấy ProductSizeID từ button!");
            }
        }
    });

    document.querySelectorAll(".size-button").forEach(btn => {
        btn.addEventListener("click", function () {
            document.querySelectorAll(".size-button").forEach(b => b.classList.remove("active"));
            this.classList.add("active");

            const stock = this.getAttribute("data-stock");
            const qtyInput = document.querySelector(".input-qty");

            qtyInput.setAttribute("max", stock);
            qtyInput.setAttribute("data-stock", stock);
            qtyInput.value = 1;

            const priceElement = document.querySelector(".current-price");
            const totalElement = document.querySelector(".price-total .price");
            updateTotalPrice(1, priceElement, totalElement);
        });
    });

    // Kiểm tra phần tử add-cart có tồn tại không trước khi đăng ký sự kiện
    const addCartButton = document.querySelector('#add-cart');
    if (!addCartButton) {
        console.error("Không tìm thấy nút 'Add to Cart'!");
        return;
    }

    // Sự kiện "Add to Cart"
    addCartButton.addEventListener('click', async () => {
        if (!selectedSizeId) {
            toastMsg({ title: "REMINDER", message: "Please choose a size first!", type: "info" });
            return;
        }
    
        const isLoggedIn = await checkLogin();
        if (!isLoggedIn) return;
    
        let quantityInput = document.querySelector(".input-qty");
        let quantity = quantityInput ? parseInt(quantityInput.value) : 1;
        let price = parseInt(document.querySelector(".current-price").dataset.price || 0);

        try {
            const response = await fetch("/Web2/src/controller/db_controller/cart.php?action=add_to_cart", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ productsizeid: selectedSizeId, quantity, price })
            });
    
            console.log("Response Status: ", response.status); // Log mã trạng thái HTTP
            const textResponse = await response.text(); // Đọc phản hồi dưới dạng text
    
            console.log("Raw response: ", textResponse); // Log nội dung raw của phản hồi
    
            // Kiểm tra xem phản hồi có phải là JSON không
            let data;
            try {
                data = JSON.parse(textResponse); // Cố gắng chuyển đổi nội dung thành JSON
            } catch (error) {
                console.error("Response is not valid JSON:", error);
                toastMsg({ title: "ERROR", message: "Server response is not JSON", type: "error" });
                return;
            }
    
            if (data.success) {
                toastMsg({ title: "SUCCESS", message: "Added successfully!", type: "success" });
                loadCartSummary(); 
                if (quantityInput) quantityInput.value = 1;
                document.querySelector('.modal.product-detail').classList.remove('open');
                document.body.style.overflow = "auto";

            } else {
                toastMsg({ title: "ERROR", message: data.message || "Error occurred.", type: "error" });
            }
        } catch (err) {
            console.error("Lỗi khi fetch:", err);
        }
    });
    
    

    // Kiểm tra phần tử checkout-btn có tồn tại không trước khi đăng ký sự kiện
    const checkoutButton = document.querySelector("#checkout-modal-btn");
    if (!checkoutButton) {
        console.error("Không tìm thấy nút 'Buy Now'!");
        return;
    }

    // Sự kiện "Buy Now"
    checkoutButton.addEventListener("click", async () => {
        if (!selectedSizeId) {
            toastMsg({ title: "REMINDER", message: "Please choose a size first!", type: "info" });
            return;
        }
    
        const isLoggedIn = await checkLogin();
        if (!isLoggedIn) return;
    
        let quantityInput = document.querySelector(".product-detail .input-qty");
        let quantity = quantityInput ? parseInt(quantityInput.value) : 1;
        let price = parseInt(document.querySelector(".current-price").dataset.price || 0);

        console.log("selectedSizeId:", selectedSizeId, "quantity:", quantity, "price:", price);

        fetch("/Web2/src/controller/db_controller/cart.php?action=buy_now", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ productsizeid: selectedSizeId, quantity, price })
        })
        .then(res => {
            console.log("Response Status:", res.status);
            return res.json();
        })
        .then(data => {
            if (data.success) {
                window.checkoutMode = "buy_now";
                toggleModal("product-detail");
                toggleModal("checkout-page");
                renderCheckoutUI();
            } else {
                toastMsg({ title: "ERROR", message: data.message || "Error occurred.", type: "error" });
            }
        })
        .catch(err => console.error("Lỗi:", err));
    });
}    

function handleReturnFromCheckout() {
    console.log("checkoutMode hiện tại:", window.checkoutMode);
    if (window.checkoutMode === "buy_now") {
        // Gọi API xoá session checkout nếu đang trong chế độ 'buy now'
        fetch("/Web2/src/controller/db_controller/cart.php?action=clear_checkout_session", {
            method: "POST"
        });
    }

    window.checkoutMode = null; // reset lại mode
    toggleModal("checkout-page"); // đóng modal
    document.body.style.overflow = "auto";
}


function renderCheckoutUI() {
    console.log("checkoutMode trong renderCheckoutUI:", window.checkoutMode);
    const checkoutBody = document.querySelector(".checkout-page .cart-body");
    const totalPriceElem = document.querySelector(".checkout-page .display-totalprice");

    // Kiểm tra phần tử có tồn tại không trước khi thao tác
    if (!checkoutBody || !totalPriceElem) {
        console.warn("Không tìm thấy .cart-body hoặc .display-totalprice trong checkout-page.");
        return;
    }

    // Giả sử bạn đã lưu thông tin trong session, bây giờ fetch dữ liệu từ session
    fetch("/Web2/src/controller/db_controller/cart.php?action=get_checkout_session", {method: "POST"})
    .then(res => {
        if (!res.ok) throw new Error("Lỗi khi fetch dữ liệu từ session.");
            return res.json(); // Giờ chỗ này sẽ không lỗi nữa
        })    
        .then(data => {
            if (!data.success || !data.product) {
                checkoutBody.innerHTML = "<p>Không có sản phẩm nào trong session.</p>";
                totalPriceElem.innerHTML = "0 VND";
                document.querySelectorAll(".display-totalorder").forEach(el => el.innerText = "0 VND");
                return;
            }

            // Lấy thông tin sản phẩm duy nhất từ session
            const product = data.product;

            // Hiển thị sản phẩm duy nhất vào giao diện
            const checkoutHTML = `
                <div class="modal-container cart-item" data-productID="${product.ProductSizeID}">
                    <div class="img-container">
                        <img src="${product.product_image}" onerror="this.src='/assets/img/placeholder.jpg'">
                    </div>
                    <div class="cart-item-info">
                        <p class="display-product-name">${product.product_name}</p>
                        <p>Size: <span class="display-product-size">${product.Size}</span></p>
                        <p class="display-product-price" style="position: absolute; bottom: 1.5rem; right: 0;">${vnd(product.Price)}</p>
                    </div>
                    <div class="cart-item-amount">
                        <p>x<span class="display-product-quantity">${product.Quantity}</span></p>
                    </div>
                </div>
            `;

            // Render sản phẩm vào body modal
            checkoutBody.innerHTML = checkoutHTML;
            // Hiển thị tổng giá (vì chỉ có một sản phẩm, tổng giá là giá sản phẩm * số lượng)
            totalPriceElem.innerHTML = vnd(product.Price * product.Quantity);
            updateBuyNowSummary(product);
        })
        .catch(err => {
            console.error("Lỗi khi tải dữ liệu từ session:", err);
            checkoutBody.innerHTML = "<p>Đã xảy ra lỗi khi tải dữ liệu từ session.</p>";
            totalPriceElem.innerHTML = "0 VND";
        });
}

function updateBuyNowSummary(product) {
    const DELIVERY_FEE = 30000;
    const totalPrice = product.Price * product.Quantity;
    const totalOrder = totalPrice + DELIVERY_FEE;

    document.querySelectorAll(".display-totalprice").forEach(el => el.innerText = vnd(totalPrice));
    document.querySelectorAll(".display-totalorder").forEach(el => el.innerText = vnd(totalOrder));
}



// CART - BEGIN DEFINE /////////////////////////////////////////////


// Cập nhật hiển thị tổng số lượng và giá tiền
// Cập nhật tổng cho các sản phẩm được chọn
function updateTotalPriceCart() {
    let totalQty = 0;
    let totalPrice = 0;

    // Lấy tất cả các checkbox đã được chọn
    const selectedItems = document.querySelectorAll(".checkout-checkbox:checked");

    // Nếu không có sản phẩm nào được chọn, không tính toán tổng
    if (selectedItems.length === 0) {
        updateCartSummary(0, 0);  // Cập nhật lại tổng giỏ hàng là 0
        return;
    }

    selectedItems.forEach(item => {
        const productID = item.dataset.productsizeid;
        const productElement = document.querySelector(`.cart-item[data-productID="${productID}"]`);
        const price = parseInt(productElement.querySelector(".display-product-price").innerText.replace(/[^0-9]/g, "")); // Lấy giá sản phẩm
        const quantity = parseInt(productElement.querySelector(".input-qty").value); // Lấy số lượng sản phẩm

        totalPrice += price * quantity;  // Cộng tổng giá
        totalQty += quantity;  // Cộng tổng số lượng
    });

    // Cập nhật lại tổng giá và tổng số lượng
    updateCartSummary(totalQty, totalPrice);
}

// Hàm để cập nhật lại tổng số lượng và tổng tiền
function updateCartSummary(totalQty, totalPrice) {
    const DELIVERY_FEE = 30000;

    document.querySelectorAll(".display-cart-total-amount").forEach(el => el.innerText = totalQty);
    document.querySelectorAll(".display-totalprice").forEach(el => el.innerText = vnd(totalPrice));
    document.querySelectorAll(".display-totalorder").forEach(el => {
        const finalTotal = totalPrice + DELIVERY_FEE;
        el.innerText = vnd(finalTotal);
    });
}


// Load tóm tắt cart (dùng riêng cho header)
function loadCartSummary(callback) {
    fetch("controller/db_controller/cart.php?action=get_cart")
        .then(res => res.json())
        .then(data => {
            let totalQty = 0;
            let totalPrice = 0;
            if (data.success) {
                data.cart.forEach(item => {
                    totalQty += parseInt(item.Quantity);
                    totalPrice += item.Quantity * item.Price;
                });
            }
            updateCartSummary(totalQty, totalPrice);
            if (callback) callback();
        })
        .catch(err => {
            console.error("Failed to load cart summary", err);
            updateCartSummary(0, 0);
            if (callback) callback();
        });
}

// Xử lý cập nhật số lượng
function updateCartAll(productSizeID, size, el, stockQuantity) {
    const parent = el.closest(".cart-item");
    const input = parent.querySelector(".input-qty");
    let quantity = parseInt(input.value);

    if (quantity < 1) quantity = 1;
    if (quantity > stockQuantity) quantity = stockQuantity;
    input.value = quantity;

    fetch("controller/db_controller/cart.php?action=update_cart", {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ productsizeid: productSizeID, quantity })
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showCart(); // reload cart
                loadCartSummary();
            } else {
                toastMsg({ title: "Error", message: data.message, type: "error" });
            }
        });
}

// Xử lý xóa sản phẩm
function deleteCartItem(productsizeid, el) {
    fetch("controller/db_controller/cart.php?action=delete_cart_item", {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ productsizeid })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            toastMsg({ title: "Deleted", message: data.message, type: "info" });
            showCart(); // reload cart
            loadCartSummary();
        } else {
            toastMsg({ title: "ERROR", message: data.message, type: "error" });
        }
    });
}

// Hiển thị giỏ hàng
function showCart() {
    const cartBody = document.querySelector(".cart .cart-body");
    const checkoutBtn = document.getElementById("cart-checkout-btn");

    if (!cartBody || !checkoutBtn) return;

    fetch("controller/db_controller/cart.php?action=get_cart")
        .then(res => res.json())
        .then(data => {
            cartBody.innerHTML = "";

            if (data.login_required === true) {
                checkoutBtn.classList.remove("active");
                checkoutBtn.disabled = true;
                document.getElementById('select-all-wrapper').style.display = 'none';
                return;
            }

            if (!data.success || !Array.isArray(data.cart) || data.cart.length === 0) {
                checkoutBtn.classList.remove("active");
                checkoutBtn.disabled = true;
                document.getElementById('select-all-wrapper').style.display = 'none';
                displayWhenEmpty(".cart .cart-body", displayEmptyHTML_cart);
                updateCartSummary(0, 0);
                return;
            }

            document.getElementById('select-all-wrapper').style.display = 'flex';
            checkoutBtn.classList.add("active");
            checkoutBtn.disabled = false;

            let cartItemhtml = "";

            data.cart.forEach(item => {
                const stock = item.StockQuantity;
                let qty = item.Quantity;

                // Auto fix nếu vượt quá tồn kho
                if (qty > stock) {
                    qty = stock;
                }

                const isOutOfStock = stock <= 0;
                const isQuantityExceedStock = qty > stock;
                const isDisabled = isOutOfStock || isQuantityExceedStock;

                cartItemhtml += `
                    <div class="modal-container cart-item" data-productID="${item.ProductSizeID}">
                        <div class="cart-item-checkbox">
                            <label>
                                <input type="checkbox" 
                                       class="checkout-checkbox" 
                                       data-productsizeid="${item.ProductSizeID}" 
                                       onchange="updateTotalPriceCart()" 
                                       ${isDisabled ? 'disabled' : ''}>
                            </label>
                        </div>
                        <div class="img-container">
                            <img src="${item.product_image}" onerror="this.src='/assets/img/placeholder.jpg'">
                        </div>
                        <div class="cart-item-info">
                            <p class="display-product-name">${item.product_name}</p>
                            <p>Size: <span class="display-product-size">${item.Size}</span></p>
                            <p class="display-product-price">${vnd(item.Price)}</p>
                        </div>
                        <div class="cart-item-control">
                            <a onclick="deleteCartItem(${item.ProductSizeID}, this)">
                                <i class="fa-regular fa-circle-xmark"></i>
                            </a>
                            <div class="cart-item-amount">
                                <button class="minus is-form" 
                                        onclick="decreasingNumberCart(this)"
                                        ${isDisabled ? 'disabled' : ''}>
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                                <input class="input-qty" 
                                       type="number"
                                       min="1"
                                       max="${stock}"
                                       value="${Math.max(1, qty)}"
                                       data-stock="${stock}"
                                       ${isDisabled ? 'disabled' : ''} 
                                       oninput="handleInputChangeCart(this, ${item.ProductSizeID}, '${item.Size}')">
                                <button class="plus is-form" 
                                        onclick="increasingNumberCart(this)"
                                        ${isDisabled ? 'disabled' : ''}>
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });            

            cartBody.innerHTML = cartItemhtml;
            updateTotalPriceCart();
        })
        .catch(err => {
            console.error("Failed to load cart:", err);
            document.getElementById('select-all-wrapper').style.display = 'none';
            displayWhenEmpty(".cart .cart-body", "<p>Error occurred while loading cart.</p>");
            updateCartSummary(0, 0);
        });
}

function increasingNumberCart(btn) {
    const input = btn.parentNode.querySelector('.input-qty');
    let currentVal = parseInt(input.value) || 1;
    let maxStock = parseInt(input.getAttribute("max")) || 100;

    if (currentVal < maxStock) {
        input.value = currentVal + 1;
    } else {
        input.value = maxStock;
        toastMsg({
            title: "ERROR",
            message: "Cannot exceed stock quantity!",
            type: "error"
        });
    }

    triggerUpdateCart(input);
}

function decreasingNumberCart(btn) {
    const input = btn.parentNode.querySelector('.input-qty');
    let currentVal = parseInt(input.value) || 1;
    let min = parseInt(input.getAttribute("min")) || 1;

    if (currentVal > min) {
        input.value = currentVal - 1;
    } else {
        input.value = min;
    }

    triggerUpdateCart(input);
}

function handleInputChangeCart(input, productSizeID, size) {
    let val = parseInt(input.value) || 1;
    let max = parseInt(input.getAttribute("max")) || 100;
    let min = parseInt(input.getAttribute("min")) || 1;

    if (val > max) {
        input.value = max;
        toastMsg({
            title: "ERROR",
            message: "Cannot exceed stock quantity!",
            type: "error"
        });
    } else if (val < min) {
        input.value = min;
    }

    triggerUpdateCart(input);
}

function triggerUpdateCart(input) {
    const container = input.closest('.cart-item');
    const productSizeID = container.getAttribute('data-productid');
    const size = container.querySelector('.display-product-size')?.textContent || "";
    const newQty = parseInt(input.value);
    const stock = parseInt(input.getAttribute('data-stock'));

    // Cập nhật lại checkbox (disable/enable)
    const checkbox = container.querySelector('.checkout-checkbox');

    if (newQty <= stock) {
        checkbox.disabled = false;
    } else {
        checkbox.disabled = true;
    }

    updateCartAll(productSizeID, size, input, stock);
    updateTotalPriceCart();
}

function handleSelectAll(el) {
    const itemCheckboxes = document.querySelectorAll(".checkout-checkbox:not(#select-all-checkbox)");

    itemCheckboxes.forEach(cb => {
        if (!cb.disabled) {
            cb.checked = el.checked;
        }
    });

    updateTotalPriceCart();
}

document.querySelectorAll(".checkout-checkbox").forEach(cb => {
    cb.addEventListener("change", updateTotalPriceCart);
});

// Format tiền VNĐ
function vnd(x) {
    return x.toLocaleString("vi-VN", { style: "currency", currency: "VND" });
}


// CATALOGUE - CART - END DEFINE /////////////////////////////////////////////////////


// CATALOGUE - END DEFINE /////////////////////////////////////////////////////

// BANNER - BEGIN /////////////////////////////////////////////////////

const imageArray = [
    '/Web2/src/view/layout/asset/img/banner/banner1.jpg',
    '/Web2/src/view/layout/asset/img/banner/banner2.jpg',
    '/Web2/src/view/layout/asset/img/banner/banner3.jpg'
];

const bannerImagesContainer = document.querySelector('.banner-images');
let currentIndex = 0;


// Tạo ảnh từ mảng
imageArray.forEach((src) => {
    const img = document.createElement('img');
    img.src = src;
    img.classList.add('banner-img');
    bannerImagesContainer.appendChild(img);
});

// Thêm ảnh đầu tiên vào cuối
const firstImageClone = document.createElement('img');
firstImageClone.src = imageArray[0];
firstImageClone.classList.add('banner-img');
bannerImagesContainer.appendChild(firstImageClone);

const totalImages = imageArray.length;

// Hàm di chuyển slide
function moveSlide(direction) {
    currentIndex += direction;

    if (currentIndex === totalImages) {
        // Chuyển đến ảnh clone
        bannerImagesContainer.style.transition = 'transform 1s ease';
        bannerImagesContainer.style.transform = `translateX(-${currentIndex * 100}%)`;

        setTimeout(() => {
            // Nhảy về ảnh đầu tiên
            bannerImagesContainer.style.transition = 'none';
            currentIndex = 0;
            bannerImagesContainer.style.transform = `translateX(0%)`;
        }, 1000); // Phù hợp với thời gian transition
    } else if (currentIndex < 0) {
        // Lùi về ảnh cuối
        bannerImagesContainer.style.transition = 'none';
        currentIndex = totalImages - 1;
        bannerImagesContainer.style.transform = `translateX(-${currentIndex * 100}%)`;
    } else {
        // Di chuyển bình thường
        bannerImagesContainer.style.transition = 'transform 1s ease';
        bannerImagesContainer.style.transform = `translateX(-${currentIndex * 100}%)`;
    }
}

// Chuyển ảnh tự động sau mỗi 10 giây
setInterval(() => {
    moveSlide(1);
}, 10000); // 10 giây


// BANNER - END /////////////////////////////////////////////////////


document.addEventListener("DOMContentLoaded", function () {
    loadCartSummary(); // gọi để update số lượng trong header khi trang vừa load
});
