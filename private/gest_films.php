<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/gest_users.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Gestión Películas</title>
</head>

<body>
    <nav class="navbar navbar-dark navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="./indexAdmin.php">
                <img src="../img/logo.png" alt="Logo">
            </a>
            
            <!-- Botón hamburguesa -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Contenido del menú -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <div class="navbar-nav ms-auto">
                    <!-- Filtros en el menú -->
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-filter"></i> Filtros
                        </a>
                        <div class="dropdown-menu dropdown-menu-dark p-3">
                            <div class="mb-3">
                                <label for="titulo-filter" class="form-label">Título</label>
                                <input type="text" id="titulo-filter" class="form-control" placeholder="Buscar por título">
                            </div>
                            <div class="mb-3">
                                <label for="director-filter" class="form-label">Director</label>
                                <input type="text" id="director-filter" class="form-control" placeholder="Buscar por director">
                            </div>
                            <div class="mb-3">
                                <label for="ano-filter" class="form-label">Año</label>
                                <input type="number" id="ano-filter" class="form-control" placeholder="Filtrar por año">
                            </div>
                        </div>
                    </div>
                    <!-- Botón Añadir -->
                    <div class="nav-item">
                        <button class="btn-login nav-link" id="crear">
                            <i class="fas fa-plus"></i> Añadir Película
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="table-responsive">
        <table class="mitabla">
            <thead class="table_head">
                <tr>
                    <th>Título</th>
                    <th class="hide-mobile">Descripción</th>
                    <th>Director</th>
                    <th>Año</th>
                    <th class="hide-mobile">Likes 
                        <span id="likes-order" style="cursor: pointer;">
                            <i class="fas fa-sort"></i>
                        </span>
                    </th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="table_body" id="resultado"></tbody>
        </table>
    </div>

    <!-- Añadir esto justo después de la tabla -->
    <div class="pagination-container" id="pagination"></div>

    <script src="../js/films_crud.js"></script>
    <script src="../js/sweetalert.js"></script>
    <script src="../js/filter_films.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>






