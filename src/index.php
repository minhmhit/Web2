<?php
session_start();
require_once("controller/db_controller/db_connect.php");
include_once("controller/controller.php");
?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let urlParams = new URLSearchParams(window.location.search);
    let productId = urlParams.get("id");

    if (urlParams.get("pg") === "productdetail" && productId) {
        openProductDetail(productId);
    }
});
</script>
