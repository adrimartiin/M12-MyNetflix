<?php
require_once  '../bd/conexion.php';
// Recibir y sanear datos del formulario
$usuario = htmlspecialchars($_POST['usuario']);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = htmlspecialchars($_POST['password']);
$repePassword = htmlspecialchars($_POST['repe-password']);
$rol_id = 2; // Valor fijo para usuario normal
$estado = 'pendiente'; // Estado inicial del usuario

// Validar que las contraseñas coincidan
if ($password !== $repePassword) {
    die("Error: Las contraseñas no coinciden.");
}

// Encriptar la contraseña con password_hash
$contra_encriptada = password_hash($password, PASSWORD_BCRYPT);

try {
    // Verificar si el email ya está registrado
    $stmt_check = $conexion->prepare("SELECT id_usu FROM tbl_usuarios WHERE email = :email");
    $stmt_check->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt_check->execute();

    if ($stmt_check->rowCount() > 0) {
        header("Location: ../registrarse.php?info=registrado");
    }

    // Insertar el usuario en la base de datos
    $stmt = $conexion->prepare("INSERT INTO tbl_usuarios (nombre_usuario, email, password_hash, rol_id, estado) 
                           VALUES (:usuario, :email, :password_hash, :rol_id, :estado)");

    // Bind de los parámetros
    $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password_hash', $contra_encriptada, PDO::PARAM_STR);
    $stmt->bindParam(':rol_id', $rol_id, PDO::PARAM_INT);
    $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);

    if ($stmt->execute()) {
        header("Location: ../index.php?info=aceptacion");
        exit();
    } 
} catch (PDOException $e) {
    die("Error al registrar usuario: " . $e->getMessage());
}
?>
