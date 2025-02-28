<?php
require_once '../bd/conexion.php';

session_start(); // Asegúrate de que la sesión esté iniciada
$usuarioId = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null;

// Recibir los parámetros de los filtros (si están presentes)
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$ano = isset($_GET['ano']) ? $_GET['ano'] : '';

// Crear la consulta base
$query = "SELECT p.id_peli, p.titulo, p.descripcion, p.director, p.ano, p.imagen, p.likes, c.nombre AS categoria,
          (SELECT COUNT(*) FROM tbl_likes WHERE id_usuario = :usuarioId AND id_pelicula = p.id_peli) AS usuarioHaDadoLike
          FROM tbl_peliculas p
          JOIN tbl_categorias c ON p.id_categoria = c.id_categoria
          WHERE 1=1";

// Agregar condiciones según los filtros seleccionados
if ($categoria) {
    $query .= " AND c.nombre = :categoria";
}
if ($nombre) {
    $query .= " AND p.titulo LIKE :nombre";
}
if ($ano) {
    $query .= " AND p.ano = :ano";
}

// Preparar la consulta
$stmt = $conexion->prepare($query);

// Vincular los parámetros a los valores
$stmt->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);

if ($categoria) {
    $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
}
if ($nombre) {
    $nombreBusqueda = "%$nombre%";
    $stmt->bindParam(':nombre', $nombreBusqueda, PDO::PARAM_STR);
}
if ($ano) {
    $stmt->bindParam(':ano', $ano, PDO::PARAM_INT);
}

// Ejecutar la consulta
$stmt->execute();

// Obtener los resultados y agrupar las películas por categoría
$peliculasPorCategoria = [];
while ($pelicula = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $peliculasPorCategoria[$pelicula['categoria']][] = $pelicula;
}

// Generar el HTML de las películas agrupadas por categoría
$contenidoHTML = '';
foreach ($peliculasPorCategoria as $categoria => $peliculas) {
    $contenidoHTML .= '<div class="categoria mb-4">';
    $contenidoHTML .= '<h3 class="text-white">' . htmlspecialchars($categoria) . '</h3>';
    $contenidoHTML .= '<div class="scroll-container">';

    foreach ($peliculas as $pelicula) {
        $contenidoHTML .= '<div class="pelicula">';
        $contenidoHTML .= '<img src="./img/' . htmlspecialchars($pelicula['imagen']) . '" ';
        $contenidoHTML .= 'alt="' . htmlspecialchars($pelicula['titulo']) . '" ';
        $contenidoHTML .= 'class="img-fluid pelicula-img" ';
        $contenidoHTML .= 'data-titulo="' . htmlspecialchars($pelicula['titulo']) . '" ';
        $contenidoHTML .= 'data-descripcion="' . htmlspecialchars($pelicula['descripcion']) . '" ';
        $contenidoHTML .= 'data-director="' . htmlspecialchars($pelicula['director']) . '" ';
        $contenidoHTML .= 'data-ano="' . htmlspecialchars($pelicula['ano']) . '" ';
        $contenidoHTML .= 'data-likes="' . htmlspecialchars($pelicula['likes']) . '" ';
        $contenidoHTML .= 'data-id="' . htmlspecialchars($pelicula['id_peli']) . '" ';
        $contenidoHTML .= 'data-liked="' . ($pelicula['usuarioHaDadoLike'] ? 'true' : 'false') . '">';
        $contenidoHTML .= '</div>';
    }

    $contenidoHTML .= '</div></div>';
}

// Si no hay películas, mostrar mensaje
if (empty($contenidoHTML)) {
    $contenidoHTML = '<p>No se encontraron películas con los filtros seleccionados.</p>';
}

echo $contenidoHTML;
?>
