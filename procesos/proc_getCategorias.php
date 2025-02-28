<?php
// Incluir la conexión a la base de datos
include '../bd/conexion.php'; // Asegúrate de que este archivo contenga la lógica para conectarse a tu base de datos usando PDO

header('Content-Type: application/json');

try {
    // Preparar la consulta para obtener las categorías
    $query = "SELECT id, nombre FROM tbl_categorias"; // Cambia 'categorias' por el nombre de tu tabla de categorías
    $stmt = $conexion->prepare($query);
    $stmt->execute();

    // Verificar si se obtuvieron resultados
    if ($stmt->rowCount() > 0) {
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtener todas las categorías como un array asociativo

        // Devolver las categorías en formato JSON
        echo json_encode($categorias);
    } else {
        // Si no hay categorías, devolver un array vacío
        echo json_encode([]);
    }
} catch (Exception $e) {
    // Manejo de errores
    echo json_encode(['error' => 'Error al obtener las categorías: ' . $e->getMessage()]);
}

// Cerrar la conexión
$conexion = null; // Cerrar la conexión PDO
?>