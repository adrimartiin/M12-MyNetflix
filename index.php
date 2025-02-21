<?php
  require_once './bd/conexion.php';
  session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/indexUser.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Gestión Usuarios</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#"><img src="./img/logo.png" alt="Logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <?php
                if (isset($_SESSION['nombre_usuario'])) {
                    echo '<div class="d-flex">
                            <a class="btn-login text-decoration-none" href="./procesos/logout.php">Cerrar sesión</a>
                        </div>';
                } else {
                    echo '<div class="d-flex">
                        <a class="btn-login text-decoration-none" href="./login.php">Iniciar sesión</a>
                    </div>';
                }
            ?>
            </div>
        </div>
    </nav>
    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators" id="carousel-indicators"></div>
        <div class="carousel-inner" id="carousel-inner"></div>

        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- Contenedor principal -->
    <div class="container mt-4">
        <div class="row">
            <!-- Primer div -->
            <div class="col-12 p-3 mb-5 bg-light border rounded peliculas-div">
                <h5>Div 1</h5>
                <p>Contenido del primer div.</p>
            </div>
        </div>

        <div class="row">
            <!-- Primer div -->
            <div class="col-12 p-3 mb-5 bg-light border rounded peliculas-div">
                <h5>Div 1</h5>
                <p>Contenido del primer div.</p>
            </div>
        </div>
        <div class="row">
            <!-- Primer div -->
            <div class="col-12 p-3 mb-5 bg-light border rounded peliculas-div">
                <h5>Div 1</h5>
                <p>Contenido del primer div.</p>
            </div>
        </div>

    </div>
    <script src="js/carrusel.js"></script>
    <script src="js/sweetalert.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
