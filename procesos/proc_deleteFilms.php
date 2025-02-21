<?php
require_once '../bd/conexion.php';

$response = ['success' => false];

// Verificar si se recibió una solicitud POST y si el ID está presente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Iniciar la transacción
    $conexion->beginTransaction();
    try {
        // elimina la película (ON DELETE CASCADE se encargará de tbl_likes)
        $queryPeli = "DELETE FROM tbl_peliculas WHERE id_peli = :id";
        $stmtPeli = $conexion->prepare($queryPeli);
        $stmtPeli->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtPeli->execute();

        // Confirmar la transacción
        $conexion->commit();

        $response['success'] = true;
    } catch (PDOException $e) {
        // Si hay un error, deshacer la transacción
        $conexion->rollBack();
        $response['error'] = "Error: " . $e->getMessage();
    }
} else {
    $response['error'] = "ID no proporcionado o método incorrecto.";
}

// Enviar la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);




