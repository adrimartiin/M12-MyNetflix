<?php
require_once './bd/conexion.php';
session_start();
$peliculasPorCategoria = [];
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$anio = isset($_GET['anio']) ? $_GET['anio'] : '';
$usuarioId = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null;

$query = "SELECT p.id_peli, p.titulo, p.descripcion, p.director, p.ano, p.imagen, p.likes, c.nombre AS categoria,
          (SELECT COUNT(*) FROM tbl_likes WHERE id_usuario = :usuarioId AND id_pelicula = p.id_peli) AS usuarioHaDadoLike
          FROM tbl_peliculas p
          JOIN tbl_categorias c ON p.id_categoria = c.id_categoria
          WHERE 1=1";

if (!empty($categoria)) {
    $query .= " AND c.nombre = :categoria";
}
if (!empty($anio)) {
    $query .= " AND p.ano = :anio";
}

$statement = $conexion->prepare($query);
$statement->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
if (!empty($categoria)) {
    $statement->bindParam(':categoria', $categoria, PDO::PARAM_STR);
}
if (!empty($anio)) {
    $statement->bindParam(':anio', $anio, PDO::PARAM_INT);
}

$statement->execute();
$peliculas = $statement->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($peliculas);
?>
