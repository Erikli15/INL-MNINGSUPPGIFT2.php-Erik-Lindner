<?php
require_once ("src/models/Databas.php");
require_once ("Utils/UrlModifier.php");
require_once ("src/Pages/layouts/header.php");


$database = new Databas();

if ($database->getUserDatabas()->getAuth()->hasRole(\Delight\Auth\Role::ADMIN) == false) {
    header("Location: /user/login");
    exit;
}
?>


<body>
    <?php headerLayout($database); ?>

</body>