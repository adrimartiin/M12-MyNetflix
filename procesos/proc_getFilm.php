<?php
header('Content-Type: application/json');
include '../bd/conexion.php';
 

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'ID no proporcionado']);
    exit;
}

$id = $_GET['id'];
$query = "SELECT * FROM tbl_peliculas WHERE id_peli = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    echo json_encode(['error' => 'Error en la preparación de la consulta']);
    exit;
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $film = $result->fetch_assoc();
    echo json_encode($film);
} else {
    echo json_encode(['error' => 'Película no encontrada']);
}

$stmt->close();
$conn->close();
?>