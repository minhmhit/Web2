<?php
// header('Content-Type: application/json');
require_once 'db_connect.php';

/*************************** PRODUCT START ***************************/

function getNewProduct() {
    $sql = "SELECT * FROM products  ORDER BY ProductID DESC;";
    return getAll($sql);
}

function getProductDetail($idProduct) {
    $sql = "SELECT * FROM products WHERE ProductID =".$idProduct;
    return getOne($sql);
}

function getIDCatalog ($idCatalog) {
    $sql = "SELECT CategoryID FROM categories WHERE CategoryID =".$idCatalog;
    $getone = getOne ($sql);
    extract($getone);
    return $CategoryID;
}




/*************************** PRODUCT END ***************************/

