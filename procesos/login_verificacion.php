<?php   
session_start();
require_once('../bd/conexion.php');         

if (isset($_POST['btn_login'])) {
    $nombre_usuario = trim($_POST['usuario-login']);  
    $contrasena_ingresada = $_POST['password-login'];

    try {
        $sql = "SELECT * FROM tbl_usuarios WHERE (nombre_usuario = :nombre_usuario OR email = :email)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
        $stmt->bindParam(':email', $nombre_usuario, PDO::PARAM_STR);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            if ($usuario['estado'] !== 'activo') {
                header('Location: ../login.php?info=pendiente');
                exit();
            }

            if (password_verify($contrasena_ingresada, $usuario['password_hash'])) {
                $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
                $_SESSION['id_usuario'] = $usuario['id_usu']; 
                $_SESSION['rol_id'] = $usuario['rol_id'];

                if ($usuario['rol_id'] == 1) {
                    header('Location: ../private/indexAdmin.php');
                } else {
                    header('Location: ../index.php');
                }
                exit();
            } else {
                header('Location: ../login.php?error=contra_incorrecta');
                exit();
            }
        } else {
            header('Location: ../login.php?error=usuario_no_encontrado');
            exit();
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    header('Location: ../login.php');
    exit();
}
