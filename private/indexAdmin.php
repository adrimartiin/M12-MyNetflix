<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Index</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }

        .container-menu {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        section {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .image-container {
            position: relative;
            width: 100%;
            max-width: 600px; /* Más grande */
            height: 50vh; /* Aumentado el tamaño para mejor visibilidad */
            overflow: hidden;
            transition: transform 0.5s ease;
            flex: 1 1 500px;
            margin: 15px;
            text-align: center;
        }

        section img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.8;
            border-radius: 10px;
            transition: transform 0.5s ease, opacity 0.5s ease, filter 0.5s ease;
        }

        section img:hover {
            opacity: 1;
            filter: brightness(0.4);
        }

        .image-container:hover {
            transform: scale(1.1);
        }

        .text-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 30px; /* Texto más grande */
            font-weight: bold;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .image-container:hover .text-overlay {
            opacity: 1;
        }
    </style>
</head>

<body>
    <div class="container-menu">
        <section>
            <a class="image-container" href="./seleccionar_sala?categoria=Comedor">
                <img src="../img/crud_admin_usrs.png" alt="" id="comedor">
                <div class="text-overlay">Usuarios</div>
            </a>
            <a class="image-container" href="./seleccionar_sala?categoria=Privada">
                <img src="../img/crud_admin_films.png" alt="" id="privada">
                <div class="text-overlay">Películas</div>
            </a>
        </section>
    </div>
</body>

</html>

