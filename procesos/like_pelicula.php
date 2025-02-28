<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../bd/conexion.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Debes iniciar sesión para dar like'
    ]);
    exit;
}

// Obtener el ID de la película y el usuario
$idPelicula = isset($_GET['id']) ? intval($_GET['id']) : 0;
$idUsuario = $_SESSION['id_usuario'];

if ($idPelicula <= 0) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'ID de película no válido'
    ]);
    exit;
}

try {
    // Asegurar que la conexión está activa
    if (!$conexion) {
        throw new Exception('La conexión a la base de datos no está disponible');
    }

    // Verificar si el usuario ya dio like a esta película
    $stmt = $conexion->prepare("SELECT id_likes FROM tbl_likes WHERE id_usuario = ? AND id_pelicula = ?");
    $stmt->execute([$idUsuario, $idPelicula]);
    $like = $stmt->fetch();

    if ($like) {
        // Si existe el like, lo eliminamos
        $stmt = $conexion->prepare("DELETE FROM tbl_likes WHERE id_usuario = ? AND id_pelicula = ?");
        $stmt->execute([$idUsuario, $idPelicula]);

        // Actualizar el contador de likes en la tabla de películas
        $stmt = $conexion->prepare("UPDATE tbl_peliculas SET likes = likes - 1 WHERE id_peli = ?");
        $stmt->execute([$idPelicula]);

        // Obtener el nuevo número de likes
        $stmt = $conexion->prepare("SELECT likes FROM tbl_peliculas WHERE id_peli = ?");
        $stmt->execute([$idPelicula]);
        $newLikes = $stmt->fetchColumn();

        echo json_encode([
            'success' => true,
            'message' => 'Like eliminado correctamente',
            'newLikes' => $newLikes
        ]);
    } else {
        // Si no existe el like, lo añadimos
        $stmt = $conexion->prepare("INSERT INTO tbl_likes (id_usuario, id_pelicula) VALUES (?, ?)");
        $stmt->execute([$idUsuario, $idPelicula]);

        // Actualizar el contador de likes en la tabla de películas
        $stmt = $conexion->prepare("UPDATE tbl_peliculas SET likes = likes + 1 WHERE id_peli = ?");
        $stmt->execute([$idPelicula]);

        // Obtener el nuevo número de likes
        $stmt = $conexion->prepare("SELECT likes FROM tbl_peliculas WHERE id_peli = ?");
        $stmt->execute([$idPelicula]);
        $newLikes = $stmt->fetchColumn();

        echo json_encode([
            'success' => true,
            'message' => 'Like añadido correctamente',
            'newLikes' => $newLikes
        ]);
    }
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Error al procesar el like: ' . $e->getMessage()
    ]);
}
?> 