<?php
require_once ("Utils/Validator.php");
require_once ("src/models/Databas.php");

$database = new Databas();

$product = new Product();
$v = new Validator($_POST);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $product->productName = $_POST["productName"];
    $product->categoryId = $_POST["categoryId"];
    $product->price = $_POST["price"];
    $product->description = $_POST["description"];
    $product->imgUrl = $_POST["imgUrl"];

    $v->field("productName")->required()->alpha([" "])->min_len(1)->max_len(200);
    $v->field("categoryId")->required()->alpha([" "])->min_len(1)->max_len(200);
    $v->field("price")->required()->numeric()->min_val(1)->max_val(10000);
    $v->field("description")->required()->alpha([" "])->min_len(1)->max_len(1000);

    if ($v->is_valid()) {
        $database->addProduct($product->productName, $product->price, $product->categoryId, $product->description, $product->imgUrl);
        header("Location: /");
        exit;
    }

}
?>


<!DOCTYPE html>
<html lang="se">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">

    <title>Lägg till</title>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <form method="post" class="p-3 m-0 border-0 bd-example m-0 border-0">
        <div class="mb-3">
            <label for="name" class="form-label">Produktnamn</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Produktnamn"
                name="productName" value="<?php echo $product->productName ?>">
            <span class="alart"><?php echo $v->get_error_message("productName") ?></span>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Vilken katogori</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="katogorinamn"
                name="categoryId" value="<?php echo $product->categoryId ?>">
            <span class="alart"><?php echo $v->get_error_message("categoryId") ?></span>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Pris</label>
            <input type="number" class="form-control" id="exampleFormControlInput1" placeholder="Pris" name="price"
                value="<?php echo $product->price ?>">
            <span class="alart"><?php echo $v->get_error_message("price") ?></span>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Beskrivnng</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"
                placeholder="Beskrivnng" value="<?php $product->description ?>"></textarea>
            <span class="alart"><?php echo $v->get_error_message("description") ?></span>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Produktbild</label>
            <input class="form-control" type="file" id="formFile" name="imgUrl" value="<?php $product->imgUrl ?>">
            <span class="alart"><?php echo $v->get_error_message("imgUrl") ?></span>
        </div>
        <input type="submit" value="Lägg till" class="btn btn-primary">
    </form>
</body>

</html>
<!-- <span class="alart"><?php echo $v->get_error_message("prodcktName") ?></span> -->