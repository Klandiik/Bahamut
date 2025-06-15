
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-06-2025 a las 13:52:51
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12
CREATE DATABASE bahamut;
USE bahamut;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bahamut`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `credenciales`
--

CREATE TABLE `credenciales` (
  `id` int(11) NOT NULL,
  `id_maquina` int(11) NOT NULL,
  `usuario_maquina` varchar(100) NOT NULL,
  `contraseña` text NOT NULL,
  `creada_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `credenciales`
--

INSERT INTO `credenciales` (`id`, `id_maquina`, `usuario_maquina`, `contraseña`, `creada_en`) VALUES
(1, 1, 'Administrador', 'TiFor22!!', '2025-06-14 13:27:04'),
(2, 2, '\r\nAdministrador', 'TiFor21!!', '2025-06-14 13:27:04'),
(3, 3, 'Administrador', 'Clave00', '2025-06-14 13:27:04'),
(4, 4, 'virgintelco', 'virgen123', '2025-06-14 13:27:04'),
(6, 6, 'administrador', 'Clave00', '2025-06-14 18:14:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maquinas`
--

CREATE TABLE `maquinas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion_ip` varchar(45) NOT NULL,
  `puerto` int(11) NOT NULL DEFAULT 22,
  `descripcion` text DEFAULT NULL,
  `creada_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `maquinas`
--

INSERT INTO `maquinas` (`id`, `nombre`, `direccion_ip`, `puerto`, `descripcion`, `creada_en`) VALUES
(0, 'sin asignar', '0.0.0.0', 0, 'Sin asignar', '2025-06-13 08:41:03'),
(1, 'SERVER-SV-TITFOR', '192.168.0.35', 3389, 'Maquina de DNS Secundario', '2025-06-14 13:27:04'),
(2, 'SERVER-AD-TITFOR', '192.168.0.36', 3389, 'Servidor de Active Directory y DNS Principal', '2025-06-14 13:27:04'),
(3, 'SERVER-WEB', '192.168.0.34', 3389, 'Servidor Web', '2025-06-14 13:27:04'),
(4, 'virg-serv-1', '192.168.0.37', 3389, 'Maquina cliente empresa Virgintelco', '2025-06-14 13:27:04'),
(6, 'servidorweb', '192.168.0.38', 22, 'Maquina DMZ, configuración de iptables', '2025-06-14 17:21:53'),
(7, 'sin asignar', '0.0.0.0', 22, 'Sin asignar', '2025-06-14 17:21:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_usuarios_maquinas`
--

CREATE TABLE `permisos_usuarios_maquinas` (
  `id_usuario` int(11) NOT NULL,
  `id_maquina` int(11) NOT NULL,
  `nivel_permiso` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos_usuarios_maquinas`
--

INSERT INTO `permisos_usuarios_maquinas` (`id_usuario`, `id_maquina`, `nivel_permiso`) VALUES
(1, 1, 'administrar'),
(1, 2, 'administrar'),
(1, 3, 'administrar'),
(1, 4, 'administrar'),
(1, 6, 'administrar'),
(2, 2, 'conectar'),
(2, 3, 'ver_credenciales'),
(3, 1, 'conectar'),
(3, 2, 'conectar'),
(3, 3, 'conectar'),
(3, 4, 'conectar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `descripcion`) VALUES
(1, 'usuario', 'Usuario normal con acceso limitado'),
(2, 'usuario_permisos', 'Usuario con acceso a sus credenciales'),
(3, 'administrador', 'Acceso total a todo el sistema');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `contraseña` text NOT NULL,
  `correo_electronico` varchar(255) DEFAULT NULL,
  `id_rol` int(11) NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_usuario`, `contraseña`, `correo_electronico`, `id_rol`, `creado_en`, `imagen`) VALUES
(1, 'admin', 'admin123', 'admin@bahamut.local', 3, '2025-06-14 13:27:04', 'admin1.jpeg'),
(2, 'usuario1', 'clave123', 'usuario1@bahamut.local', 1, '2025-06-14 13:27:04', 'usuario1.jpeg'),
(3, 'usuario2', 'clave456', 'usuario2@bahamut.local', 2, '2025-06-14 13:27:04', 'usuario2.jpeg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `credenciales`
--
ALTER TABLE `credenciales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_maquina` (`id_maquina`);

--
-- Indices de la tabla `maquinas`
--
ALTER TABLE `maquinas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisos_usuarios_maquinas`
--
ALTER TABLE `permisos_usuarios_maquinas`
  ADD PRIMARY KEY (`id_usuario`,`id_maquina`),
  ADD KEY `id_maquina` (`id_maquina`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD KEY `fk_usuarios_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `credenciales`
--
ALTER TABLE `credenciales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `maquinas`
--
ALTER TABLE `maquinas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `credenciales`
--
ALTER TABLE `credenciales`
  ADD CONSTRAINT `credenciales_ibfk_1` FOREIGN KEY (`id_maquina`) REFERENCES `maquinas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `permisos_usuarios_maquinas`
--
ALTER TABLE `permisos_usuarios_maquinas`
  ADD CONSTRAINT `permisos_usuarios_maquinas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permisos_usuarios_maquinas_ibfk_2` FOREIGN KEY (`id_maquina`) REFERENCES `maquinas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_rol` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
