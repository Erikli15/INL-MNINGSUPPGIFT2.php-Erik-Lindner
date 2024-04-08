<?php
require_once ("products.php");
require_once ("src/Pages/layouts/header.php");
require_once ("src/Pages/layouts/aside.php");
require_once ("src/models/Databas.php");
$database = new Databas();
$sortOrder = $_GET['sortOrder'] ?? "";
$sortcol = $_GET["sortcol"] ?? "";
$q = $_GET["q"] ?? "";

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
        <table>
          <thead>
            <tr>
              <td>Namn <a href="?sortcol=productName&sortOrder=asc&q=<?php echo $q ?>"><i
                    class="bi bi-arrow-up"></i></a>
                <a href="?sortcol=productName&sortOrder=desc&q=<?php echo $q ?>"><i class="bi bi-arrow-down"></i></a>
              </td>
              <td>Pris (kr) <a href="?sortcol=price&sortOrder=asc&q=<?php echo $q ?>"><i class="bi bi-arrow-up"></i></a>
                <a href="?sortcol=price&sortOrder=desc&q=<?php echo $q ?>"><i class="bi bi-arrow-down"></i></a>
              </td>
              <td>Kategori <a href="?sortcol=categoryId&sortOrder=asc&q=<?php echo $q ?>"><i
                    class="bi bi-arrow-up"></i></a>
                <a href="?sortcol=categoryId&sortOrder=desc&q=<?php echo $q ?>"><i class="bi bi-arrow-down"></i></a>
              </td>
            </tr>
          </thead>
          <tbody id="productList">
            <?php
            allProducts($productsdb, $sortcol, $sortOrder, $q);
            ?>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>