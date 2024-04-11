<?php
require_once ("src/models/Databas.php");
require_once ("src/Pages/layouts/header.php");
$id = $_GET["id"];
$database = new Databas();

$product = $database->getProduct($id);
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
    <link rel="stylesheet" href="src/css/product.css">

    <title>Erik O`Company</title>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?PHP headerLayout($database) ?>
    <main>
        <div class="card mb-3 d-flex" id="product" style="max-width: 540px;">
            <section class="row g-0">
                <span class="col-md-4">
                    <img src="<?php echo $product->imgUrl ?>" class="card-img-top" alt="...">
                </span>
                <span class="col-md-8">
                    <article class="card-body">
                        <h3 class="card-title">
                            <?php echo $product->productName ?>
                        </h3>
                        <p class="card-text">
                            <?php echo $product->description ?>
                        </p>
                    </article>
                </span>
            </section>
        </div>
    </main>
</body>

</html>