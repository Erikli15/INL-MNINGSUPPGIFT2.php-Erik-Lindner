<?php
require_once ("src/models/Databas.php");
$id = $_GET["id"];
// $productsdb = new Databas();

// $product = $productsdb->getProduct($id);
?>

<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produkten</title>
</head>

<body>
    <h1> Du klickade på produkten med id
        <?php echo $_GET["id"];
        ?>
    </h1>

</body>

</html>