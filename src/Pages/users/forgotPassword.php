<?php
require_once ("vendor/autoload.php");
require_once ("src/Models/Databas.php");
require_once ("src/Utils/Mailer.php");


$database = new Databas();

$v = new Validator($_POST);

if (isset($_POST["username"])) {
    $v->field("username")->required()->email();

    if ($v->is_valid()) {
        $message = "Du har bytt lösenord";
    } else {
        $message = "Det blev fel";
    }


    try {
        $auth = $database->getUserDatabas()->getAuth();

        $auth->forgotPassword($_POST["username"], function ($selector, $token) {
            $username = "";
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mailer = new Mailer($mail);
            $mail->AllowEmpty = true;
            $mail->addAddress($_POST["username"]);
            $mail->addReplyTo("noreply@ysuperdupershop.com", "No-Reply");
            $subject = "Glömt lösenord";
            $url = "http://localhost:8000/resetPassword.php?selector=" . \urlencode($selector) . "&token=" . \urlencode($token);
            $body = "<i>Hej, kilcka här på <a herf='$url'>$url</a>för att änrdara lösenordet</i>";
            $mailer->sendMail($mailer, $subject, $body, $username, $selector, $token);
            $mail->send();
            if (!$mail->send()) {
                echo "Medelande error" . $mail->ErrorInfo;
            } else {
                echo "Medelande har skickats";
            }
        });
    } catch (\Delight\Auth\InvalidEmailException $e) {
        die("Fel email address");
    } catch (\Delight\Auth\InvalidEmailException $e) {
        die("Email är inte variferad");
    } catch (\Delight\Auth\InvalidEmailException $e) {
        die("För många förfrogningar");
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    exit;
}
?>

<form method="post">
    <input type="email" name="username" placeholder="Email" autocomplete="off">
    <br>
    <input type="submit" name="submit" value="Reset Email">
</form>