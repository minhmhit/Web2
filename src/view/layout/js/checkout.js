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

document.getElementById("checkout-address-new").addEventListener("input", () => {
    document.querySelector("#new-address .form-msg-error").textContent = "";
});
["province", "district", "ward"].forEach(id => {
    document.getElementById(id).addEventListener("change", () => {
        document.querySelector(".region-selector + .form-msg-error").textContent = "";
    });
});

function handleCheckout() {
    console.log("🚀 Unified Checkout started");

    // 1. Kiểm tra địa chỉ
    if (!validateAddress()) {
        console.log("❌ Address validation failed");
        return;
    }

    // 2. Kiểm tra thanh toán
    const paymentValidation = validatePayment();
    if (!paymentValidation.isPaymentValid) {
        console.log("❌ Payment validation failed");
        return;
    }

    const isNewAddress = document.getElementById("new-address-option").checked;
    let address = {};

    if (isNewAddress) {
        address = {
            address: document.getElementById("checkout-address-new").value.trim(),
            region: {
                province: document.getElementById("province").value,
                district: document.getElementById("district").value,
                ward: document.getElementById("ward").value
            }
        };
    } else {
        address = {
            address: document.getElementById("default-address").value.trim(),
            region: {
                province: defaultProvinceId,
                district: defaultDistrictId,
                ward: defaultWardId
            }
        };
    }

    const paymentDetails = paymentValidation.paymentDetails;

    // 3. Gửi request tạo đơn hàng (dùng session có sẵn)
    fetch("controller/db_controller/checkout.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            action: window.checkoutMode,
            address: address,
            payment: paymentDetails
        })
    })
    .then(res => res.text())
    .then(data => {
        console.log("📦 Server response:", data);
        try {
            const jsonData = JSON.parse(data);
            if (jsonData.success) {
                toastMsg({ title: "Success", message: "Your order has been recorded!", type: "success" });
                window.checkoutMode = null;
                toggleModal("checkout-page");
                fetch("/Web2/src/controller/db_controller/cart.php?action=clear_checkout_session", {
                    method: "POST"
                });

                showCart();
                loadCartSummary(); 
                fetchHeaderQty(); 
            } else {
                toastMsg({ title: "Error", message: jsonData.message, type: "error" });
            }
        } catch (e) {
            toastMsg({ title: "Error", message: "Invalid response from server.", type: "error" });
            console.error("Parse error:", e);
        }
    })
    .catch(err => {
        toastMsg({ title: "Error", message: "Có lỗi khi đặt hàng.", type: "error" });
        console.error("Checkout error:", err);
    });
}

function fetchHeaderQty() {
    fetch("controller/db_controller/cart.php?action=get_cart")
        .then(res => res.json())
        .then(data => {
            if (data.success && Array.isArray(data.cart)) {
                let totalQty = 0;
                data.cart.forEach(item => {
                    const qty = item.Quantity;

                    totalQty += qty; // Cộng số lượng sản phẩm dù có hết hàng hay không


                });
                updateCartQtyInHeader(totalQty); // Cập nhật tổng số lượng trong header
            } else {
                updateCartQtyInHeader(0);
            }
        });
}

function validateAddress() {
    const isNew = getComputedStyle(document.getElementById("new-address")).display !== 'none';
    console.log("🔍 Using new address?", isNew);

    document.querySelectorAll(".form-msg-error").forEach(el => el.textContent = "");

    if (!isNew) return true;

    let isValid = true;
    const address = document.getElementById("checkout-address-new").value.trim();
    const province = document.getElementById("province").value;
    const district = document.getElementById("district").value;
    const ward = document.getElementById("ward").value;

    if (!address) {
        document.querySelector("#new-address .form-msg-error").textContent = "Please enter your address.";
        isValid = false;
    }

    if (!province || !district || !ward) {
        document.querySelector(".region-selector + .form-msg-error").textContent = "Please select a full region.";
        isValid = false;
    }

    return isValid;
}


