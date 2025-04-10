<?php
// include_once("./controller/db_controller/api.php");
// include_once("header.php");

$toastMessage = ""; // Biến lưu thông báo toast

if (isset($_POST['btnlogin'])) {
    $user = trim($_POST['user']);
    $password = $_POST['password'];

    // Gọi hàm getOne để lấy thông tin người dùng
    $sql = "SELECT UserID, PasswordHash FROM user WHERE Username = '$user'";
    $userData = getOne($sql);

    if ($userData) {
        // Kiểm tra mật khẩu
        if (password_verify($password, $userData['PasswordHash'])) {
            $_SESSION['user'] = [
                'userID' => $userData['UserID'], // Lưu userID vào session
                'Username' => $user
            ];       
            $userID = $_SESSION['user']['userID'];     
            $toastMessage = json_encode([
                "title" => "Success",
                "message" => "Login successful!",
                "type" => "success",
                "redirect" => "index.php"
            ]);
        } else {
            $toastMessage = json_encode([
                "title" => "Error",
                "message" => "Wrong password or username!",
                "type" => "error"
            ]);
        }
    } else {
        $toastMessage = json_encode([
            "title" => "Error",
            "message" => "Account does not exist!",
            "type" => "error"
        ]);
    }
}
?>

<div class="container toast" id="toast"></div>
<div class="main-login">
    <div class="main-login-header">
        <h2>LOGIN</h2>
    </div>
    <div class="main-login-body">
        <form class="login-form" id="login-form" method="post">
            <input class="form-input-bar" type="text" id="username-login" name="user" placeholder="Username*" required>
            <p class="form-msg-error"></p>

            <input class="form-input-bar" type="password" id="password-login" name="password" placeholder="Password*" required>
            <p class="form-msg-error"></p>

            <button type="submit" name="btnlogin">LOGIN</button>
        </form>
    </div>
    <div class="main-login-footer">
        <p>DON'T HAVE AN ACCOUNT? <span><a href="index.php?pg=register">SIGN UP</a></span></p>
    </div>
</div>

<script>
    // Hàm toastMsg nếu chưa có, nhớ khai báo trước nha

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

    function updateCartSummary(totalQty, totalPrice) {
        const DELIVERY_FEE = 30000;
        document.querySelectorAll(".display-cart-total-amount").forEach(el => el.innerText = totalQty);
        document.querySelectorAll(".display-totalprice").forEach(el => el.innerText = vnd(totalPrice));
        document.querySelectorAll(".display-totalorder").forEach(el => el.innerText = vnd(totalPrice + DELIVERY_FEE));
    }

    window.onload = function () {
    let toastData = <?php echo $toastMessage ?: "null"; ?>;
    if (toastData) {
        toastMsg({
            title: toastData.title,
            message: toastData.message,
            type: toastData.type,
            duration: 3000
        });

        if (toastData.redirect) {
            setTimeout(() => {
                window.location.href = toastData.redirect + "?from=login";
            }, 1000);
        }
    }
};

</script>
