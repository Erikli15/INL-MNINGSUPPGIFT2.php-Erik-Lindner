<?php
require "vendor/autoload.php";
require_once "src/models/Databas.php";

$database = new Databas();

$message = "";
$username = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    try {
        $userId = $database->getUserDatabas()->getAuth()->register($username, $password, $username, function ($selector, $token) {
            echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
            echo '  For emails, consider using the mail(...) function, Symfony Mailer, Swiftmailer, PHPMailer, etc.';
            echo '  For SMS, consider using a third-party service and a compatible SDK';
        });
        header('Location: /user/login');
        exit;
    } catch (Exception $e) {
        $message = "Error";
    }

}
?>

<html>

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
    <h2>Ny kund -
        <?php echo $message ?>
    </h2>
    <form method="post" class="mb-3">
        <label for="name" class="form-label">Användarnamn:</label><br>
        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com"
            name="username"><br>

        <label for="name" class="form-label">Lösenord:</label><br>
        <input type="password" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock"
            name="password"><br>

        <label for="name" class="form-label">Lösenord again:</label><br>
        <input type="password" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock"
            name="passwordAgain"><br>
        <input type="submit" placeholder="Spara">
    </form>
</body>

</html>