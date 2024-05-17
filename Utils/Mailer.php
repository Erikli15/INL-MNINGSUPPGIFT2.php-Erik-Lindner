<?php
require_once ("vendor/autoload.php");

class Mailer
{

    private $mailer;

    public function __construct($mailer)
    {
        $this->mailer = $mailer;
        $this->mailer->isSMTP();
        $this->mailer->Host = $_ENV["Host"];
        $this->mailer->SMTPAuth = $_ENV["SMTPAuth"];
        $this->mailer->Username = $_ENV["Username"];
        $this->mailer->Password = $_ENV["Password"];
        $this->mailer->SMTPSecure = $_ENV["SMTPSecure"];
        $this->mailer->Port = $_ENV["Port"];
    }
    public function sendMail($mailer, $subjekt, $body, $username, $selector, $token)
    {
        $this->mailer->From = "erikocompany@workmail.com";
        $this->mailer->FromName = "Hej";
        $this->mailer->addAddress($_POST["username"]);
        $this->mailer->isHTML(true);
        $this->mailer->addReplyTo("noreply@yerikocompany.com", "No-Reply");
        $this->mailer->Subject = $subjekt;
        $this->mailer->Body = $body;
    }
}