<?php
header('Content-Type: application/json'); // Establece el encabezado de contenido

include '../bd/conexion.php';  // Asegúrate de incluir tu conexión a la base de datos

// Verificar si se han enviado todos los datos necesarios
if (isset($_POST['id'], $_POST['titulo'], $_POST['descripcion'], $_POST['director'], $_POST['year'])) {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $director = $_POST['director'];
    $year = $_POST['year'];

    $query = "UPDATE tbl_peliculas SET titulo = :titulo, descripcion = :descripcion, director = :director, ano = :ano WHERE id_peli = :id";
    $stmt = $conexion->prepare($query);

    if ($stmt) {
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':director', $director, PDO::PARAM_STR);
        $stmt->bindParam(':ano', $year, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->errorInfo()]);
        }

        $stmt->closeCursor();
    } else {
        echo json_encode(['success' => false, 'error' => 'Error en la preparación de la consulta']);
    }

    $conexion = null;
} else {
    echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
}
?>