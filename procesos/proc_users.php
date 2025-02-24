<?php
// Asegúrate de que solo se devuelve JSON cuando es necesario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json'); // Establecemos que la respuesta será JSON

    // Conectar con la base de datos
    require_once '../bd/conexion.php';

    // Leer los datos JSON enviados por el cliente (JavaScript)
    $input = json_decode(file_get_contents('php://input'), true);

    // Verificamos si se ha enviado el parámetro de búsqueda
    $busqueda = isset($input['busqueda']) ? trim($input['busqueda']) : '';

    // Construimos la consulta base
    $query = "SELECT id_usu, nombre_usuario, email, estado, fecha_registro, nombre AS rol 
              FROM tbl_usuarios 
              INNER JOIN tbl_roles ON tbl_usuarios.rol_id = tbl_roles.id_rol";

    // Si se recibe un término de búsqueda, aplicamos el filtro en la consulta
    if (!empty($busqueda)) {
        $query .= " WHERE nombre_usuario LIKE :busqueda OR email LIKE :busqueda";
    }

    try {
        $stmt = $conexion->prepare($query);

        // Si hay un término de búsqueda, lo vinculamos a la consulta
        if (!empty($busqueda)) {
            $busqueda = "%$busqueda%";
            $stmt->bindValue(':busqueda', $busqueda, PDO::PARAM_STR);
        }

        // Ejecutar la consulta
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Devolver los resultados como JSON
        echo json_encode($resultados);
    } catch (PDOException $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
}
?>
