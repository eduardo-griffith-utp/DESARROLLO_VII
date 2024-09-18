CREATE DATABASE IF NOT EXISTS biblioteca;
USE biblioteca;

CREATE TABLE IF NOT EXISTS autores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS libros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    autor_id INT,
    FOREIGN KEY (autor_id) REFERENCES autores(id)
);

-- Insertar algunos datos de ejemplo
INSERT INTO autores (nombre) VALUES 
('Gabriel García Márquez'),
('Jorge Luis Borges'),
('Isabel Allende');

INSERT INTO libros (titulo, autor_id) VALUES 
('Cien años de soledad', 1),
('El Aleph', 2),
('La casa de los espíritus', 3);