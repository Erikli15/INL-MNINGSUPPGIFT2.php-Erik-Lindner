<?php
require_once ("src/Pages/layouts/header.php");
require_once ("src/Pages/layouts/aside.php");
require_once ("src/models/Databas.php");
$database = new Databas();
$sortOrder = $_GET['sortOrder'] ?? "";
$sortCol = $_GET["sortCol"] ?? "";
$q = $_GET["q"] ?? "";
$pageNo = $_GET['pageNo'] ?? "1";
$pageSize = $_GET['pageSize'] ?? "20";

?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>Erik O`Company</title>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php headerLayout($database); ?>
    <div class="d-flex">
        <main class="p-2 w-100">
            <article class=" products">
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <td></td>
                            <td>Namn <a href="?sortCol=productName&sortOrder=asc&q=<?php echo $q ?>"><i
                                        class="bi bi-arrow-up"></i></a>
                                <a href="?sortCol=productName&sortOrder=desc&q=<?php echo $q ?>"><i
                                        class="bi bi-arrow-down"></i></a>
                            </td>
                            <td>Pris (kr) <a href="?sortCol=price&sortOrder=asc&q=<?php echo $q ?>"><i
                                        class="bi bi-arrow-up"></i></a>
                                <a href="?sortCol=price&sortOrder=desc&q=<?php echo $q ?>"><i
                                        class="bi bi-arrow-down"></i></a>
                            </td>
                            <td>Kategori <a href="?sortCol=categoryId&sortOrder=asc&q=<?php echo $q ?>"><i
                                        class="bi bi-arrow-up"></i></a>
                                <a href="?sortCol=categoryId&sortOrder=desc&q=<?php echo $q ?>"><i
                                        class="bi bi-arrow-down"></i></a>
                            </td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody id="productList">
                        <?php
                        $result = $database->searchProducts($sortCol, $sortOrder, $q, null, $pageNo, $pageSize);
                        foreach ($result["data"] as $product) {
                            ; ?>
                            <tr>
                                <td>
                                    <img src="<?php echo $product->imgUrl ?>">
                                </td>
                                <td>
                                    <?php echo $product->productName ?>
                                </td>
                                <td>
                                    <?php echo $product->price ?>
                                </td>
                                <td>
                                    <?php echo $product->categoryId ?>
                                </td>
                                <td><button><a href="/product?id=<?php echo $product->id ?>">Mer info</a></button></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </article>
        </main>
        <aside class="p-2 flex-shrink-1">
            <ul>
                <?php
                asideLayout($database);
                ?>
            </ul>
        </aside>
    </div>
    <footer class="footer"></footer>

    <?php
    for ($i = 1; $i <= $result["num_pages"]; $i++) {
        if ($pageNo == $i) {
            echo "$i&nbsp;";
        } else {
            echo "<a class='listbutton' href='?sortCol=$sortCol&sortOrder=$sortOrder&q=$q&pageNo=$i'>$i</a>&nbsp;";
        }
    }


    ?>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>