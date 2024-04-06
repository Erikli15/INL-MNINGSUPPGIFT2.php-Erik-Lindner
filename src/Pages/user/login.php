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

<body>
    <?php echo $database->getUserDatabas()->getAuth()->isLoggedIn() ?>
    <main>
        <h2>Logga in -
            <?php echo $message ?>
        </h2>
        <<form method="post">
            <label for="name">Användarnamn:</label><br>
            <input type="text" name="username"><br>

            <label for="name">Lösenord:</label><br>
            <input type="password" id="password" name="password"><br>
            </form>
    </main>
</body>

</html>