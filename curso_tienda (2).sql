-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-01-2024 a las 02:06:33
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `curso_tienda`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE   PROCEDURE `crud` (`nomb_prod` VARCHAR(70), `precio_` DECIMAL(5,2), `id` INT, `opc` CHAR(10))   begin 
declare response varchar(70) default '';
case opc
when 'i' then
start transaction;
set AUTOCOMMIT =0;
insert into producto(nombre_producto,precio)
values(nomb_prod,precio_);
set response = 'Producto registrado';
when 'commit' then
commit;
set response = 'Transacción guardada o confirmada';
else
rollback;
set response = 'transacción revertida';
end case;
select response;
end$$

CREATE   PROCEDURE `proc_consultar` (`id` INT)   begin
select *from producto where id_producto=id;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id_compra` int(11) NOT NULL,
  `transaccion_id` char(25) NOT NULL,
  `fecha_trasnsaccion` datetime NOT NULL,
  `estado` char(30) NOT NULL,
  `email` varchar(80) NOT NULL,
  `cliente` varchar(65) NOT NULL,
  `cliente_id` char(20) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id_compra`, `transaccion_id`, `fecha_trasnsaccion`, `estado`, `email`, `cliente`, `cliente_id`, `id_usuario`) VALUES
(1, '3DA05289F0988525U', '2024-01-21 15:41:12', 'COMPLETED', 'sb-cnelv25193692@personal.example.com', 'John Doe', 'U3GU2X7VA5DZ6', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `id_detalle` int(11) NOT NULL,
  `producto` varchar(60) NOT NULL,
  `precio` decimal(5,2) NOT NULL,
  `cantidad` tinyint(4) NOT NULL,
  `importe` decimal(5,2) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `detalle_compra`
--

INSERT INTO `detalle_compra` (`id_detalle`, `producto`, `precio`, `cantidad`, `importe`, `id_producto`, `id_compra`) VALUES
(1, 'Sistema de Botica', 120.00, 1, 120.00, 112, 1),
(2, 'Sistema de citas médicas', 190.00, 1, 190.00, 107, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(60) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `precio` decimal(5,2) NOT NULL,
  `foto` varchar(180) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre_producto`, `descripcion`, `precio`, `foto`, `deleted_at`) VALUES
(1, 'producto nuevo', 'descripción del producto descripcio', 24.00, '202401090234562983a80c4c66787ec1400512273a7e6fe7288167ca286187a470272d7d346e71.png', '2024-01-09 19:57:53'),
(3, 'Galletas óreo', '', 0.70, NULL, '2024-01-09 19:57:42'),
(7, 'Goseosa Fanta de 3 litros', 'descripcion de gaseosa fanta', 11.70, NULL, '2024-01-17 22:39:55'),
(107, 'Sistema de citas médicas', '', 190.00, '2024011000435741a93332f229c705ea70ee918638f7401a91368127241b6208fafb350455ed3b.png', NULL),
(109, 'prueba el insert', 'descripcion de prueba', 34.67, NULL, '2024-01-09 19:16:22'),
(111, 'Azucar', 'descripción del azucar', 34.00, NULL, '2024-01-08 21:01:58'),
(112, 'Sistema de Botica', '', 120.00, '2024011001580747bb8284ed41b32112540cd0c27e2da115710857eea735a78682a4837fc3c19c.png', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prueba`
--

CREATE TABLE `prueba` (
  `id_prueba` int(11) NOT NULL,
  `nombre_prueba` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre_user` varchar(60) NOT NULL,
  `email` varchar(90) NOT NULL,
  `rol` enum('administrador','cliente') NOT NULL DEFAULT 'cliente',
  `password_` varchar(75) NOT NULL,
  `request_password` tinyint(4) DEFAULT NULL,
  `token_request_password` varchar(200) DEFAULT NULL,
  `token_validate` varchar(200) DEFAULT NULL,
  `codigo_confirm` char(6) CHARACTER SET armscii8 COLLATE armscii8_general_ci DEFAULT NULL,
  `tiempo_expired` int(11) DEFAULT NULL,
  `estado` enum('h','i') NOT NULL DEFAULT 'i'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre_user`, `email`, `rol`, `password_`, `request_password`, `token_request_password`, `token_validate`, `codigo_confirm`, `tiempo_expired`, `estado`) VALUES
(1, 'Fiorella Ivana', 'abelardoadrianrosales@gmail.com', 'administrador', '$2y$10$j8HXXcOrkA5Q5s5l4Efum.aLpZG5vZTaXwlSYoWE5xrfew9ugwGWq', 1, '27f93a0e00b3d6f1af3ed1d44c58b3a57d7c6b8feb1f7368fa39d26be4d892ea', NULL, NULL, 1705629845, 'i'),
(2, 'Abelardo Adrian', 'adriaaanroosales@gmail.com', 'cliente', '$2y$10$aUmYgKdzsCbUSp0yRieE/Ou3Fk3XolAP0LUhjL4uwhh9ZjZSVnNjC', NULL, NULL, NULL, NULL, NULL, 'i');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `fk_COMPRA_USUARIO_idx` (`id_usuario`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `fk_DETALLE_COMPRA_PRODUCTO1_idx` (`id_producto`),
  ADD KEY `fk_DETALLE_COMPRA_COMPRA1_idx` (`id_compra`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `prueba`
--
ALTER TABLE `prueba`
  ADD PRIMARY KEY (`id_prueba`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT de la tabla `prueba`
--
ALTER TABLE `prueba`
  MODIFY `id_prueba` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fk_COMPRA_USUARIO` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `fk_DETALLE_COMPRA_COMPRA1` FOREIGN KEY (`id_compra`) REFERENCES `compra` (`id_compra`),
  ADD CONSTRAINT `fk_DETALLE_COMPRA_PRODUCTO1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
