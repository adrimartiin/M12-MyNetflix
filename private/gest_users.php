<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Gestión Usuarios</title>
    <style>
        body {
            height: 100vh;
            margin: 0;
            background-color: #151414 !important;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #151414 !important;
        }

        .navbar-brand img {
            height: 50px;
        }

        .search-input {
            border: 1px solid #B5ADAD;
            border-radius: 5px;
            padding: 5px 10px;
        }

        .search-btn {
            border: 1px solid #B5ADAD;
            background: none;
            color: #B5ADAD;
        }

        .search-btn:hover {
            border: 1px solid #B5ADAD;
            background-color: #F8F8F8;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        .table_head {
            background-color: #F1F1F1;
        }

        .table_body {
            background-color: #DB202C;
        }

        .form-check-input:checked {
            background-color: #000 !important;
            border-color: #000 !important;
        }

        .form-check-input:focus {
            box-shadow: none !important;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="./indexAdmin.php"><img src="../img/logo.png"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <form class="d-flex" role="search">
                    <input class="form-control me-2 search-input" type="search" placeholder="Buscar..." aria-label="Search">
                    <button class="btn search-btn" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
    </nav>
    <table class="mitabla">
        <thead class="table_head">
            <tr>
                <th>Usuario</th>
                <th>Email</th>
                <th>Fecha de Registro</th>
                <th>Rol</th>
                <th>Acciones
                    (Habilitar/Deshabilitar)
                </th>
            </tr>
        </thead>
        <tbody class="table_body">
            <?php include '../procesos/proc_users.php'; ?>
        </tbody>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>