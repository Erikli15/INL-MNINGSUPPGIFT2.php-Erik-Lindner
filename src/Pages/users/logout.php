<?php
require_once ('vendor/autoload.php');
require_once ('src/models/Databas.php');



$dbContext = new Databas();

$dbContext->getUserDatabas()->getAuth()->logOut();
header('Location: /');
exit;
