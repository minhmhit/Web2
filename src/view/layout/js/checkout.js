const checkoutPage = document.getElementById("checkout-page");

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".display-deliveryfee").forEach(ele => {
        ele.innerText = vnd(30000);
    });
});

function togglePaymentMethod(method) {
    document.getElementById('cash-option').style.display = method === 'cash' ? 'block' : 'none';
    document.getElementById('card-option').style.display = method === 'card' ? 'block' : 'none';
}

function toggleAddressMethod(method) {
    const accountInfo = document.getElementById('default-address');
    const newAddressInput = document.getElementById('new-address');

    if (method === 'new') {
        accountInfo.style.display = 'none';
        newAddressInput.style.display = 'flex';
    } else if (method === 'default') {
        accountInfo.style.display = 'block';
        newAddressInput.style.display = 'none';
    }
}

function showCartCheckout() {
    if (!localStorage.getItem("currentuser")) {
        console.log("showCartCheckout(): User not logged in.");
        return false;
    }

    let currentuser = JSON.parse(localStorage.getItem("currentuser"));
    const cartBody = document.querySelector(".checkout-page .cart-body");
    cartBody.style.maxHeight = "520px";
    cartBody.style.overflowY = "auto";

    if (currentuser.cart.length !== 0) {
        // Show the checkout button and generate cart items HTML
        let cartItemhtml = "";
        currentuser.cart.forEach(item => {
            let product = getProduct(item);
            cartItemhtml += `
                    <div class="modal-container cart-item" data-productID="${product.id}">
                        <div class="img-container">
                            <img src="${product.image}" onerror="this.src='.view/layout/asset/img/catalogue/coming-soon.jpg'">
                        </div>
                        <div class="cart-item-info">
                            <p class="display-product-name">${product.name}</p>
                            <p>Brand: <span class="display-product-brand">${product.brand}</span></p>
                            <p>Size: <span class="display-product-size">${product.size}</span></p>
                            <p class="display-product-price" style="position: absolute; bottom: 1.5rem; right: 0;">${vnd(product.price)}</p>
                        </div>
                        <div class="cart-item-amount">
                            <p>x<span class="display-product-quantity">${item.quantity}</span></p>
                        </div>
                    </div>
                `;
        });
        // Inject cart items into cart body
        cartBody.innerHTML = cartItemhtml;
    }
    return cartBody.innerHTML;
}

function validateAddress() {
    const addressOption = checkoutPage.querySelector('input[name="address-option"]:checked');
    let isAddressValid = false;
    let addressDetails = {};

    // Get region values
    const province = document.getElementById("province").value.trim();
    const district = document.getElementById("district").value.trim();
    const ward = document.getElementById("ward").value.trim();

    const checkoutType = addressOption.getAttribute("checkout-type");
    if (!addressOption) {
        toastMsg({ title: "ERROR", message: "Please select an address option.", type: "error" });
        return { isAddressValid, addressDetails };
    }

    checkoutPage.querySelectorAll(".form-msg-error").forEach(msg => msg.textContent = "");

    if (!province || !district || !ward) {
        checkoutPage.querySelector(".region-selector + .form-msg-error").innerText = "Please select a region.";
        toastMsg({ title: "ERROR", message: "Please select a region.", type: "error" });
        return { isAddressValid, addressDetails };
    }

    if (checkoutType === "default-address") {
        // Default address validation
        const defaultAddress = document.getElementById("default-address").value.trim();
        if (!defaultAddress) {
            toastMsg({ title: "ERROR", message: "Cannot read address from user.", type: "error" });
        } else {
            isAddressValid = true;
            addressDetails = {
                fullAddress: defaultAddress,
                region: {
                    province: province,
                    district: district,
                    ward: ward,
                }
            };
        }
    } else if (checkoutType === "new-address") {
        // New address validation
        const newAddress = document.getElementById("checkout-address-new").value.trim();
        if (!newAddress) {
            checkoutPage.querySelector("#checkout-address-new + .form-msg-error").innerText = "Field must not be empty.";
            isAddressValid = false;
        } else {
            isAddressValid = true;
            addressDetails = {
                fullAddress: newAddress,
                region: {
                    province: province,
                    district: district,
                    ward: ward,
                }
            };
        }
    }

    return { isAddressValid, addressDetails };
}

