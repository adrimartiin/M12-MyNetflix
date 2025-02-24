<?php
header('Content-Type: application/json');
include '../bd/conexion.php';
 

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'ID no proporcionado']);
    exit;
}

$id = $_GET['id'];
$query = "SELECT * FROM tbl_peliculas WHERE id_peli = ?";
$stmt = $conexion->prepare($query);

if (!$stmt) {
    echo json_encode(['error' => 'Error en la preparación de la consulta']);
    exit;
}

$stmt->bindParam(1, $id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    echo json_encode($result);
} else {
    echo json_encode(['error' => 'Película no encontrada']);
}

$stmt->closeCursor();
$conexion = null;
?>