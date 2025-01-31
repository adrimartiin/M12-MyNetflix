CREATE DATABASE bd_netflix;
USE bd_netflix;

-- Tabla de roles
CREATE TABLE tbl_roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) UNIQUE NOT NULL
);

-- Tabla de usuarios
CREATE TABLE tbl_usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    rol_id INT NOT NULL,
    estado ENUM('pendiente', 'activo', 'inactivo') NOT NULL DEFAULT 'pendiente',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de películas
CREATE TABLE tbl_peliculas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    director VARCHAR(255),
    año INT,
    imagen VARCHAR(255), -- Ruta de la imagen adicional
    likes INT DEFAULT 0,
    fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de likes de usuarios a películas
CREATE TABLE tbl_likes (
    id_usuario INT,
    id_pelicula INT,
    PRIMARY KEY (id_usuario, id_pelicula)
);

-- Tabla de registros pendientes (para validación de administradores)
CREATE TABLE tbl_registros_pendientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT UNIQUE,
    fecha_solicitud TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Claves foráneas
ALTER TABLE tbl_usuarios ADD CONSTRAINT fk_usuarios_rol FOREIGN KEY (rol_id) REFERENCES tbl_roles(id);
ALTER TABLE tbl_likes ADD CONSTRAINT fk_likes_usuario FOREIGN KEY (id_usuario) REFERENCES tbl_usuarios(id) ON DELETE CASCADE;
ALTER TABLE tbl_likes ADD CONSTRAINT fk_likes_pelicula FOREIGN KEY (id_pelicula) REFERENCES tbl_peliculas(id) ON DELETE CASCADE;
ALTER TABLE tbl_registros_pendientes ADD CONSTRAINT fk_registros_usuario FOREIGN KEY (id_usuario) REFERENCES tbl_usuarios(id) ON DELETE CASCADE;