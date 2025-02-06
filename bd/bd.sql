CREATE DATABASE bd_netflix;

USE bd_netflix;

-- Tabla de roles
CREATE TABLE tbl_roles(
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) UNIQUE NOT NULL
)
ENGINE = InnoDB;

-- Tabla de usuarios
CREATE TABLE tbl_usuarios(
    id_usu INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    rol_id INT NOT NULL,
    estado ENUM('pendiente','activo','inactivo') NOT NULL DEFAULT 'pendiente',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
    ENGINE = InnoDB;

-- Tabla de películas
CREATE TABLE tbl_peliculas(
    id_peli INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    director VARCHAR(255),
    ano INT(4),
    imagen VARCHAR(255), /*Ruta de la imagen adicional*/
    likes INT DEFAULT 0,
    fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
ENGINE = InnoDB;

-- Tabla de likes de usuarios a películas
CREATE TABLE tbl_likes (
	id_likes INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_pelicula INT
)
ENGINE = InnoDB;

-- Tabla de registros pendientes (para validación de administradores)
CREATE TABLE tbl_registros_pendientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT UNIQUE,
    fecha_solicitud TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
ENGINE = InnoDB;

-- Claves foráneas
ALTER TABLE tbl_usuarios ADD CONSTRAINT fk_usuarios_rol FOREIGN KEY (rol_id) REFERENCES tbl_roles(id_rol);
ALTER TABLE tbl_likes ADD CONSTRAINT fk_likes_usuario FOREIGN KEY (id_usuario) REFERENCES tbl_usuarios(id_usu) ON DELETE CASCADE;
ALTER TABLE tbl_likes ADD CONSTRAINT fk_likes_pelicula FOREIGN KEY (id_pelicula) REFERENCES tbl_peliculas( id_peli) ON DELETE CASCADE;
ALTER TABLE tbl_registros_pendientes ADD CONSTRAINT fk_registros_usuario FOREIGN KEY (id_usuario) REFERENCES tbl_usuarios(id_usu) ON DELETE CASCADE;

-- Insertar roles
INSERT INTO tbl_roles (nombre) VALUES ('admin'), ('usuario');

-- Insertar usuarios
INSERT INTO tbl_usuarios (nombre_usuario, email, password_hash, rol_id, estado) VALUES
('Usuario Administrador', 'admin@netflix.com', 'contraseña_cifrada_1', 1, 'activo'),
('Usuario Uno', 'usuario1@netflix.com', 'contraseña_cifrada_2', 2, 'activo'),
('Usuario Dos', 'usuario2@netflix.com', 'contraseña_cifrada_3', 2, 'pendiente');

-- Insertar películas
INSERT INTO tbl_peliculas (titulo, descripcion, director, ano, imagen, likes) VALUES
('El Origen', 'Un ladrón que roba secretos...', 'Christopher Nolan', 2010, 'el_origen.jpg', 0),
('La Matrix', 'Un hacker descubre la verdad...', 'Lana Wachowski, Lilly Wachowski', 1999, 'la_matrix.jpg', 0),
('Interestelar', 'Un viaje más allá de las estrellas...', 'Christopher Nolan', 2014, 'interestelar.jpg', 0);

-- Insertar likes
INSERT INTO tbl_likes (id_usuario, id_pelicula) VALUES
(2, 1), -- Usuario Uno da like a El Origen
(2, 2), -- Usuario Uno da like a La Matrix
(3, 1); -- Usuario Dos da like a El Origen

-- Insertar registros pendientes
INSERT INTO tbl_registros_pendientes (id_usuario) VALUES
(3); -- Usuario Dos está pendiente de aprobación
