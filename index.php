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

// $router->addRoute('/newcustomer', function () {
//     require (__DIR__ . '/src/Pages/newcustomer.php');
// });


$router->addRoute('/productCatagoryList', function () {
    require __DIR__ . '/src/Pages/productCatagoryList.php';
});

// $router->addRoute('/input', function () {
//     require __DIR__ . '/src/Pages/form.php';
// });

$router->dispatch();
?>