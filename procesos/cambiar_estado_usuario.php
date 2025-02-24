<?php
require_once '../bd/conexion.php'; // Archivo de conexión a la BD

// Recibir datos JSON
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id_usu']) && isset($data['estado'])) {
    $idUsuario = $data['id_usu'];
    $nuevoEstado = $data['estado'];

    // Actualizar estado del usuario
    $sql = "UPDATE tbl_usuarios SET estado = :estado WHERE id_usu = :id_usu";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(':estado', $nuevoEstado, PDO::PARAM_STR);
    $stmt->bindValue(':id_usu', $idUsuario, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Datos inválidos"]);
}
?>