function validatePayment() {
    const paymentMethod = document.querySelector('input[name="payment-method"]:checked');
    let isPaymentValid = true;
    let paymentDetails = {};

    if (!paymentMethod) {
        toastMsg({ title: "REMINDER", message: "Please select a payment method.", type: "info" });
        return { isPaymentValid: false, paymentDetails };
    }

    if (paymentMethod.value === "cod") {
        return { isPaymentValid: true, paymentDetails: { method: "COD" } };
    }

    const cardOwner = document.getElementById("card-owner-name").value.trim().toUpperCase();
    const cardNumber = document.getElementById("card-number").value.trim();
    const cvv = document.getElementById("cvv").value.trim();
    const expDate = document.getElementById("card-expdate").value;
    const saveCard = document.getElementById("save-card-checkbox").checked;

    // Validate fields
    if (!cardOwner) {
        document.querySelector("#card-owner-name + .form-msg-error").innerText = "Field must not be empty.";
        isPaymentValid = false;
    }

    if (!/^\d{3}$/.test(cvv)) {
        document.querySelector("#cvv + .form-msg-error").innerText = "CVV must be exactly 3 digits.";
        isPaymentValid = false;
    }

    if (!/^\d{16}$/.test(cardNumber)) {
        document.querySelector("#card-number + .form-msg-error").innerText = "Card number must be 16 digits.";
        isPaymentValid = false;
    }

    if (!expDate) {
        document.querySelector("#card-expdate + .form-msg-error").innerText = "Please pick a date.";
        isPaymentValid = false;
    } else {
        const now = new Date();
        const [expYear, expMonth] = expDate.split('-').map(Number);
        const expiryDate = new Date(expYear, expMonth - 1);
        if (expiryDate < new Date(now.getFullYear(), now.getMonth())) {
            document.querySelector("#card-expdate + .form-msg-error").innerText = "Card has expired.";
            isPaymentValid = false;
        }
    }

    if (!isPaymentValid) {
        toastMsg({ title: "REMINDER", message: "Please fill out all fields correctly for card payment.", type: "info" });
        return { isPaymentValid, paymentDetails };
    }

    paymentDetails = {
        method: "Card",
        cardOwner,
        cardNumber,
        cvv,
        expiryDate: expDate,
        saveCard
    };

    return { isPaymentValid, paymentDetails };
}


document.addEventListener("DOMContentLoaded", () => {
    fetch("controller/db_controller/checkout.php?action=init")
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Lấy thông tin địa chỉ mặc định
                const { Address, ProvinceID, DistrictID, WardID } = data.defaultAddress;
                
                // Lưu các giá trị tỉnh, quận, xã cho sau này
                defaultProvinceId = parseInt(ProvinceID);
                defaultDistrictId = parseInt(DistrictID);
                defaultWardId = parseInt(WardID);

                // Nếu có dữ liệu default address, cập nhật vào các trường
                if (Address) {
                    document.getElementById("default-address").value = Address;
                }
                if (ProvinceID) {
                    document.getElementById("province").value = ProvinceID;
                }
                if (DistrictID) {
                    document.getElementById("district").value = DistrictID;
                }
                if (WardID) {
                    document.getElementById("ward").value = WardID;
                }

                // Load thông tin thẻ nếu có
                if (data.savedCard) {
                    const { CardOwner, CardNumber, CVV, ExpiryDate } = data.savedCard;
                    document.getElementById("card-owner-name").value = CardOwner;
                    document.getElementById("card-number").value = CardNumber;
                    document.getElementById("cvv").value = CVV;
                    document.getElementById("card-expdate").value = ExpiryDate;
                }
            }
        })
        .catch(async (err) => {
            const responseText = await err?.text?.();
            console.error("Lỗi khi fetch init checkout:", err, responseText);
        });
});


let defaultProvinceId = null;
let defaultDistrictId = null;
let defaultWardId = null;
let defaultAddress = null;

