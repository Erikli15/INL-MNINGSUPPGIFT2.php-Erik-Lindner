<?php
require_once ("src/models/Databas.php");
require_once ("Utils/UrlModifier.php");
require_once ("src/Pages/layouts/header.php");
require_once ("src/Pages/layouts/footer.php");


$sortOrder = $_GET['sortOrder'] ?? "";
$sortOrder = $sortOrder == 'desc' ? 'desc' : 'asc';
$sortCol = $_GET["sortCol"] ?? "";
$q = $_GET["q"] ?? "";
$categoryId = $_GET["id"] ?? "";
$pageNo = intval($_GET['pageNo'] ?? "1");
$pageSize = intval($_GET['pageSize'] ?? "20");

$database = new Databas();
$urlModifier = new UrlModifier();


$categoryProducts = $database->getCatagory($categoryId);



function oneOf($sortCol, $arrayOfValid, $default)
{
    foreach ($arrayOfValid as $a) {
        if (strcasecmp($a, $sortCol) == 0) {
            return $a;
        }
    }
    return $default;
}
$sortCol = oneOf($sortCol, ["productName", "price", "id"], "id");
?>


<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/footers/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <script src="../assets/js/color-modes.js"></script>
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Erik O`Company</title>
</head>

<?php echo headerLayout($database); ?>

<body>

    <header>
        <form method="GET">
            <input type="text" name="q" value="<?php echo $q ?>" />
            <input type="hidden" name="id" value="<?php echo $categoryId ?>" />
        </form>
    </header>

    <table class="table table-dark table-striped">
        <h2>
            <?php echo $categoryProducts->title ?>
        </h2>

        <thead>
            <th></th>
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
            <?php $result = $database->searchProducts($sortCol, $sortOrder, $q, $categoryId, $pageNo, $pageSize);
            foreach ($result["data"] as $productCategory) {
                ?>
                <tr>
                    <td>
                        <img src="<?php echo $productCategory->imgUrl ?>">
                    </td>
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

    <footer> <?php footerLayout(); ?> </footer>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>