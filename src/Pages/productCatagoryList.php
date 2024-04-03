<?php
require_once ("src/models/Databas.php");
require_once ("Utils/UrlModifier.php");
$productsdb = new Databas();
$sortOrder = $_GET['sortOrder'] ?? "";
$sortCol = $_GET["sortCol"] ?? "";
$q = $_GET["q"] ?? "";
$categoryId = $_GET["id"] ?? "";

$categoryProducts = $productsdb->getCatagory($categoryId);
$urlModifier = new UrlModifier();

?>


<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lsta produkter i en katagori</title>
</head>
<header>
    <span class="logo"></span>
    <h1>Erik O'Company</h1>
    <nav id="main-menu">
        <ul><a href="/">Hem</a></ul>
        <ul><a href="#">Produkterna</a></ul>
    </nav>
    <form method="GET">
        <input type="text" name="q" value="<?php echo $q ?>" />
        <input type="hidden" name="id" value="<?php echo $categoryId ?>" />
    </form>
</header>

<body>
    <table>
        <h2>
            <?php echo $categoryProducts->title ?>
        </h2>

        <thead>
            <th>Namn
                <a
                    href="?sortcol=productName&sortOrder=asc&q=<?php echo $q ?>&id=<?php echo $categoryId ?>"><i>a-z</i></a>
                <a
                    href="?sortcol=productName&sortOrder=desc&q=<?php echo $q ?>&id=<?php echo $categoryId ?>"><i>z-a</i></a>
            </th>
            <th>Pris
                <a href="?sortcol=price&sortOrder=asc&q=<?php echo $q ?>&id=<?php echo $categoryId ?>"><i>a-z</i></a>
                <a href="?sortcol=price&sortOrder=desc&q=<?php echo $q ?>&id=<?php echo $categoryId ?>"><i>z-a</i></a>
            </th>
        </thead>
        <tbody>
            <?php foreach ($productsdb->searchProducts($sortCol, $sortOrder, $q, $categoryId) as $productCategory) {
                ?>
                <tr>
                    <td>
                        <?php echo $productCategory->productName ?>
                    </td>
                    <td>
                        <?php echo $productCategory->price ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</body>

</html>