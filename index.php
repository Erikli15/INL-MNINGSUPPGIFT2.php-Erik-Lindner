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
$router->addRoute('/products', function () {
    require __DIR__ . '/src/Pages/products.php';
});

$router->addRoute('/addproduct', function () {
    require (__DIR__ . '/src/Pages/addProduct.php');
});

$router->addRoute('/productCatagoryList', function () {
    require __DIR__ . '/src/Pages/productCatagoryList.php';
});

$router->addRoute('/changeproduct', function () {
    require __DIR__ . '/src/Pages/changeProduct.php';
});

$router->addRoute('/admin', function () {
    require __DIR__ . '/src/Pages/admin.php';
});

$router->addRoute('/user/login', function () {
    require __DIR__ . '/src/Pages/users/login.php';
});

$router->addRoute('/user/logout', function () {
    require __DIR__ . '/src/Pages/users/logout.php';
});

$router->addRoute('/user/register', function () {
    require __DIR__ . '/src/Pages/users/register.php';
});

$router->addRoute('/user/verifyuser', function () {
    require __DIR__ . '/src/Pages/users/verifyuser.php';
});

$router->dispatch();
?>