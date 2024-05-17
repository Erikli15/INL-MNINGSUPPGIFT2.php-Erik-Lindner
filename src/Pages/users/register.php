<?php
require_once ("vendor/autoload.php");
require_once ("src/models/Databas.php");
require_once ("src/models/userDitalesDatabas.php");
require_once ("Utils/Validator.php");
require_once ("Utils/Mailer.php");

$database = new Databas();
$user = new userDitalesDatabas();

$message = "";
$username = "";

$v = new Validator($_POST);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? "";
    $password = $_POST['password'] ?? "";

    $user->firstName = $_POST["firstName"];
    $user->lastName = $_POST["lastName"];
    $user->streetAddress = $_POST["streetAddress"];
    $user->zipCode = $_POST["zipCode"];
    $user->city = $_POST["city"];


    $v->field('username')->required()->email();
    $v->field('password')->required()->min_len(8)->max_len(20)->must_contain('!@#$&')->must_contain('a-z')->must_contain('A-Z')->must_contain('0-9');

    if ($v->is_valid()) {
        $message = "Du är regestrerad";
    } else {
        $message = "Något gick snett";
    }

    try {
        $userId = $database->getUserDatabas()->getAuth()->register($username, $password, $username, function ($selector, $token) {
            $username = "";
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mailer = new Mailer($mail);
            $mail->AllowEmpty = true;
            $mail->addAddress($_POST['username']);
            $mail->addReplyTo("noreply@ysuperdupershop.com", "No-Reply");
            $subject = "Registrering";
            $url = 'http://localhost:8000/?selector=' . \urlencode($selector) . '&token=' . \urlencode($token);
            $body = "<h2>Hej, klicka på <a href='$url'>$url</a></h2> för att verifiera ditt konto hoss Erik O`Company";
            $mailer->sendMail($mailer, $subject, $body, $username, $selector, $token);
            $mail->send();
            if (!$mail->send()) {
                echo "Medelande error" . $mail->ErrorInfo;
            } else {
                echo "Medelande har skickats";
            }
        });
        $database->addDetales($userId, $user->firstName, $user->lastName, $user->streetAddress, $user->zipCode, $user->city);
        header('Location: /user/verifyuser');
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
            name="username"> <span><?php echo $v->get_error_message('password') ?></span>
        <br>

        <label for="name" class="form-label">Lösenord:</label><br>
        <input type="password" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock"
            name="password"> <span><?php echo $v->get_error_message('password') ?></span>
        <br>

        <label for="name" class="form-label">Lösenord igen:</label><br>
        <input type="password" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock"
            name="passwordAgain"> <span><?php echo $v->get_error_message('password') ?></span>
        <br>

        <label for="name" class="form-label">Förnamn:</label><br>
        <input type="name" id="exampleFormControlInput1" class="form-control" aria-describedby="passwordHelpBlock"
            name="firstName"> <span><?php echo $v->get_error_message('firstName') ?></span>
        <br>

        <label for="name" class="form-label">Efternamn:</label><br>
        <input type="name" id="exampleFormControlInput1" class="form-control" aria-describedby="passwordHelpBlock"
            name="lastName"> <span><?php echo $v->get_error_message('lastName') ?></span>
        <br>

        <label for="name" class="form-label">Gata:</label><br>
        <input type="street" id="exampleFormControlInput1" class="form-control" aria-describedby="passwordHelpBlock"
            name="streetAddress"> <span><?php echo $v->get_error_message('streetAddress') ?></span>
        <br>

        <label for="name" class="form-label">Post nummer:</label><br>
        <input type="postal" id="exampleFormControlInput1" class="form-control" aria-describedby="passwordHelpBlock"
            name="zipCode"> <span><?php echo $v->get_error_message('zipCode') ?></span>
        <br>

        <label for="name" class="form-label">Stad:</label><br>
        <input type="city" id="exampleFormControlInput1" class="form-control" aria-describedby="passwordHelpBlock"
            name="city"> <span><?php echo $v->get_error_message('city') ?></span>
        <br>

        <input type="submit" placeholder="Spara"><br>
        <span><?php echo $v->get_error_message('') ?></span>
    </form>
</body>

</html>