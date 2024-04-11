<?php

require "vendor/autoload.php";
require_once "src/models/Databas.php";

$database = new Databas();
$message = "";
$username = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $database->getUserDatabas()->getAuth()->login($username, $password);
        header("Location: /");
        exit;
    } catch (Exception $e) {
        $message = "Du kan inte logga in";
    }
}
?>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="src/css/login.css">

</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <?php echo $database->getUserDatabas()->getAuth()->isLoggedIn() ?>
    <main class="form-signin w-100 m-auto">
        <h2>Logga in -
            <?php echo $message ?>
        </h2>
        <form method="post">
            <div class="form-floating">
                <input type="text" name="username" class="form-control" id="floatingInput"
                    placeholder="name@example.com">
                <label for="floatingInput">Användarnamn:</label>
            </div>
            <div class="form-floating">
                <input type="password" id="password" name="password" class="form-control" id="floatingInput"
                    placeholder="Password">
                <label for="floatingPassword">Lösenord:</label>
            </div>
            <input class="btn btn-primary w-100 py-2" type="submit" value="Logga in">
        </form>
    </main>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>