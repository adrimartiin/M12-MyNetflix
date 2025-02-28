<!-- sesiones -->
<?php
    require_once '../bd/conexion.php';
    session_start();
    if(!isset($_SESSION['nombre_usuario'])){
        header('Location: ../procesos/logout.php');
        exit;
    } else if($_SESSION['rol_id'] != 1){
        header('Location: ../procesos/logout.php');
        exit;
    }
?>
<!DOCTYPE html> 
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Index</title>
    <link rel="stylesheet" href="../css/indexAdmin.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


</head>
<body>
<nav class="navbar navbar-expand-lg bg-dark nav-fixed">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#"><img src="../img/logo.png" alt="Logo"></a>
            <button class="navbar-toggler" type="button" style="background-color: red;" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <?php
                if (isset($_SESSION['nombre_usuario'])) {
                    echo '<div class="d-flex div-btn">
                            <a class="btn-login text-decoration-none" href="../procesos/logout.php">Cerrar sesión</a>
                        </div>';
                } else {
                    echo '<div class="d-flex div-btn">
                        <a class="btn-login text-decoration-none" href="../login.php">Iniciar sesión</a>
                    </div>';
                }
            ?>
            </div>
        </div>
    </nav>
    <div class="container-menu">
        <section>
            <a class="image-container" href="./gest_users.php">
                <img src="../img/crud_admin_usrs.png" alt="" id="comedor">
                <div class="text-overlay">Usuarios</div>
            </a>
            <a class="image-container" href="./gest_films.php">
                <img src="../img/crud_admin_films.png" alt="" id="privada">
                <div class="text-overlay">Películas</div>
            </a>
        </section>
    </div>
</body>
<script src="../js/sweetalert.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>


