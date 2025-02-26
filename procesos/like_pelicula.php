<?php
require_once '../bd/conexion.php';
session_start();

if (!isset($_SESSION['nombre_usuario'])) {
    echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión para dar like.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $usuarioId = $_SESSION['id_usuario']; // Asegúrate de que el ID del usuario esté almacenado en la sesión

    // Verificar si el usuario ya ha dado like a esta película
    $stmt = $conexion->prepare("SELECT COUNT(*) FROM tbl_likes WHERE id_usuario = ? AND id_pelicula = ?");
    $stmt->execute([$usuarioId, $id]);
    $alreadyLiked = $stmt->fetchColumn();

    if ($alreadyLiked) {
        // Si ya ha dado like, eliminar el like
        $stmt = $conexion->prepare("DELETE FROM tbl_likes WHERE id_usuario = ? AND id_pelicula = ?");
        $stmt->execute([$usuarioId, $id]);

        // Decrementar el contador de likes en tbl_peliculas
        $stmt = $conexion->prepare("UPDATE tbl_peliculas SET likes = likes - 1 WHERE id_peli = ?");
        $stmt->execute([$id]);

        $message = 'Like eliminado';
    } else {
        // Si no ha dado like, añadir el like
        $stmt = $conexion->prepare("INSERT INTO tbl_likes (id_usuario, id_pelicula) VALUES (?, ?)");
        $stmt->execute([$usuarioId, $id]);

        // Incrementar el contador de likes en tbl_peliculas
        $stmt = $conexion->prepare("UPDATE tbl_peliculas SET likes = likes + 1 WHERE id_peli = ?");
        $stmt->execute([$id]);

        $message = 'Like añadido';
    }

    $stmt = $conexion->prepare("SELECT likes FROM tbl_peliculas WHERE id_peli = ?");
    $stmt->execute([$id]);
    $likes = $stmt->fetchColumn();

    echo json_encode(['success' => true, 'newLikes' => $likes, 'message' => $message]);
} else {
    echo json_encode(['success' => false]);
} 