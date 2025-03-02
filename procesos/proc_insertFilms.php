<?php
require_once '../bd/conexion.php';

$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$director = $_POST['director'];
$yearFilm = $_POST['year'];
$categoria = $_POST['categoria'];

// Inicializar variable para la imagen
$img = "default.png"; // Imagen por defecto en caso de no subir una

// Comprobar si se ha subido una imagen
if (!empty($_FILES['peli_img']['name'])) {
    $dir_subida = '../img/';
    if (!is_dir($dir_subida)) {
        mkdir($dir_subida, 0777, true); // Crear directorio si no existe
    }

    $archivo_tmp = $_FILES['peli_img']['tmp_name'];
    $archivo_nombre = $_FILES['peli_img']['name'];
    $archivo_tamano = $_FILES['peli_img']['size'];
    $archivo_ext = strtolower(pathinfo($archivo_nombre, PATHINFO_EXTENSION));

    $formatos_permitidos = ['jpg', 'jpeg', 'png', 'gif'];
    $tamano_maximo = 2 * 1024 * 1024; // 2MB

    // Validar formato de imagen
    if (!in_array($archivo_ext, $formatos_permitidos)) {
        header("Location: ../registrar.php?errorFormato=true");
        exit();
    }

    // Validar tamaño de imagen
    if ($archivo_tamano > $tamano_maximo) {
        header("Location: ../registrar.php?errorTamano=true");
        exit();
    }

    // Generar nombre único para la imagen
    $nombre_unico = time() . "" . uniqid() . "." . $archivo_ext;
    $ruta_final = $dir_subida . $nombre_unico;

    // Mover archivo a la carpeta de imágenes
    if (move_uploaded_file($archivo_tmp, $ruta_final)) {
        $img = $nombre_unico; // Guardar el nombre con su extensión en la BD
    }
}

try {
    // Insertar datos en la base de datos, incluyendo el nombre de la imagen
    $query = "INSERT INTO tbl_peliculas (titulo, descripcion, director, ano, imagen, id_categoria) VALUES
    (:titulo, :descripcion, :director, :yearFilm, :img, :categoria)";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':director', $director);
    $stmt->bindParam(':yearFilm', $yearFilm);
    $stmt->bindParam(':img', $img);
    $stmt->bindParam(':categoria', $categoria);
    $stmt->execute();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

