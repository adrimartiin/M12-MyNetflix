<?php 
require_once '../bd/conexion.php';
try {
    // Inicializar variables de filtro
    $where = [];
    $params = [];
    
    // Filtro por título
    if (isset($_GET['titulo']) && !empty($_GET['titulo'])) {
        $where[] = "titulo LIKE :titulo";
        $params[':titulo'] = '%' . $_GET['titulo'] . '%';
    }
    
    // Filtro por director
    if (isset($_GET['director']) && !empty($_GET['director'])) {
        $where[] = "director LIKE :director";
        $params[':director'] = '%' . $_GET['director'] . '%';
    }
    
    // Filtro por año
    if (isset($_GET['ano']) && !empty($_GET['ano'])) {
        $where[] = "ano = :ano";
        $params[':ano'] = $_GET['ano'];
    }
    
    // Construir la consulta base
    $query = "SELECT id_peli, titulo, descripcion, director, ano, likes FROM tbl_peliculas";
    
    // Añadir condiciones WHERE si existen filtros
    if (!empty($where)) {
        $query .= " WHERE " . implode(" AND ", $where);
    }
    
    // Ordenar por likes si se especifica
    if (isset($_GET['orderLikes']) && $_GET['orderLikes'] === 'desc') {
        $query .= " ORDER BY likes DESC";
    }

    // Preparar y ejecutar la consulta
    $stmt = $conexion->prepare($query);
    
    // Vincular parámetros
    foreach ($params as $param => $value) {
        $stmt->bindValue($param, $value);
    }
    
    $stmt->execute();
    $films = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($films);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>


