<?php
require_once ("src/models/Databas.php");
require_once ("Utils/UrlModifier.php");
require_once ("src/Pages/layouts/header.php");
$database = new Databas();
$sortOrder = $_GET['sortOrder'] ?? "";
$sortCol = $_GET["sortCol"] ?? "";
$q = $_GET["q"] ?? "";
$categoryId = $_GET["id"] ?? "";

$categoryProducts = $database->getCatagory($categoryId);
$urlModifier = new UrlModifier();

?>


<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="src/scss/login.css">
    <title>Lsta produkter i en katagori</title>
</head>

<?php echo headerLayout($database); ?>

<header>
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
                    href="?sortCol=productName&sortOrder=asc&q=<?php echo $q ?>&id=<?php echo $categoryId ?>"><i>a-z</i></a>
                <a
                    href="?sortCol=productName&sortOrder=desc&q=<?php echo $q ?>&id=<?php echo $categoryId ?>"><i>z-a</i></a>
            </th>
            <th>Pris
                <a href="?sortCol=price&sortOrder=asc&q=<?php echo $q ?>&id=<?php echo $categoryId ?>"><i>a-z</i></a>
                <a href="?sortCol=price&sortOrder=desc&q=<?php echo $q ?>&id=<?php echo $categoryId ?>"><i>z-a</i></a>
            </th>
        </thead>
        <tbody>
            <?php foreach ($database->searchProducts($sortCol, $sortOrder, $q, $categoryId) as $productCategory) {
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