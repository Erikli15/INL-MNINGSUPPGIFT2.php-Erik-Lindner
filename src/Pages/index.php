<?php
require_once ("products.php");
$sortOrder = $_GET['sortOrder'] ?? "";
$sortcol = $_GET["sortcol"] ?? "";
$q = $_GET["q"] ?? "";
?>
<!DOCTYPE html>
<html lang="sv">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Erik O`Company</title>
</head>

<body>
  <header>
    <span class="logo"></span>
    <h1>Erik O'Company</h1>
    <nav id="main-menu">
      <ul><a href="/">Hem</a></ul>
      <ul><a href="#">Produkterna</a></ul>
    </nav>
    <form method="GET">
      <input type="text" name="q" value="<?php echo $q ?>" />
      <!-- <input type="hidden" name="sortcol" value="<?php echo $sortcol ?>" /> -->
    </form>
  </header>
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
</body>

</html>