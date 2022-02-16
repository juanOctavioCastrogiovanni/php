-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-02-2022 a las 16:07:53
-- Versión del servidor: 10.1.34-MariaDB
-- Versión de PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `comercioit`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `idCategoria` int(11) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `Hijo_de` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idCategoria`, `Nombre`, `Hijo_de`) VALUES
(1, 'PC', 0),
(2, 'Smartphone', 0),
(3, 'Tablets', 0),
(4, 'Accesorios', 1),
(5, 'Cargadores', 2),
(6, 'Notebooks', 0),
(7, 'Fundas', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `idMarca` int(11) NOT NULL,
  `Nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`idMarca`, `Nombre`) VALUES
(1, 'Apple'),
(2, 'Samsung'),
(3, 'Huawei'),
(4, 'LG'),
(5, 'Motorola'),
(6, 'Google'),
(7, 'Asus'),
(8, 'ZTE'),
(9, 'Nokia'),
(10, 'Lenovo'),
(11, 'PlayStation'),
(12, 'Ninendo'),
(13, 'Microsoft'),
(14, 'TCL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` int(11) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `Precio` double NOT NULL,
  `Marca` int(11) NOT NULL,
  `Categoria` int(11) NOT NULL,
  `Presentacion` varchar(30) NOT NULL,
  `Stock` int(6) NOT NULL,
  `imagen` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `Nombre`, `Precio`, `Marca`, `Categoria`, `Presentacion`, `Stock`, `imagen`) VALUES
(1, 'iPhone 6', 499.99, 1, 2, '16GB', 500, NULL),
(2, 'iPad Pro', 599.99, 1, 3, '32GB', 300, NULL),
(3, 'Nexus 7', 299.99, 6, 3, '32GB', 300, NULL),
(4, 'Galaxy S7', 459.9, 2, 2, '64GB', 650, NULL),
(5, 'Moto G', 489.99, 5, 2, '8GB', 750, NULL),
(6, 'L40', 199.69, 4, 2, '24GB', 350, NULL),
(8, 'IPHONE X', 31231, 1, 2, '123GB', 13213, NULL),
(21, '', 0, 2, 3, '', 0, '82cd2365fb500a3f95f862a77205efd6d361d774');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `Apellido` varchar(30) NOT NULL,
  `Email` varchar(20) NOT NULL,
  `Pass` text NOT NULL,
  `Activacion` text NOT NULL,
  `Estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `Nombre`, `Apellido`, `Email`, `Pass`, `Activacion`, `Estado`) VALUES
(1, 'Pedro', 'El escamoso', 'pedroelEscamoso@yaho', '$2y$10$jg8x0SoMOpfRgxBwd2nMZeaBkMNAEgc6qUg8N22c.BTR5UlPD6zWu', 'G9484', 0),
(4, 'Pedro', 'El escamoso', 'pedroelEscamoso@sdf', '$2y$10$jg8x0SoMOpfRgxBwd2nMZeaBkMNAEgc6qUg8N22c.BTR5UlPD6zWu', 'G9484', 1),
(5, 'Pedro', 'El escamoso', 'peasdf@asdf.com', '$2y$10$jg8x0SoMOpfRgxBwd2nMZeaBkMNAEgc6qUg8N22c.BTR5UlPD6zWu', 'G9484', 1),
(6, 'Pedro', 'El escamoso', 'asdfasdf@yahoo.com', '$2y$10$PfsO/Rf1l3Fup6huOAiQ6eYd.b64wrLv4kYgQw8u8zVy8RwJ3U/M.', 'P5482', 0),
(7, 'asdfa', 'sdfasdf', 'asdfa', '$2y$10$I9rbkdljQZUmqV3wEAPKB.NVf3KQvGJ1mBfAGQd8lWhtNUCcUVdyG', 'X4776', 0),
(8, 'asdfa', 'sdfasdf', 'qwer3', '$2y$10$S7GTEfpwWSCamMeoDG8fbu1Pf8SNZspPjkezbddS/M6w40u.NEup6', 'R4936', 0),
(9, 'fasdfasd', 'fasdfasdf', 'wertncvnb', '$2y$10$7AMHmemZ8vlulFGxg1VIDuN9mam5XcrY/GpePKUxoUncfaUd.wIrm', 'O3267', 0),
(10, 'sdfgsdfg', 'dfgsdfgsdf', '34tgzsd', '$2y$10$ULA.G4T0NfeDWAgSTeJRc.l.J8OboEGHzbCni/.2w7lxVHxChfCdq', 'U1327', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`idMarca`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `Marca` (`Marca`),
  ADD KEY `Rubro` (`Categoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `idMarca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`Marca`) REFERENCES `marcas` (`idMarca`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`Categoria`) REFERENCES `categorias` (`idCategoria`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
