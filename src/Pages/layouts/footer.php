<?php
function footerLayout()
{
    ?>
    <html>

    <head>
        <script src="../assets/js/color-modes.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/footers/">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
        <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <body>
        <div class="container">
            <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
                <div class="col-md-4 d-flex align-items-center">
                    <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
                        <svg class="bi" width="30" height="24">
                            <use xlink:href="#bootstrap" />
                        </svg>
                    </a>
                    <span class="mb-3 mb-md-0 text-body-secondary">&copy; 2024 Company, Inc</span>
                </div>

                <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                    <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24">
                                <use xlink:href="#twitter" />
                            </svg></a></li>
                    <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24">
                                <use xlink:href="#instagram" />
                            </svg></a></li>
                    <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24">
                                <use xlink:href="#facebook" />
                            </svg></a></li>
                </ul>
            </footer>
        </div>
        <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
    <?php
}
?>