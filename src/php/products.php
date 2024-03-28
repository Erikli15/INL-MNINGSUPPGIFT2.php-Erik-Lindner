<?php
require_once ("src/models/Databas.php");
$productsdb = new Databas();

$sortOrder = $_GET['sortOrder'] ?? "";
$sortcol = $_GET["sortcol"] ?? "";
$q = $_GET["q"] ?? "";
?>
<?php

function allCategory($productsdb)
{
    foreach ($productsdb->getAllCategories() as $category) {
        echo "<li>$category->title</li>";
    }
}
;
function allProducts($productsdb, $sortcol, $sortOrder, $q)
{
    foreach ($productsdb->searchProducts($sortcol, $sortOrder, $q, null) as $products) {
        echo "<tr><td>$products->productName</td><td>$products->price</td><td>$products->categoryId</td><td><button><a href='src/php/product.php?id=$products->id'>Mer info</a></button></td></tr>";
    }
}
?>