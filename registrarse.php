<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style-form.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Registrarse</title>
</head>
<body class="vh-100 vw-100">
    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <div class="row w-100">
            <div class="col-6 d-flex justify-content-center align-items-center">
                <img src="./img/logo.png" alt="asdasd" class="img-fluid">
            </div>
            <div class="col-6 justify-content-center align-items-center d-flex">
                <div style="width: 80%;">
                    <h3 class="text-center mb-4">Crear cuenta</h3>
                    <form action="insert-registro.php" method="post" id="registrationForm">
                        <div class="mb-2">
                            <label for="usuario" class="form-label">Usuario:</label>
                            <input type="text" id="usuario" name="usuario" class="form-control">
                            <p id="nombreUserError" class="error"></p>
                        </div>
                        <div class="mb-2">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" name="email" class="form-control">
                            <p id="emailError" class="error"></p>
                        </div>
                        <div class="mb-2">
                            <label for="password" class="form-label">Contraseña:</label>
                            <input type="password" id="password" name="password" class="form-control">
                            <p id="contrasenaError" class="error"></p>
                        </div>
                        <div class="mb-2">
                            <label for="repe-password" class="form-label">Repetir contraseña:</label>
                            <input type="password" id="repe-password" name="repe-password" class="form-control">
                            <p id="repetirContrasenaError" class="error"></p>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn-login" name="registrarse" id="registrarse">Registrarse</button>
                        </div>
                        <a href="login.php" class="link-crear-cuenta">Volver</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="./js/login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
