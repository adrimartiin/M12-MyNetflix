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
    $imagen_actual = $_POST['imagen_actual'];
    
    // Manejo de la nueva imagen si se ha subido una
    $imagen = $imagen_actual; // Por defecto mantener la imagen actual
    
    if (isset($_FILES['nueva_imagen']) && $_FILES['nueva_imagen']['error'] === UPLOAD_ERR_OK) {
        $archivo = $_FILES['nueva_imagen'];
        $nombre_archivo = uniqid() . '_' . $archivo['name'];
        $ruta_destino = '../img/' . $nombre_archivo;
        
        // Verificar tipo de archivo
        $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($archivo['type'], $tipos_permitidos)) {
            echo json_encode(['success' => false, 'error' => 'Tipo de archivo no permitido']);
            exit;
        }
        
        // Mover el archivo
        if (move_uploaded_file($archivo['tmp_name'], $ruta_destino)) {
            // Eliminar imagen anterior si existe y no es la imagen por defecto
            if ($imagen_actual && file_exists('../img/' . $imagen_actual) && $imagen_actual != 'default.jpg') {
                unlink('../img/' . $imagen_actual);
            }
            $imagen = $nombre_archivo;
        } else {
            echo json_encode(['success' => false, 'error' => 'Error al subir la imagen']);
            exit;
        }
    }

    // Actualizar la base de datos
    $query = "UPDATE tbl_peliculas SET 
              titulo = :titulo, 
              descripcion = :descripcion, 
              director = :director, 
              ano = :ano, 
              imagen = :imagen 
              WHERE id_peli = :id";
              
    $stmt = $conexion->prepare($query);

    if ($stmt) {
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':director', $director, PDO::PARAM_STR);
        $stmt->bindParam(':ano', $year, PDO::PARAM_INT);
        $stmt->bindParam(':imagen', $imagen, PDO::PARAM_STR);
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