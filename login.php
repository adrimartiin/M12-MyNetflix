<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style-form.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Login</title>
</head>
<body class="vh-100 vw-100">
    <div class="container-fluid d-flex justify-content-center align-items-center vh-100 login-container">
        <div class="row w-100">
            <!-- Logo -->
            <div class="col-12 col-md-6 d-flex justify-content-center align-items-center login-logo">
                <img src="./img/logo.png" alt="Logo" class="img-fluid">
            </div>
            <!-- Formulario de login -->
            <div class="col-12 col-md-6 justify-content-center align-items-center d-flex">
                <div style="width: 80%;">
                    <h3 class="text-center mb-4">Iniciar Sesión</h3>
                    <form action="./procesos/login_verificacion.php" method="post" id="formulario-login">
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario:</label>
                            <input type="text" id="usuario-login" name="usuario-login" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña:</label>
                            <input type="password" id="password-login" name="password-login" class="form-control">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn-login" name="btn_login" id="login">Login</button>
                        </div>
                        <p id="error-form" class="error"></p>
                        <!-- Enlace para crear cuenta -->
                        <a href="registrarse.php" class="link-crear-cuenta">Crear cuenta</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="./js/login.js"></script>
    <script src="js/sweetalert.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="./js/responsive.js"></script>

</body>
</html>
