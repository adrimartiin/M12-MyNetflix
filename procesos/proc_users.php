<?php
require_once '../bd/conexion.php';
// === CONSULTA ===
$query = "SELECT nombre_usuario, email, password_hash, fecha_registro, nombre FROM tbl_usuarios 
INNER JOIN tbl_roles ON tbl_usuarios.rol_id = tbl_roles.id_rol";

$stmt = $conexion->prepare($query);
$stmt->execute();
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC); // Convertir array de resultado de la consulta en array asociativo

// Mostrar resultados saneados
foreach ($resultados as $resultado) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($resultado['nombre_usuario']) . "</td>";
    echo "<td>" . htmlspecialchars($resultado['email']) . "</td>";
    echo "<td>" . htmlspecialchars($resultado['fecha_registro']) . "</td>";
    echo "<td>" . htmlspecialchars(ucfirst($resultado['nombre'])) . "</td>";
    echo '<td class="text-center">
            <div class="d-flex justify-content-center">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                </div>
            </div>
          </td>';
    echo "</tr>";
}

