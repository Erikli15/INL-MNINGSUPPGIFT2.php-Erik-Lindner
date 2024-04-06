<?php
require "vendor/autoload.php";
require_once "src/models/Databas.php";

$database = new Databas();

$database->getUserDatabas()->getAuth()->logOut();
header("Location /");