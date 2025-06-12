CREATE DATABASE bahamut;
use bahamut;
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    descripcion TEXT
);

INSERT INTO roles (nombre, descripcion) VALUES
('usuario', 'Usuario normal con acceso limitado'),
('usuario_permisos', 'Usuario con acceso a sus credenciales'),
('administrador', 'Acceso total a todo el sistema');

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(100) NOT NULL UNIQUE,
    contraseña TEXT NOT NULL, 
    correo_electronico VARCHAR(255),
    id_rol INT NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_usuarios_rol FOREIGN KEY (id_rol) REFERENCES roles(id)
);

CREATE TABLE maquinas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    direccion_ip VARCHAR(45) NOT NULL,
    descripcion TEXT,
    creada_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE credenciales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_maquina INT NOT NULL,
    usuario_maquina VARCHAR(100) NOT NULL,
    contraseña TEXT NOT NULL,
    creada_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_maquina) REFERENCES maquinas(id) ON DELETE CASCADE
);
CREATE TABLE permisos_usuarios_maquinas (
    id_usuario INT NOT NULL,
    id_maquina INT NOT NULL,
    nivel_permiso VARCHAR(50) NOT NULL,
    PRIMARY KEY (id_usuario, id_maquina),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_maquina) REFERENCES maquinas(id) ON DELETE CASCADE
);

INSERT INTO usuarios (nombre_usuario, contraseña, correo_electronico, id_rol) VALUES
('admin', 'admin123', 'admin@bahamut.local', 3),
('usuario1', 'clave123', 'usuario1@bahamut.local', 1),
('usuario2', 'clave456', 'usuario2@bahamut.local', 2);

INSERT INTO maquinas (nombre, direccion_ip, descripcion) VALUES
('Servidor 1', '192.168.1.101', 'Producción'),
('Servidor 2', '192.168.1.102', 'Pruebas'),
('Servidor 3', '192.168.1.103', 'Desarrollo'),
('Servidor 4', '192.168.1.104', 'Respaldo');

INSERT INTO credenciales (id_maquina, usuario_maquina, contraseña) VALUES
(1, 'admin_s1', 's1pass'),
(2, 'admin_s2', 's2pass'),
(3, 'admin_s3', 's3pass'),
(4, 'admin_s4', 's4pass');

INSERT INTO permisos_usuarios_maquinas (id_usuario, id_maquina, nivel_permiso) VALUES
(1, 1, 'conectar'),
(1, 2, 'ver_credenciales'),
(2, 2, 'conectar'),
(2, 3, 'ver_credenciales'),
(3, 1, 'administrar'),
(3, 2, 'administrar'),
(3, 3, 'administrar'),
(3, 4, 'administrar'); 
