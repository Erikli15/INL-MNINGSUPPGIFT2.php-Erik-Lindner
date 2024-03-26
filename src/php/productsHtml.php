<?php
require_once ("products.php");
function getAllProducts($products)
{

    foreach ($products as $product) {
        echo "<tr><td>$product->productName</td><td>$product->category</td><td>$product->price</td></tr>";
    }
}



