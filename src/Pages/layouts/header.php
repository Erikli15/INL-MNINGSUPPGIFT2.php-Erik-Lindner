<?php
function headerLayout($database)
{
    $q = $_GET["q"] ?? "";
    ?>

    <head>
        <link rel="stylesheet" href="src/css/header.css">
    </head>

    <header class="p-3">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                        <use xlink:href="#bootstrap" />
                    </svg>
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="/" class="nav-link px-2 text-white">Home</a></li>
                    <li><a href="/products" class="nav-link px-2 text-white">Produkterna</a></li>
                    <li><a href="#" class="nav-link px-2 text-white">Kontakta oss</a></li>
                    <li><a href="#" class="nav-link px-2 text-white">Om oss</a></li>
                </ul>

                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search" method="GET">
                    <input type="search" class="form-control form-control-dark text-bg-dark" placeholder="Search..."
                        aria-label="Search" name="q" value="<?php echo $q ?>">
                </form>

                <div class="text-end">
                    <?php
                    if (!$database->getUserDatabas()->getAuth()->isLoggedIn()) {
                        ?>
                        <button type="button" class="btn btn-info"><a href="/user/login" class="button">Logga
                                in</a></button>
                        <button type="button" class="btn btn-warning"><a href="/user/register"
                                class="button">Registrera</a></button>
                        <?php
                    } else {
                        ?>
                        <?php echo $database->getUserDatabas()->getAuth()->getEmail(); ?>
                        <button type="button" class="btn btn-outline-light me-2"><a href="/user/logout">Logga
                                ut</a></button>
                        <?php
                    }
                    ?>
                </div>
                <button type="button" class="btn btn-secondary"><a href="/admin" class="admin">Admin</a></button>
            </div>
        </div>
    </header>
    <?php
}
?>