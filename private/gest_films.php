<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/gest_users.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Gestión Usuarios</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand text-white" href="./indexAdmin.php">
                <img src="../img/logo.png" alt="Logo">
            </a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="filters-container d-flex align-items-center gap-3 ms-auto">
                    <div class="input-group">
                        <span class="input-group-text">Título</span>
                        <input type="text" id="titulo-filter" class="form-control" placeholder="Filtrar por título...">
                    </div>
                    
                    <div class="input-group">
                        <span class="input-group-text">Director</span>
                        <input type="text" id="director-filter" class="form-control" placeholder="Filtrar por director...">
                    </div>
                    
                    <div class="input-group">
                        <span class="input-group-text">Año</span>
                        <input type="number" id="ano-filter" class="form-control" placeholder="Año...">
                    </div>

                    <button class="btn-login" type="button" id="crear">Añadir película</button>
                </div>
            </div>
        </div>
    </nav>
    
    <table class="mitabla">
        <thead class="table_head">
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Director</th>
                <th>Año</th>
                <th>
                    Likes 
                    <span id="likes-order" style="cursor: pointer;">
                        <i class="fas fa-sort"></i>
                    </span>
                </th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody class="table_body" id="resultado">
        </tbody>
    </table>
    <script src="../js/films_crud.js"></script>
    <script src="../js/sweetalert.js"></script>
    <script src="../js/filter_films.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>






