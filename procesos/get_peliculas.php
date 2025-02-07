<?php
require_once '../bd/conexion.php';
header('Content-Type: application/json');

try {
    // Consulta las 5 películas con más likes
    $sql = "SELECT titulo, descripcion, imagen, likes FROM tbl_peliculas ORDER BY likes DESC LIMIT 5";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $peliculas = $stmt->fetchAll();

    echo json_encode($peliculas);
} catch (PDOException $e) {
    echo json_encode(["error" => "Error en la conexión: " . $e->getMessage()]);
}
?>
