<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/gest_users.css">
    <title>Gestión Usuarios</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand text-white" href="./indexAdmin.php"><img src="../img/logo.png" alt="Logo"></a>
            
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

           
            <div class="collapse navbar-collapse d-flex justify-content-between align-items-center w-100" id="navbarSupportedContent">
                
                <div class="d-flex justify-content-start w-20"></div>

               
                <button class="btn btn-primary mx-3" type="button" id="crear">Añadir película</button>

                <div class="d-flex justify-content-end w-40">
                    <form class="d-flex" role="search">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input class="form-control search-input" id="search" type="search" placeholder="Buscar..." aria-label="Search">
                        </div>
                    </form>
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
                <th>Likes</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody class="table_body" id="resultado">
        </tbody>
    </table>
    <script src="../js/films_crud.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>




