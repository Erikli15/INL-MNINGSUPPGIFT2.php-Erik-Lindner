<?php
require_once ("vendor/autoload.php");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


// globala initieringar !
require_once (dirname(__FILE__) . "/Utils/Router.php");

$router = new Router();
$router->addRoute('/', function () {
    require __DIR__ . '/src/Pages/index.php';
});

$router->addRoute('/product', function () {
    require __DIR__ . '/src/Pages/product.php';
});

$router->addRoute('/newproduct', function () {
    require (__DIR__ . '/src/Pages/newproduct.php');
});


$router->addRoute('/productCatagoryList', function () {
    require __DIR__ . '/src/Pages/productCatagoryList.php';
});

$router->addRoute('/user/login', function () {
    require __DIR__ . '/src/Pages/user/login.php';
});

$router->addRoute('/user/logout', function () {
    require __DIR__ . '/src/Pages/user/logout.php';
});

$router->addRoute('/user/register', function () {
    require __DIR__ . '/src/Pages/user/register.php';
});

$router->dispatch();
?>