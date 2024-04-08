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

    <title>Produkten</title>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<?PHP headerLayout($database) ?>

<body>
    <section class="card" style="width: 20rem;">
        <article class="card-body">
            <h3 class="card-title">
                <?php echo $product->productName ?>
            </h3>
            <p class="card-text">
                <?php echo $product->description ?>
            </p>
        </article>
    </section>
</body>

</html>