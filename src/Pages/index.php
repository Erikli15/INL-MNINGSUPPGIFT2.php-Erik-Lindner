<?php
require_once ("products.php");
require_once ("src/Pages/layouts/header.php");
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
  <title>Erik O`Company</title>
</head>

<body>

  <?php headerLayout($database); ?>

  <main class="content">
    <article class="products">
      <table>
        <thead>
          <tr>
            <td>Namn <a href="?sortcol=productName&sortOrder=asc&q=<?php echo $q ?>"><i>a-z</i></a>
              <a href="?sortcol=productName&sortOrder=desc&q=<?php echo $q ?>"><i>z-a</i></a>
            </td>
            <td>Pris (kr) <a href="?sortcol=price&sortOrder=asc&q=<?php echo $q ?>"><i>a-z</i></a>
              <a href="?sortcol=price&sortOrder=desc&q=<?php echo $q ?>"><i>z-a</i></a>
            </td>
            <td>Kategori <a href="?sortcol=categoryId&sortOrder=asc&q=<?php echo $q ?>"><i>a-z</i></a>
              <a href="?sortcol=categoryId&sortOrder=desc&q=<?php echo $q ?>"><i>z-a</i></a>
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
  <aside>
    <ul>
      <?php
      allCategory($productsdb);
      ?>
    </ul>
  </aside>
  <footer class="footer"></footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>