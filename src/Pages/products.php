<?php
require_once ("src/models/Databas.php");
require_once ("Utils/UrlModifier.php");

$productsdb = new Databas();
$urlModifier = new UrlModifier();

$sortOrder = $_GET['sortOrder'] ?? "";
$sortCol = $_GET["sortCol"] ?? "";
$q = $_GET["q"] ?? "";
?>
<?php

function allCategory($productsdb)
{
    foreach ($productsdb->getAllCategories() as $category) {
        echo "<li><a href='/productCatagoryList?id=$category->id'>$category->title</a></li>";
    }
}
;
function allProducts($productsdb, $sortCol, $sortOrder, $q)
{
    foreach ($productsdb->searchProducts($sortCol, $sortOrder, $q, null) as $products) {
        echo "<tr><td>$products->productName</td><td>$products->price</td><td>$products->categoryId</td><td><button><a href='/product?id=$products->id'>Mer info</a></button></td></tr>";
    }
}
?>