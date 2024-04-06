<?php
require "vendor/autoload.php";
require_once "src/models/Databas.php";

$database = new Databas();

$message = "";
$username = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    try {
        $userId = $database->getUserDatabas()->getAuth()->register(
            $username,
            $password,
            $username,
            function ($selector, $token) {
                echo "Send" . $selector . "and" . $token . "till användarens mail";
                echo "använda mail funktioner så som, Symfony Mailer, Swiftmailer, PHPMailer, etc. ";
                echo "sms använd tredjepart system med en kompatibel SDK.";
            }
        );
        header("Location: /user/login");
        exit;
    } catch (Exception $e) {
        $message = "Error";
    }
}
?>

<html>

<body>
    <h2>Ny kund -
        <?php echo $message ?>
    </h2>
    <form method="post">
        <label for="name">Användarnamn:</label><br>
        <input type="text" name="username"><br>

        <label for="name">Lösenord:</label><br>
        <input type="password" id="password" name="password"><br>

        <label for="name">Lösenord again:</label><br>
        <input type="password" id="password" name="password"><br>
        <input type="submit" placeholder="Spara">
    </form>
</body>

</html>