<?php 
require_once '../bd/conexion.php';
try{
// consulta 
$query = "SELECT titulo, descripcion, director, ano, likes FROM tbl_peliculas";
// preparar y ejecutar consulta
$stmt = $conexion->prepare($query);
$stmt->execute();

//trabajar con resultados como array asociativo
$films = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($films);
} catch (PDOException $e){
    echo "Error: ". $e->getMessage();
}