function toggleAddressMethod(method) {
    const accountInfo = document.getElementById('default-address');
    const newAddressInput = document.getElementById('new-address');

    const provinceSelect = document.getElementById("province");
    const districtSelect = document.getElementById("district");
    const wardSelect = document.getElementById("ward");

    // Reset thông báo lỗi mỗi lần toggle
    document.querySelectorAll(".form-msg-error").forEach(el => el.textContent = "");

    if (method === 'new') {
        accountInfo.style.display = 'none';
        newAddressInput.style.display = 'flex';

        provinceSelect.disabled = false;
        districtSelect.disabled = false;
        wardSelect.disabled = false;

        provinceSelect.innerHTML = `<option value="" disabled selected hidden>Province/City</option>`;
        districtSelect.innerHTML = `<option value="" disabled selected hidden>District</option>`;
        wardSelect.innerHTML = `<option value="" disabled selected hidden>Ward/Commune</option>`;

        loadProvinces();
    } else if (method === 'default') {
        accountInfo.style.display = 'block';
        newAddressInput.style.display = 'none';

        provinceSelect.disabled = true;
        districtSelect.disabled = true;
        wardSelect.disabled = true;

        document.getElementById("province").value = defaultProvinceId;
        document.getElementById("district").value = defaultDistrictId;
        document.getElementById("ward").value = defaultWardId;

        loadProvinces(defaultProvinceId, defaultDistrictId, defaultWardId);
    }
}


document.addEventListener("DOMContentLoaded", () => {
    fetch("controller/db_controller/checkout.php?action=init")
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const { Address, ProvinceID, DistrictID, WardID } = data.defaultAddress;

                defaultAddress = Address;
                defaultProvinceId = parseInt(ProvinceID);
                defaultDistrictId = parseInt(DistrictID);
                defaultWardId = parseInt(WardID);

                document.getElementById("default-address").value = Address;

                loadProvinces(defaultProvinceId, defaultDistrictId, defaultWardId, true);
            }
        })
        .catch(err => console.error("Lỗi khi fetch init checkout:", err));
});

function loadProvinces(defaultProvinceId = null, defaultDistrictId = null, defaultWardId = null, isDisabled = false) {
    fetch("controller/db_controller/getProvince.php")
        .then(res => res.json())
        .then(provinces => {
            const provinceSelect = document.getElementById("province");
            let provinceHTML = `<option value="" disabled selected hidden>Province/City</option>`;

            provinces.forEach(province => {
                const selected = (province.id === defaultProvinceId) ? 'selected' : '';
                provinceHTML += `<option value="${province.id}" ${selected}>${province.name}</option>`;
            });

            provinceSelect.innerHTML = provinceHTML;

            if (isDisabled) provinceSelect.disabled = true;

            if (defaultProvinceId && defaultDistrictId && defaultWardId) {
                loadDistricts(defaultProvinceId, defaultDistrictId, defaultWardId, isDisabled);
            }

            if (!isDisabled) {
                provinceSelect.addEventListener("change", () => {
                    const provinceId = provinceSelect.value;
                    if (provinceId) loadDistricts(provinceId);
                });
            }
        })
        .catch(err => console.error("Lỗi khi load Province:", err));
}


function loadDistricts(provinceId, defaultDistrictId = null, defaultWardId = null, isDisabled = false) {
    fetch(`controller/db_controller/getDistrict.php?province_id=${provinceId}`)
        .then(res => res.json())
        .then(districts => {
            const districtSelect = document.getElementById("district");
            let districtHTML = `<option value="" disabled selected hidden>District</option>`;

            districts.forEach(district => {
                const selected = (district.id === defaultDistrictId) ? 'selected' : '';
                districtHTML += `<option value="${district.id}" ${selected}>${district.name}</option>`;
            });

            districtSelect.innerHTML = districtHTML;

            if (isDisabled) districtSelect.disabled = true;

            if (defaultDistrictId) {
                loadWards(defaultDistrictId, defaultWardId, isDisabled);
            }

            if (!isDisabled) {
                districtSelect.addEventListener("change", () => {
                    const districtId = districtSelect.value;
                    if (districtId) loadWards(districtId);
                });
            }
        })
        .catch(err => console.error("Lỗi khi load District:", err));
}

function loadWards(districtId, defaultWardId = null, isDisabled = false) {
    fetch(`controller/db_controller/getWard.php?district_id=${districtId}`)
        .then(res => res.json())
        .then(wards => {
            const wardSelect = document.getElementById("ward");
            let wardHTML = `<option value="" disabled selected hidden>Ward/Commune</option>`;

            wards.forEach(ward => {
                const selected = (ward.id === defaultWardId) ? 'selected' : '';
                wardHTML += `<option value="${ward.id}" ${selected}>${ward.name}</option>`;
            });

            wardSelect.innerHTML = wardHTML;

            if (isDisabled) wardSelect.disabled = true;
        })
        .catch(err => console.error("Lỗi khi load Ward:", err));
}
