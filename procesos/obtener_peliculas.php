<?php
require_once './bd/conexion.php';
session_start();

$usuarioId = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null;

// Consulta para obtener las películas agrupadas por categoría
$query = "SELECT p.id_peli, p.titulo, p.descripcion, p.director, p.ano, p.imagen, p.likes, c.nombre AS categoria,
          (SELECT COUNT(*) FROM tbl_likes WHERE id_usuario = :usuarioId AND id_pelicula = p.id_peli) AS usuarioHaDadoLike
          FROM tbl_peliculas p
          JOIN tbl_categorias c ON p.id_categoria = c.id_categoria
          ORDER BY c.nombre, p.titulo";

$statement = $conexion->prepare($query);
$statement->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
$statement->execute();

$peliculasPorCategoria = [];
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $peliculasPorCategoria[$row['categoria']][] = $row;
} 