<?php 
// require header;
include_once("controller/db_controller/api.php");
include_once("view/header.php");
$productlist = getNewProduct();

if(isset($_GET['pg'])&&($_GET['pg'])!=""){

    switch ($_GET['pg']) {
        case 'home':
            // if ((isset($_GET['catalog']))&&($_GET['catalog']>0)) {
            //     $catalogname = "";
            // }
            // có thể chuyển trang bằng get php
            // include product
            include_once("view/home.php");
            
            break;
        case 'products' :
            include_once("view/product.php");
            break;
        case 'sandals' :
        case 'sneakers' :
        case 'kids' :
        case 'admin':
        case 'login':
            include_once("view/login.php");
            break;
        case 'register':
            include_once("view/register.php");
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