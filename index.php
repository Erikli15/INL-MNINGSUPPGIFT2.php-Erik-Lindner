<?php
require_once ("src/php/productsHtml.php");
?>
<!DOCTYPE html>
<html lang="sv">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Erik O`Company</title>
</head>

<body>
  <?php
  getAllProducts($products); ?>
  <header>
    <span class="logo"></span>
    <h1>Erik O'Company</h1>
    <nav id="main-menu">
      <ul></ul>
    </nav>
    <span><input type="text" name="sok" id="sok" placeholder="Sök..." /></span>
  </header>
  <main class="content">
    <article class="products">
      <thead>
        <tr>
          <td>Namn</td>
          <td>Kategori</td>
          <td>Pris (kr)</td>
        </tr>
      </thead>
      <tbody id="productList">
        <?php
        getAllProducts($products); ?>
      </tbody>
    </article>
  </main>
  <aside></aside>
  <footer class="footer"></footer>
</body>

</html>