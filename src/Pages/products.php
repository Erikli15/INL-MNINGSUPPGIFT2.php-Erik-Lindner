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
function allProducts($productsdb, $sortCol, $sortOrder, $q)
{
    foreach ($productsdb->searchProducts($sortCol, $sortOrder, $q, null) as $products) {
        echo "<tr><td><img src=$products->imgUrl></td><td>$products->productName</td><td>$products->price</td><td>$products->categoryId</td><td><button><a href='/product?id=$products->id'>Mer info</a></button></td></tr>";
    }
}
?>