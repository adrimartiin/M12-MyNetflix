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
                    <h3 class="text-center mb-4">Iniciar Sesión</h3>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario:</label>
                            <input type="text" id="usuario" name="usuario" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña:</label>
                            <input type="password" id="password" name="password" class="form-control">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn-login" name="registrarse" id="registrarse">Registrarse</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
