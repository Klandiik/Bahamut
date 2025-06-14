
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `credenciales` (
  `id` int(11) NOT NULL,
  `id_maquina` int(11) NOT NULL,
  `usuario_maquina` varchar(100) NOT NULL,
  `contraseña` text NOT NULL,
  `creada_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `credenciales` (`id`, `id_maquina`, `usuario_maquina`, `contraseña`, `creada_en`) VALUES
(1, 1, 'Administrador', 'TiFor22!!', '2025-06-12 10:55:54'),
(2, 2, 'admin_s2', 's2pass', '2025-06-12 10:55:54'),
(3, 3, 'admin_s3', 's3pass', '2025-06-12 10:55:54'),
(4, 4, 'admin_s4', 's4pass', '2025-06-12 10:55:54');



CREATE TABLE `maquinas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion_ip` varchar(45) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `creada_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `maquinas` (`id`, `nombre`, `direccion_ip`, `descripcion`, `creada_en`) VALUES
(0, 'sin asignar', '0.0.0.0', 'Sin asignar', '2025-06-13 10:41:03'),
(1, 'SERVER-SV-TITFOT', '192.168.0.35', 'Producción', '2025-06-12 10:55:54'),
(2, 'Servidor 2', '192.168.1.102', 'Pruebas', '2025-06-12 10:55:54'),
(3, 'Servidor 3', '192.168.1.103', 'Desarrollo', '2025-06-12 10:55:54'),
(4, 'Servidor 4', '192.168.1.104', 'Respaldo', '2025-06-12 10:55:54'),
(5, 'Servidor 1', '192.168.1.101', 'Marketing', '2025-06-12 15:24:16'),
(6, 'Servidor 2', '192.168.2.110', 'Producción', '2025-06-12 15:24:16');

INSERT INTO `maquinas` (`nombre`, `direccion_ip`, `descripcion`,) VALUES
('sin asignar', '0.0.0.0', 'Sin asignar', ),
('sin asignar', '0.0.0.0', 'Sin asignar', ),;


CREATE TABLE `permisos_usuarios_maquinas` (
  `id_usuario` int(11) NOT NULL,
  `id_maquina` int(11) NOT NULL,
  `nivel_permiso` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-

INSERT INTO `permisos_usuarios_maquinas` (`id_usuario`, `id_maquina`, `nivel_permiso`) VALUES
(1, 1, 'conectar'),
(1, 2, 'ver_credenciales'),
(2, 2, 'conectar'),
(2, 3, 'ver_credenciales'),
(3, 1, 'administrar'),
(3, 2, 'administrar'),
(3, 3, 'administrar'),
(3, 4, 'ningun permiso'),
(8, 0, 'ningun permiso'),
(9, 0, 'ningun permiso');


CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `roles` (`id`, `nombre`, `descripcion`) VALUES
(1, 'usuario', 'Usuario normal con acceso limitado'),
(2, 'usuario_permisos', 'Usuario con acceso a sus credenciales'),
(3, 'administrador', 'Acceso total a todo el sistema');


CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `contraseña` text NOT NULL,
  `correo_electronico` varchar(255) DEFAULT NULL,
  `id_rol` int(11) NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `usuarios` (`id`, `nombre_usuario`, `contraseña`, `correo_electronico`, `id_rol`, `creado_en`, `imagen`) VALUES
(1, 'admin', 'admin123', 'admin@bahamut.local', 3, '2025-06-12 10:55:54', 'admin1.jpeg'),
(2, 'usuario1', 'clave123', 'usuario1@bahamut.local', 1, '2025-06-12 10:55:54', 'usuario1.jpeg'),
(3, 'usuario2', 'clave456', 'usuario2@bahamut.local', 2, '2025-06-12 10:55:54', 'usuario2.jpeg'),
(8, 'jeffersonn', '123', 'jefferson@bahamut.local', 1, '2025-06-13 11:42:13', 'jeffersonn.jpeg'),
(9, 'prueba', '123', 'prueba@bahamut.local', 1, '2025-06-13 12:34:22', 'prueba.jpeg');

ALTER TABLE `credenciales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_maquina` (`id_maquina`);

ALTER TABLE `maquinas`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `permisos_usuarios_maquinas`
  ADD PRIMARY KEY (`id_usuario`,`id_maquina`),
  ADD KEY `id_maquina` (`id_maquina`);

ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD KEY `fk_usuarios_rol` (`id_rol`);

ALTER TABLE `credenciales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `maquinas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;



ALTER TABLE `credenciales`
  ADD CONSTRAINT `credenciales_ibfk_1` FOREIGN KEY (`id_maquina`) REFERENCES `maquinas` (`id`) ON DELETE CASCADE;



ALTER TABLE `permisos_usuarios_maquinas`
  ADD CONSTRAINT `permisos_usuarios_maquinas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permisos_usuarios_maquinas_ibfk_2` FOREIGN KEY (`id_maquina`) REFERENCES `maquinas` (`id`) ON DELETE CASCADE;


ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_rol` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`);
COMMIT;

