<?php
    $host = "localhost";
    $dbname = "bd_netflix";
    $username = "root";
    $password = "";

    try {
        $conexion = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }