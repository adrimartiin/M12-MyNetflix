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

CREATE TABLE tbl_categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) UNIQUE NOT NULL
)
ENGINE = InnoDB;

-- Tabla de películas
CREATE TABLE tbl_peliculas(
    id_peli INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    director VARCHAR(255),
    ano INT(4),
    id_categoria INT NOT NULL,
    imagen VARCHAR(255), /*Ruta de la imagen adicional*/
    likes INT DEFAULT 0,
    fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
ENGINE = InnoDB;

-- Tabla de likes de usuarios a películas
CREATE TABLE tbl_likes (
    id_likes INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_pelicula INT,
    UNIQUE KEY (id_usuario, id_pelicula)  -- Asegura que un usuario solo pueda dar like una vez por película
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
ALTER TABLE tbl_peliculas ADD CONSTRAINT fk_peliculas_categoria FOREIGN KEY (id_categoria) REFERENCES tbl_categorias(id_categoria) ON DELETE CASCADE;
-- Insertar roles
INSERT INTO tbl_roles (nombre) VALUES ('admin'), ('usuario');

-- Insertar categorías
INSERT INTO tbl_categorias (nombre) VALUES
('Acción'),
('Aventura'),
('Ciencia Ficción'),
('Drama'),
('Comedia'),
('Terror'),
('Animación'),
('Fantasía'),
('Superhéroes'),
('Documental'),  -- Nueva categoría para id_categoria 9
('Musical');     -- Nueva categoría para id_categoria 10

-- Insertar usuarios
INSERT INTO tbl_usuarios (nombre_usuario, email, password_hash, rol_id, estado) VALUES
('Usuario Administrador', 'admin@netflix.com', '$2y$10$Z5U9.7bBJB1nF7U0wmlPc.uSQ9hJv4K6TksO0nC8bxGcQ750bjPzi', 1, 'activo'),
('Usuario Uno', 'usuario1@netflix.com', '$2y$10$meykvSqT7EkSzWxFmQnfyuleoO9AbiMOgm5HvUxMqQtZQT4q3m5Dm', 2, 'activo'),
('Usuario Dos', 'usuario2@netflix.com', '$2y$10$zAvIjfz8KsvWLZZ5ERg58.PzcYw7.jlIYMTfWIFvT3GRoJmBDJV.6', 2, 'pendiente');

-- Insertar películas
INSERT INTO tbl_peliculas (titulo, descripcion, director, ano, imagen, likes, id_categoria) VALUES
('Oppenheimer', 'Biografía del creador de la bomba atómica.', 'Christopher Nolan', 2023, 'oppenheimer.jpg', 100, 1),
('Barbie', 'Una muñeca en un mundo real descubre su propósito.', 'Greta Gerwig', 2023, 'barbie.jpg', 120, 2),
('Avatar: El camino del agua', 'Secuela de la épica aventura en Pandora.', 'James Cameron', 2023, 'avatar2.jpg', 150, 3),
('Dune: Parte Dos', 'La continuación de la lucha de Paul Atreides.', 'Denis Villeneuve', 2024, 'dune2.jpg', 95, 4),
('Ne Zha 2', 'Película de animación china sobre el legendario Ne Zha.', 'Yu Yang', 2024, 'nezha2.jpg', 80, 5),
('Padre no hay más que uno 4', 'Cuarta entrega de la comedia familiar española.', 'Santiago Segura', 2024, 'padre4.jpg', 60, 6),
('Avatar 3', 'Nueva entrega de la saga de James Cameron.', 'James Cameron', 2025, 'avatar3.jpg', 110, 7),
('Misión Imposible 8', 'Ethan Hunt enfrenta su misión más peligrosa.', 'Christopher McQuarrie', 2025, 'mi8.jpg', 105, 8),
('Jurassic World 4', 'El regreso de los dinosaurios a la gran pantalla.', 'Aún por confirmar', 2025, 'jurassic4.jpg', 90, 9),
('Deadpool 3', 'Deadpool y Wolverine unen fuerzas en una aventura multiversal.', 'Shawn Levy', 2024, 'deadpool3.jpg', 84, 10),
('Película 1', 'Descripción de la película 1.', 'Director 1', 2023, 'pelicula1.jpg', 23, 1),
('Película 2', 'Descripción de la película 2.', 'Director 2', 2023, 'pelicula2.jpg', 45, 3),
('Película 3', 'Descripción de la película 3.', 'Director 3', 2023, 'pelicula3.jpg', 67, 5),
('Película 4', 'Descripción de la película 4.', 'Director 4', 2023, 'pelicula4.jpg', 12, 2),
('Película 5', 'Descripción de la película 5.', 'Director 5', 2023, 'pelicula5.jpg', 89, 4),
('Película 6', 'Descripción de la película 6.', 'Director 6', 2023, 'pelicula6.jpg', 34, 6),
('Película 7', 'Descripción de la película 7.', 'Director 7', 2023, 'pelicula7.jpg', 56, 7),
('Película 8', 'Descripción de la película 8.', 'Director 8', 2023, 'pelicula8.jpg', 78, 8),
('Película 9', 'Descripción de la película 9.', 'Director 9', 2023, 'pelicula9.jpg', 90, 9),
('Película 10', 'Descripción de la película 10.', 'Director 10', 2023, 'pelicula10.jpg', 21, 10),
('Película 11', 'Descripción de la película 11.', 'Director 11', 2023, 'pelicula11.jpg', 43, 1),
('Película 12', 'Descripción de la película 12.', 'Director 12', 2023, 'pelicula12.jpg', 55, 2),
('Película 13', 'Descripción de la película 13.', 'Director 13', 2023, 'pelicula13.jpg', 66, 3),
('Película 14', 'Descripción de la película 14.', 'Director 14', 2023, 'pelicula14.jpg', 77, 4),
('Película 15', 'Descripción de la película 15.', 'Director 15', 2023, 'pelicula15.jpg', 88, 5),
('Película 16', 'Descripción de la película 16.', 'Director 16', 2023, 'pelicula16.jpg', 99, 6),
('Película 17', 'Descripción de la película 17.', 'Director 17', 2023, 'pelicula17.jpg', 11, 7),
('Película 18', 'Descripción de la película 18.', 'Director 18', 2023, 'pelicula18.jpg', 22, 8),
('Película 19', 'Descripción de la película 19.', 'Director 19', 2023, 'pelicula19.jpg', 33, 9),
('Película 20', 'Descripción de la película 20.', 'Director 20', 2023, 'pelicula20.jpg', 44, 10),
('Película 21', 'Descripción de la película 21.', 'Director 21', 2023, 'pelicula21.jpg', 55, 1),
('Película 22', 'Descripción de la película 22.', 'Director 22', 2023, 'pelicula22.jpg', 66, 2),
('Película 23', 'Descripción de la película 23.', 'Director 23', 2023, 'pelicula23.jpg', 77, 3),
('Película 24', 'Descripción de la película 24.', 'Director 24', 2023, 'pelicula24.jpg', 88, 4),
('Película 25', 'Descripción de la película 25.', 'Director 25', 2023, 'pelicula25.jpg', 99, 5),
('Película 26', 'Descripción de la película 26.', 'Director 26', 2023, 'pelicula26.jpg', 11, 6),
('Película 27', 'Descripción de la película 27.', 'Director 27', 2023, 'pelicula27.jpg', 22, 7),
('Película 28', 'Descripción de la película 28.', 'Director 28', 2023, 'pelicula28.jpg', 33, 8),
('Película 29', 'Descripción de la película 29.', 'Director 29', 2023, 'pelicula29.jpg', 44, 9),
('Película 30', 'Descripción de la película 30.', 'Director 30', 2023, 'pelicula30.jpg', 55, 10),
('Película 31', 'Descripción de la película 31.', 'Director 31', 2023, 'pelicula31.jpg', 66, 1),
('Película 32', 'Descripción de la película 32.', 'Director 32', 2023, 'pelicula32.jpg', 77, 2),
('Película 33', 'Descripción de la película 33.', 'Director 33', 2023, 'pelicula33.jpg', 88, 3),
('Película 34', 'Descripción de la película 34.', 'Director 34', 2023, 'pelicula34.jpg', 99, 4),
('Película 35', 'Descripción de la película 35.', 'Director 35', 2023, 'pelicula35.jpg', 11, 5),
('Película 36', 'Descripción de la película 36.', 'Director 36', 2023, 'pelicula36.jpg', 22, 6),
('Película 37', 'Descripción de la película 37.', 'Director 37', 2023, 'pelicula37.jpg', 33, 7),
('Película 38', 'Descripción de la película 38.', 'Director 38', 2023, 'pelicula38.jpg', 44, 8),
('Película 39', 'Descripción de la película 39.', 'Director 39', 2023, 'pelicula39.jpg', 55, 9),
('Película 40', 'Descripción de la película 40.', 'Director 40', 2023, 'pelicula40.jpg', 66, 10),
('Película 41', 'Descripción de la película 41.', 'Director 41', 2023, 'pelicula41.jpg', 77, 1),
('Película 42', 'Descripción de la película 42.', 'Director 42', 2023, 'pelicula42.jpg', 88, 2),
('Película 43', 'Descripción de la película 43.', 'Director 43', 2023, 'pelicula43.jpg', 99, 3),
('Película 44', 'Descripción de la película 44.', 'Director 44', 2023, 'pelicula44.jpg', 11, 4),
('Película 45', 'Descripción de la película 45.', 'Director 45', 2023, 'pelicula45.jpg', 22, 5),
('Película 46', 'Descripción de la película 46.', 'Director 46', 2023, 'pelicula46.jpg', 33, 6),
('Película 47', 'Descripción de la película 47.', 'Director 47', 2023, 'pelicula47.jpg', 44, 7),
('Película 48', 'Descripción de la película 48.', 'Director 48', 2023, 'pelicula48.jpg', 55, 8),
('Película 49', 'Descripción de la película 49.', 'Director 49', 2023, 'pelicula49.jpg', 66, 9),
('Película 50', 'Descripción de la película 50.', 'Director 50', 2023, 'pelicula50.jpg', 77, 10);

-- Insertar likes
INSERT INTO tbl_likes (id_usuario, id_pelicula) VALUES
(2, 1), -- Usuario Uno da like a El Origen
(2, 2), -- Usuario Uno da like a La Matrix
(3, 1); -- Usuario Dos da like a El Origen

-- Insertar registros pendientes
INSERT INTO tbl_registros_pendientes (id_usuario) VALUES
(3); -- Usuario Dos está pendiente de aprobación