function validatePayment() {
    const paymentMethod = checkoutPage.querySelector('input[name="payment-method"]:checked');
    let isPaymentValid = true;
    let paymentDetails = {};

    if (!paymentMethod) {
        toastMsg({ title: "ERROR", message: "Please select a payment method.", type: "error" });
        isPaymentValid = false;
        return { isPaymentValid, paymentDetails };
    }

    if (paymentMethod.value === "cash") {
        isPaymentValid = true;
        paymentDetails = {
            method: "Cash"
        };
    } else if (paymentMethod.value === "card") {
        const cardOwner = document.getElementById("card-owner-name").value.trim().toUpperCase();
        const cardNumber = document.getElementById("card-number").value.trim();
        const cvv = document.getElementById("cvv").value.trim();
        const expDate = document.getElementById("card-expdate").value.trim();

        if (!cardOwner) {
            checkoutPage.querySelector("#card-owner-name + .form-msg-error").innerText = "Field must not be empty.";
            isPaymentValid = false;
        }

        if (!cvv || cvv.length < 3) {
            checkoutPage.querySelector("#cvv + .form-msg-error").innerText = "CVV must be at least 3 digits.";
            isPaymentValid = false;
        }

        if (!cardNumber || cardNumber.length < 12) {
            checkoutPage.querySelector("#card-number + .form-msg-error").innerText = "Card number must be at least 12 digits.";
            isPaymentValid = false;
        }

        const currentDate = new Date();
        currentDate.setHours(0, 0, 0, 0);
        if (!expDate) {
            checkoutPage.querySelector("#card-expdate + .form-msg-error").innerText = "Please pick a date.";
            isPaymentValid = false;
        } else if (new Date(expDate).getTime() <= currentDate.getTime()) {
            checkoutPage.querySelector("#card-expdate + .form-msg-error").innerText = "Card has expired."
            isPaymentValid = false;
        }

        if (isPaymentValid) {
            paymentDetails = {
                method: "Card",
                cardOwner: cardOwner,
                cvv: cvv,
                cardNumber: cardNumber
            };
        } else {
            toastMsg({ title: "ERROR", message: "Please fill out all fields correctly for card payment.", type: "error" });
        }
    }

    return { isPaymentValid, paymentDetails };
}

function handleCheckout() {
    // Clear error msg
    checkoutPage.querySelectorAll(".form-msg-error").forEach(msg => {
        msg.textContent = "";
    })

    // First, validate address and payment
    const addressValidation = validateAddress();
    const paymentValidation = validatePayment();

    // Proceed only if both address and payment are valid
    if (!addressValidation.isAddressValid || !paymentValidation.isPaymentValid) {
        // toastMsg({ title: "ERROR", message: "Please complete all forms before proceeding.", type: "error" });
        return;
    }

    const currentuser = JSON.parse(localStorage.getItem("currentuser"));
    if (!currentuser) {
        toastMsg({ title: "ERROR", message: "You must be logged in to checkout.", type: "error" });
        return;
    }

    //Save to local storage: orders
    const orders = localStorage.getItem("orders") ? JSON.parse(localStorage.getItem("orders")) : [];
    let newOrder = {
        id: ID_TYPE[2] + (orders.length + 1),
        customerId: currentuser.id,
        cart: currentuser.cart,
        address: addressValidation.addressDetails,
        payment: paymentValidation.paymentDetails,
        orderDate: new Date(),
        total: getCartTotalPrice() + DELIVERY_FEE,
        status: 0,
    }

    orders.push(newOrder);
    localStorage.setItem("orders", JSON.stringify(orders));

    resetCart();
    toggleModal("checkout-page");

    toastMsg({ title: "SUCCESS", message: "Checkout success! More details in My Order.", type: "success" });

    console.group();
    console.log(`handleCheckout(): Order of id ${newOrder.id} saved to local storage`);
    console.log(newOrder);
    console.groupEnd();

}