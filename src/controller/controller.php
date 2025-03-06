<?php 

// require header
include_once("view/header.php");

if(isset($_GET['pg'])&&($_GET['pg'])!=""){

    switch ($_GET['pg']) {
        case 'product':
            // if ((isset($_GET['catalog']))&&($_GET['catalog']>0)) {
            //     $catalogname = "";
            // }
            // có thể chuyển trang bằng get php
            // include product
            include_once("view/home.php");
            break;

            
        
        default:
            //include home
            include_once("view/home.php");

            break;
    }
}else{
    include_once("view/home.php");


}


// include footer
include_once("view/footer.php");


?>