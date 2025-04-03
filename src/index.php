<?php
require_once("controller/db_controller/db_connect.php");
include_once("controller/controller.php");

    if (isset($_POST['user'])) {
        $name = $_POST['user'];
    }
    else 
        $name ="";
?>

<!-- <script>
document.addEventListener("DOMContentLoaded", function() {
    let urlParams = new URLSearchParams(window.location.search);
    let productId = urlParams.get("id");

    if (urlParams.get("pg") === "productdetail" && productId) {
        openProductDetail(productId);
    }
});
</script> -->
