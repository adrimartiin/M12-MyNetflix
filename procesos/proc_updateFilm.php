<?php
header('Content-Type: application/json'); // Establece el encabezado de contenido

include '../bd/conexion.php';  // Asegúrate de incluir tu conexión a la base de datos

$id = $_POST['id'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$director = $_POST['director'];
$year = $_POST['year'];

$query = "UPDATE tbl_peliculas SET titulo = ?, descripcion = ?, director = ?, ano = ? WHERE id_peli = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssi", $titulo, $descripcion, $director, $year, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>