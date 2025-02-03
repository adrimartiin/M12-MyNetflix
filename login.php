<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style-form.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login</title>
</head>
<body class="vh-100 vw-100">
    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <div class="row w-100">
            <div class="col-6 d-flex justify-content-center align-items-center">
                <img src="./img/logo.png" alt="Logo" class="img-fluid">
            </div>
            <div class="col-6 justify-content-center align-items-center d-flex">
                <div style="width: 80%;">
                    <h3 class="text-center mb-4">Iniciar Sesión</h3>
                    <form action="" method="post" id="formulario-login">
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario:</label>
                            <input type="text" id="usuario-login" name="usuario-login" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña:</label>
                            <input type="password" id="password-login" name="password-login" class="form-control">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn-login" name="login" id="login">Login</button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
</html>
