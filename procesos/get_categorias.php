<?php
require_once '../bd/conexion.php';

try {
    $stmt = $conexion->query("SELECT id_categoria, nombre FROM tbl_categorias ORDER BY nombre");
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($categorias);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
