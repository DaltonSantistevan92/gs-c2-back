-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-10-2021 a las 02:40:12
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_baursa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`, `fecha`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Equipos Frios', '2021-07-09', 'I', '2021-07-09 05:56:11', '2021-07-20 04:47:00'),
(2, 'Equipos Calientes', '2021-07-09', 'I', '2021-07-09 06:06:48', '2021-07-20 04:47:05'),
(6, 'Equipos de linea fria', '2021-07-19', 'A', '2021-07-20 04:46:44', '2021-07-20 04:46:44'),
(7, 'Equipos de linea caliente', '2021-07-19', 'A', '2021-07-20 04:46:53', '2021-07-20 04:46:53'),
(9, 'Prueba', '2021-08-02', 'I', '2021-08-03 04:32:26', '2021-08-03 04:32:26'),
(10, 'Equipos Importados', '2021-08-04', 'A', '2021-08-04 05:43:12', '2021-08-04 05:43:12'),
(11, 'Eventos Infantiles', '2021-08-04', 'A', '2021-08-04 05:55:09', '2021-10-20 21:04:17'),
(13, 'Equipos de Panaderia', '2021-08-05', 'A', '2021-08-06 03:19:08', '2021-08-06 03:19:08'),
(14, 'Equipos de vitrinas', '2021-08-06', 'A', '2021-08-06 15:12:03', '2021-08-06 15:12:03'),
(15, 'Equipos para cafeterias', '2021-08-30', 'A', '2021-08-31 03:18:26', '2021-08-31 03:18:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `persona_id` int(11) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `hora_ingreso` time DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `persona_id`, `fecha_ingreso`, `hora_ingreso`, `estado`, `created_at`, `updated_at`) VALUES
(1, 2, '2021-07-15', '08:07:26', 'A', '2021-07-16 01:49:26', '2021-07-16 01:49:26'),
(2, 3, '2021-08-06', '12:08:00', 'A', '2021-08-06 05:04:00', '2021-08-06 05:04:00'),
(3, 4, '2021-08-06', '12:08:52', 'A', '2021-08-06 05:04:52', '2021-08-06 05:04:52'),
(4, 5, '2021-08-06', '12:08:29', 'A', '2021-08-06 05:05:29', '2021-08-06 05:05:29'),
(5, 6, '2021-08-26', '12:08:05', 'A', '2021-08-26 05:16:05', '2021-08-26 05:16:05'),
(6, 7, '2021-08-26', '12:08:02', 'A', '2021-08-26 05:17:02', '2021-08-26 05:17:02'),
(7, 8, '2021-08-26', '12:08:57', 'A', '2021-08-26 05:17:57', '2021-08-26 05:17:57'),
(8, 9, '2021-08-26', '12:08:11', 'A', '2021-08-26 05:20:11', '2021-08-26 05:20:11'),
(9, 10, '2021-08-26', '12:08:13', 'A', '2021-08-26 05:22:13', '2021-08-26 05:22:13'),
(10, 11, '2021-08-26', '12:08:56', 'A', '2021-08-26 05:23:56', '2021-10-21 03:03:11'),
(11, 12, '2021-08-26', '12:08:06', 'A', '2021-08-26 05:25:06', '2021-08-26 05:25:06'),
(12, 13, '2021-08-26', '12:08:43', 'A', '2021-08-26 05:26:43', '2021-08-26 05:26:43'),
(13, 14, '2021-08-26', '12:08:21', 'A', '2021-08-26 05:29:21', '2021-08-26 05:29:21'),
(14, 15, '2021-08-26', '12:08:47', 'A', '2021-08-26 05:30:47', '2021-08-26 05:30:47'),
(15, 16, '2021-08-30', '10:08:45', 'A', '2021-08-31 03:27:45', '2021-08-31 03:27:45'),
(16, 17, '2021-09-01', '12:09:18', 'A', '2021-09-01 05:21:18', '2021-09-01 05:21:18'),
(17, 18, '2021-09-01', '12:09:18', 'A', '2021-09-01 05:26:18', '2021-09-01 05:26:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `proveedor_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `serie_documento` varchar(255) DEFAULT NULL,
  `descuento` float DEFAULT NULL,
  `sub_total` float DEFAULT NULL,
  `iva` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `proveedor_id`, `usuario_id`, `serie_documento`, `descuento`, `sub_total`, `iva`, `total`, `fecha_compra`, `estado`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '0001', 0, 241, 28.92, 269.92, '2021-08-04', 'A', '2021-08-04 05:15:52', '2021-08-04 05:15:52'),
(9, 4, 1, '0002', 0, 300, 36, 336, '2021-08-21', 'A', '2021-08-21 18:24:05', '2021-08-21 18:24:05'),
(10, 4, 1, '0003', 0, 120, 14.4, 134.4, '2021-08-21', 'A', '2021-08-21 18:28:42', '2021-08-21 18:28:42'),
(12, 1, 1, '0004', 0, 1322, 158.64, 1480.64, '2021-08-26', 'A', '2021-08-26 06:14:30', '2021-08-26 06:14:30'),
(13, 7, 1, '0005', 0, 178.25, 21.39, 199.64, '2021-08-26', 'A', '2021-08-27 01:13:50', '2021-08-27 01:13:50'),
(14, 7, 1, '0006', 0, 7202, 864.24, 8066.24, '2021-08-30', 'A', '2021-08-31 03:26:17', '2021-08-31 03:26:17'),
(15, 7, 1, '0007', 0, 1291.5, 154.98, 1446.48, '2021-09-01', 'A', '2021-09-01 05:15:39', '2021-09-01 05:15:39'),
(16, 1, 1, '0008', 0, 3735.6, 448.27, 4183.87, '2021-09-01', 'A', '2021-09-01 07:25:24', '2021-09-01 07:25:24'),
(17, 6, 1, '0009', 0, 2461.5, 295.38, 2756.88, '2021-09-01', 'A', '2021-09-01 07:26:20', '2021-09-01 07:26:20'),
(18, 6, 1, '0010', 0, 2868.9, 344.27, 3213.17, '2021-09-01', 'A', '2021-09-02 04:14:39', '2021-09-02 04:14:39'),
(19, 5, 1, '0011', 0, 706.5, 84.78, 791.28, '2021-09-02', 'A', '2021-09-02 06:19:13', '2021-09-02 06:19:13'),
(20, 5, 1, '0012', 0, 1362, 163.44, 1525.44, '2021-09-03', 'A', '2021-09-03 08:50:12', '2021-09-03 08:50:12'),
(21, 6, 1, '0013', 0, 1300.4, 156.05, 1456.45, '2021-09-03', 'A', '2021-09-03 08:53:19', '2021-09-03 08:53:19'),
(22, 4, 1, '0014', 0, 2500.68, 300.08, 2800.76, '2021-09-03', 'A', '2021-09-03 09:56:23', '2021-09-03 09:56:23'),
(23, 1, 1, '0015', 0, 440.34, 52.84, 493.18, '2021-09-03', 'A', '2021-09-03 10:01:45', '2021-09-03 10:01:45'),
(24, 6, 1, '0016', 0, 1360.7, 163.28, 1523.98, '2021-10-01', 'A', '2021-10-02 01:18:44', '2021-10-02 01:18:44'),
(25, 4, 1, '2155', 0, 1202.6, 144.31, 1346.91, '2021-10-20', 'A', '2021-10-20 19:58:53', '2021-10-20 19:58:53'),
(26, 7, 1, '5562', 0, 2500, 300, 2800, '2021-10-20', 'A', '2021-10-20 20:04:47', '2021-10-20 20:04:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `id` int(11) NOT NULL,
  `compra_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_compra` float DEFAULT NULL,
  `total` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_compra`
--

INSERT INTO `detalle_compra` (`id`, `compra_id`, `producto_id`, `cantidad`, `precio_compra`, `total`) VALUES
(1, 1, 5, 2, 120.5, 241),
(9, 9, 54, 2, 150, 300),
(10, 10, 41, 1, 120, 120),
(12, 12, 32, 4, 330.5, 1322),
(13, 13, 32, 1, 178.25, 178.25),
(14, 14, 58, 4, 1800.5, 7202),
(15, 15, 6, 3, 430.5, 1291.5),
(16, 16, 28, 3, 1245.2, 3735.6),
(17, 17, 10, 3, 820.5, 2461.5),
(18, 18, 13, 3, 956.3, 2868.9),
(19, 19, 21, 3, 235.5, 706.5),
(20, 20, 46, 4, 340.5, 1362),
(21, 21, 35, 2, 650.2, 1300.4),
(22, 22, 55, 2, 1250.34, 2500.68),
(23, 23, 55, 1, 440.34, 440.34),
(24, 24, 53, 2, 680.35, 1360.7),
(25, 25, 47, 10, 120.26, 1202.6),
(26, 26, 47, 10, 250, 2500);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `id` int(11) NOT NULL,
  `venta_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_venta` float DEFAULT NULL,
  `total` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`id`, `venta_id`, `producto_id`, `cantidad`, `precio_venta`, `total`) VALUES
(4, 8, 40, 3, 200.5, 601.5),
(5, 9, 53, 2, 804, 1608),
(6, 10, 53, 1, 804, 804),
(7, 11, 48, 1, 1666, 1666),
(8, 12, 48, 3, 1666, 4998),
(9, 13, 53, 2, 804, 1608),
(10, 14, 58, 1, 2.26, 2.26),
(11, 15, 5, 1, 199.99, 199.99),
(12, 16, 54, 3, 772, 2316),
(13, 17, 58, 1, 2.26, 2.26),
(14, 18, 54, 2, 772, 1544),
(15, 19, 48, 1, 1666, 1666),
(16, 20, 32, 1, 182.99, 182.99),
(17, 21, 13, 1, 350, 350),
(18, 22, 21, 1, 449, 449),
(19, 23, 15, 1, 1550, 1550),
(20, 24, 46, 1, 1600, 1600),
(21, 25, 54, 1, 772, 772),
(22, 26, 10, 1, 199, 199),
(23, 27, 47, 5, 3400, 17000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `id_seccion` int(11) DEFAULT NULL,
  `menu` varchar(100) DEFAULT NULL,
  `icono` varchar(100) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `pos` int(2) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`id`, `id_seccion`, `menu`, `icono`, `url`, `pos`, `estado`) VALUES
(1, 0, 'Inicio', 'nav-icon fas fa-tachometer-alt', 'inicio', 0, 'A'),
(2, 0, 'Usuarios', 'fas fa-user-friends', 'usuario', 2, 'A'),
(3, 0, 'Clientes', 'fas fa-user-alt', 'cliente', 3, 'A'),
(4, 1, 'Dashboard', '#', 'inicio/administrador', 0, 'A'),
(5, 1, 'Dashboard Bodeguero', '#', 'inicio/bodeguero', 1, 'A'),
(6, 1, 'Dashboard Vendedor', '#', 'inicio/vendedor', 2, 'A'),
(7, 2, 'Nuevo Usuario', '#', 'usuario/nuevo', 0, 'A'),
(8, 2, 'Listar Usuarios', '#', 'usuario/listar', 1, 'A'),
(9, 3, 'Nuevo Cliente', '#', 'cliente/nuevo', 0, 'A'),
(10, 3, 'Listar Cliente', '#', 'cliente/listar', 1, 'A'),
(11, 0, 'Compras', 'fas fa-cart-arrow-down', 'compra', 6, 'A'),
(12, 0, 'Ventas', 'fas fa-dollar-sign', 'venta', 7, 'A'),
(13, 11, 'Nueva Compra', '#', 'compra/nueva', 0, 'A'),
(14, 11, 'Listar Compra', '#', 'compra/listar', 1, 'A'),
(15, 12, 'Nueva Venta', '#', 'venta/nueva', 0, 'A'),
(16, 12, 'Listar Venta', '#', 'venta/listar', 1, 'A'),
(17, 0, 'Productos', 'fab fa-product-hunt', 'producto', 4, 'A'),
(18, 17, 'Nuevo Producto', '#', 'producto/nuevo', 0, 'A'),
(19, 17, 'Listar Producto', '#', 'producto/listar', 1, 'A'),
(20, 17, 'Categoria', '#', 'producto/categoria', 2, 'A'),
(21, 0, 'Proveedores', 'far fa-address-book', 'proveedor', 5, 'A'),
(22, 21, 'Nuevo Proveedor', '#', 'proveedor/nuevo', 0, 'A'),
(23, 21, 'Listar Prooveedor', '#', 'proveedor/listar', 1, 'A'),
(24, 0, 'Reportes', 'fas fa-swatchbook', 'reportes', 8, 'A'),
(25, 24, 'Compras Mensuales', '#', 'reporte/compra ', 0, 'A'),
(26, 24, 'Ventas Mensuales', '#', 'reporte/venta', 1, 'A'),
(27, 0, 'Proyecciones', 'fas fa-chart-line', 'proyeccion', 9, 'A'),
(28, 27, 'Compras', '#', 'proyeccion/compra', 0, 'A'),
(29, 27, 'Ventas', '#', 'proyeccion/venta', 1, 'A'),
(30, 24, 'Productos más vendidos ', '#', 'reporte/repuestos', 2, 'A'),
(31, 24, 'Productos más comprados', '#', 'reporte/comprados', 3, 'A'),
(32, 0, 'Seguridad', 'fas fa-user-lock', 'seguridad', 1, 'A'),
(33, 32, 'Permisos', '#', 'seguridad/permiso', 0, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `acceso` char(1) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `rol_id`, `menu_id`, `acceso`, `estado`) VALUES
(1, 1, 1, 'S', 'A'),
(2, 1, 2, 'S', 'A'),
(3, 1, 3, 'S', 'A'),
(4, 1, 4, 'S', 'A'),
(5, 1, 7, 'S', 'A'),
(6, 1, 8, 'S', 'A'),
(7, 1, 9, 'S', 'A'),
(8, 1, 10, 'S', 'A'),
(9, 1, 11, 'S', 'A'),
(10, 1, 12, 'S', 'A'),
(11, 1, 13, 'S', 'A'),
(12, 1, 14, 'S', 'A'),
(13, 1, 15, 'S', 'A'),
(14, 1, 16, 'S', 'A'),
(15, 1, 17, 'S', 'A'),
(16, 1, 18, 'S', 'A'),
(17, 1, 19, 'S', 'A'),
(18, 1, 20, 'S', 'A'),
(19, 1, 21, 'S', 'A'),
(20, 1, 22, 'S', 'A'),
(21, 1, 23, 'S', 'A'),
(22, 1, 24, 'S', 'A'),
(23, 1, 25, 'S', 'A'),
(24, 1, 26, 'S', 'A'),
(25, 1, 27, 'S', 'A'),
(26, 1, 28, 'S', 'A'),
(27, 1, 29, 'S', 'A'),
(28, 1, 30, 'S', 'A'),
(29, 1, 31, 'S', 'A'),
(30, 2, 21, 'S', 'A'),
(31, 2, 11, 'S', 'A'),
(32, 2, 24, 'S', 'A'),
(33, 2, 25, 'S', 'A'),
(34, 2, 31, 'S', 'A'),
(35, 2, 1, 'S', 'A'),
(36, 2, 5, 'S', 'A'),
(37, 2, 22, 'S', 'A'),
(38, 2, 23, 'S', 'A'),
(39, 2, 13, 'S', 'A'),
(40, 2, 14, 'S', 'A'),
(41, 2, 17, 'S', 'A'),
(42, 2, 18, 'S', 'A'),
(43, 2, 19, 'S', 'A'),
(45, 3, 1, 'S', 'A'),
(46, 3, 6, 'S', 'A'),
(47, 3, 3, 'S', 'A'),
(48, 3, 9, 'S', 'A'),
(49, 3, 10, 'S', 'A'),
(50, 3, 12, 'S', 'A'),
(51, 3, 15, 'S', 'A'),
(52, 3, 16, 'S', 'A'),
(53, 3, 24, 'S', 'A'),
(54, 3, 26, 'S', 'A'),
(55, 3, 30, 'S', 'A'),
(56, 3, 27, 'S', 'A'),
(57, 3, 29, 'S', 'A'),
(58, 2, 27, NULL, NULL),
(59, 2, 28, 'S', 'A'),
(60, 1, 32, 'S', 'A'),
(61, 1, 33, 'S', 'A'),
(62, 2, 20, 'S', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id` int(11) NOT NULL,
  `cedula` varchar(10) DEFAULT NULL,
  `nombres` varchar(100) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `cedula`, `nombres`, `apellidos`, `telefono`, `correo`, `direccion`, `estado`, `created_at`, `updated_at`) VALUES
(1, '0909391211', 'Gabriela', 'Salinas', '0000000000', 'gaby@gmail.com', 'Guayaquil', 'A', '2021-07-09 00:19:56', '2021-07-09 00:19:56'),
(2, '0917385288', 'Gabriel', 'Sanchez', '0984532156', 'gabriel@gmail.com', 'Salinas', 'A', '2021-07-16 01:49:26', '2021-07-16 01:49:26'),
(3, '2450202003', 'Victor', 'Salinas', '0925002959', 'victor-salinas@hotmail.com', 'Barrio San Gregorio', 'A', '2021-08-06 05:03:59', '2021-08-06 05:03:59'),
(4, '0918333949', 'Gardenia', 'Tomala', '0994567660', 'gtomalar@gmail.com', 'Santa Elena', 'A', '2021-08-06 05:04:52', '2021-08-06 05:04:52'),
(5, '0915915789', 'Danilo', 'Manrique', '0986592287', 'vida-sama@gmail.com', 'La Libertad', 'A', '2021-08-06 05:05:29', '2021-08-06 05:05:29'),
(6, '0928313345', 'Angie', 'Asencio', '0985533626', 'angie-kada@outlook.com', 'Chanduy', 'A', '2021-08-26 05:16:05', '2021-08-26 05:16:05'),
(7, '2450640566', 'Noelia', 'Rodriguez', '0939628911', 'noe_yagual@hotmail.com', 'Santa Elena', 'A', '2021-08-26 05:17:02', '2021-08-26 05:17:02'),
(8, '2450202011', 'Gabriela', 'Salinas', '0962548452', 'salinas-gaby@hotmail.com', 'Santa Elena', 'A', '2021-08-26 05:17:57', '2021-08-26 05:17:57'),
(9, '2400160830', 'Mariela', 'Salinas', '0959197555', 'mariela-salinas@hotmail.com', 'Santa Elena', 'A', '2021-08-26 05:20:11', '2021-08-26 05:20:11'),
(10, '0914456918', 'Francisco', 'Manrique', '0982346793', 'francisco-man@gmail.com', 'La Libertad', 'A', '2021-08-26 05:22:13', '2021-08-26 05:22:13'),
(11, '0924127152', 'Franklin', 'Murrieta', '0982136512', 'F_murrieta@outlook.com', 'Guayaquil', 'A', '2021-08-26 05:23:56', '2021-10-21 03:15:39'),
(12, '0921327490', 'Mariuxi', 'Murrietaa', '0923456432', 'Mariu_murrieta@hotmail.com', 'Muey', 'A', '2021-08-26 05:25:06', '2021-10-21 03:16:13'),
(13, '0913983581', 'Sandra', 'Reyes', '0821457892', 'sandra.reyes80@htomail.com', 'Santa Elena', 'A', '2021-08-26 05:26:43', '2021-08-26 05:26:43'),
(14, '2450245309', 'Ginger', 'Chancay', '0987653478', 'gingercb@hotmail.com', 'Salinas', 'A', '2021-08-26 05:29:21', '2021-08-26 05:29:21'),
(15, '0951578665', 'Elias', 'Cuesta', '0983457289', 'Elias-vera98@hotmail.com', 'Guayaquil', 'A', '2021-08-26 05:30:47', '2021-08-26 05:30:47'),
(16, '2450104514', 'Carlos', 'Ortega', '0934578922', 'carlos_orteg19@gmail.com', 'Guayaquil', 'A', '2021-08-31 03:27:45', '2021-08-31 03:27:45'),
(17, '0930287768', 'Fernando', 'Herrera', '0997363678', 'fer_herrera99@hotmail.com', 'Santa Elena', 'A', '2021-09-01 05:21:17', '2021-09-01 05:21:17'),
(18, '2450502003', 'Isaac', 'Salinas ', '0997383299', 'isa_sal@hotmail.com', 'Santa Elena', 'A', '2021-09-01 05:26:18', '2021-09-01 05:26:18'),
(19, '2450087958', 'Pedro', 'Panchana', '0985455565', 'pedro@gmail.com', 'Salinas', 'A', '2021-10-21 18:51:39', '2021-10-21 18:51:39'),
(20, '0928168327', 'Burro', 'Hourse', '0984561563', 'burro@gmail.com', 'Guayaquil', 'A', '2021-10-21 19:17:00', '2021-10-21 20:04:07'),
(21, '2450169988', 'Prueba', 'Apwpwpw', '0986526523', 'prueba@gmail.com', 'Quito', 'A', '2021-10-21 19:21:47', '2021-10-21 19:21:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `codigo` varchar(10) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `precio_compra` double DEFAULT NULL,
  `precio_venta` double DEFAULT NULL,
  `margen` double DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `categoria_id`, `codigo`, `nombre`, `img`, `descripcion`, `stock`, `precio_compra`, `precio_venta`, `margen`, `fecha`, `estado`, `created_at`, `updated_at`) VALUES
(5, 7, '0001', 'Campana Extractora', 'CAMPANAEXTRACTORA.jpg', '', 1, 120.5, 199.99, 79.49, '2021-07-19', 'A', '2021-07-20 04:49:20', '2021-08-31 19:43:55'),
(6, 7, '0002', 'Cocina de lujo', 'COCINADELUJO.jpg', '', 3, 430.5, 1699, 1268.5, '2021-07-17', 'A', '2021-07-20 04:50:05', '2021-09-01 05:15:39'),
(7, 7, '0003', 'Cocina sodabar', 'COCINASODABAR.jpg', '', 0, 0, 1300, 1300, '2021-07-19', 'A', '2021-07-20 04:50:53', '2021-08-03 04:43:42'),
(8, 7, '0004', 'Cocina Multifuncional', 'COMIDAMULTIFUNCIONAL.jpg', '4 Quemadores\nPlancha Desmontable\n2 Freidoras Imperiales\n1,30x0,85x0,90', 0, 0, 250, 250, '2021-07-19', 'A', '2021-07-20 04:51:42', '2021-07-20 04:51:42'),
(9, 7, '0005', 'Exhibidores de comida', 'EXHIBIDORESDECOMIDA.jpg', '1,80x0,70x1,80', 0, 0, 990, 990, '2021-07-19', 'A', '2021-07-20 04:52:24', '2021-07-20 04:52:24'),
(10, 7, '0006', 'Freidora', 'FREIDORA.jpg', '', 2, 820.5, 199, -621.5, '2021-07-19', 'A', '2021-07-20 04:53:02', '2021-10-13 19:55:54'),
(11, 7, '0007', 'Isla congelante', 'ISLACONGELANTE.jpg', '', 0, 0, 2100, 2100, '2021-07-19', 'A', '2021-07-20 04:53:43', '2021-08-03 04:43:42'),
(12, 7, '0008', 'Lavadero Industrial', 'LAVADEROINDUSTRIAL.jpg', '130m', 0, 0, 300, 300, '2021-07-19', 'A', '2021-07-20 04:54:29', '2021-07-20 04:54:29'),
(13, 7, '0009', 'Locker', 'LOCKER.jpg', '8 comparticiones', 2, 956.3, 350, -606.3, '2021-07-19', 'A', '2021-07-20 04:55:15', '2021-09-02 04:15:24'),
(14, 7, '0010', 'Mesa Auxiliar de Trabajo', 'MESAAUXILIARDETRABAJO.jpg', '', 0, 0, 220, 220, '2021-07-19', 'A', '2021-07-20 04:56:21', '2021-07-20 04:56:21'),
(15, 7, '0011', 'Mesa de servicio', 'MESADESERVICIO.jpg', '', 2, 1000, 1550, 550, '2021-07-19', 'A', '2021-07-20 04:58:27', '2021-09-03 08:51:32'),
(16, 7, '0012', 'Mesa fria - bajo mesón', 'MESAFRIABAJOMESON.jpg', '', 0, 0, 1200, 1200, '2021-07-19', 'A', '2021-07-20 05:00:23', '2021-07-20 05:00:23'),
(17, 7, '0013', 'Mesa para salsa y aderezos', 'MESAPARASALSASYADEREZOS.jpg', '', 0, 0, 220, 220, '2021-07-19', 'A', '2021-07-20 05:01:04', '2021-07-20 05:01:04'),
(18, 7, '0014', 'Mesa Refrigerante', 'MESAREFRIGERANTE.jpg', '', 0, 0, 1250, 1250, '2021-07-20', 'A', '2021-07-20 05:01:56', '2021-07-20 05:01:56'),
(19, 6, '0015', 'Mesa Yogurtera', 'MesaYogurtera.jpg', '', 0, 0, 850, 850, '2021-07-20', 'A', '2021-07-20 05:03:11', '2021-07-20 05:03:11'),
(20, 7, '0016', 'Mesa fria con mueble de despacho', 'MESAFRIACONMUEBLEDEDESPACHO.jpg', '', 0, 0, 1600, 1600, '2021-07-20', 'A', '2021-07-20 05:03:54', '2021-07-20 05:03:54'),
(21, 7, '0017', 'Molino de Pan', 'MOLINODEPAN.jpg', '', 2, 235.5, 449, 213.5, '2021-07-20', 'A', '2021-07-20 05:04:39', '2021-09-02 06:19:53'),
(22, 7, '0018', 'Sierra cortadora de hueso', 'SIERRACORTADORADEHUESO.jpg', '', 0, 0, 680, 680, '2021-07-20', 'A', '2021-07-20 05:06:12', '2021-07-20 05:06:12'),
(23, 6, '0019', 'Vitrina exhibidor de postres', 'CAFETERAS.jpg', '', 0, 0, 1550, 1550, '2021-07-20', 'A', '2021-07-20 05:10:24', '2021-07-20 05:10:24'),
(24, 6, '0020', 'Calentador de papas y pollo broster', 'CALENTADORDEAPASYPOLLOBROSTER.jpg', '', 0, 0, 151, 151, '2021-07-20', 'A', '2021-07-20 05:11:20', '2021-07-20 05:11:20'),
(25, 6, '0021', 'Carreta vitrina para exhibición', 'CARRETAVITRINAPARAEXHIBICION.jpg', '', 0, 0, 353, 353, '2021-07-20', 'A', '2021-07-20 05:12:08', '2021-07-20 05:12:08'),
(26, 6, '0022', 'Carreta', 'CARRETAS.jpg', '', 0, 0, 299, 299, '2021-07-20', 'A', '2021-07-20 05:13:05', '2021-08-03 04:07:45'),
(27, 6, '0023', 'Exhibidores de fritada ', 'EXHIBIDORESDEFRITADA.jpg', '', 0, 0, 179, 179, '2021-07-20', 'A', '2021-07-20 05:14:06', '2021-07-20 05:14:06'),
(28, 6, '0025', 'Exhibidores de pastelerias', 'FABRICANTESDEPASTELERAS.jpg', '', 3, 1245.2, 860, -385.2, '2021-07-19', 'A', '2021-07-20 05:19:22', '2021-09-01 07:25:25'),
(29, 6, '0026', 'Frigorificos', 'FRIGORIFICOS.jpg', '', 0, 0, 300.99, 300.99, '2021-07-20', 'A', '2021-07-20 05:20:09', '2021-07-20 05:20:09'),
(30, 6, '0027', 'Horno turbo a convección', 'HORNOTURBOACONVECCION.jpg', '', 0, 0, 1650, 1650, '2021-07-20', 'A', '2021-07-20 05:21:15', '2021-07-20 05:21:15'),
(31, 7, '0028', 'Molino de Carne', 'MOLINODECARNE.jpg', '', 0, 0, 449, 449, '2021-07-20', 'A', '2021-07-20 05:22:13', '2021-07-20 05:22:13'),
(32, 6, '0029', 'Procesador de alimentos', 'procesadordealimentos.jpg', '', 4, 178.25, 182.99, 4.74, '2021-07-20', 'A', '2021-07-20 05:22:52', '2021-09-01 07:22:48'),
(33, 6, '0030', 'Rayadora Industrial', 'RAYDORAINDUSTRIAL.jpg', '', 0, 0, 125.99, 125.99, '2021-07-20', 'A', '2021-07-20 05:23:33', '2021-07-20 05:23:33'),
(34, 6, '0031', 'Vertical Mixto ', 'VERTICALMIXTO3PUERTAS.jpg', 'VERTICAL MIXTO 3 PUERTAS\nCOMPARTIMIENTO PARA LEGUMBRES\nCOMPARTIMIENTO PARA CARNES ????????????????\nO MARISCOS', 0, 0, 1899, 1899, '2021-07-20', 'A', '2021-07-20 05:24:26', '2021-07-20 05:24:26'),
(35, 6, '0032', 'Vitrina para pan', 'VITRINADEPAN.jpg', '', 2, 650.2, 690.99, 40.79, '2021-07-20', 'A', '2021-07-20 05:25:03', '2021-09-03 08:53:19'),
(36, 6, '0033', 'Vitrina para Sushi', 'VITRINAPARASUSHI.jpg', '', 0, 0, 960.5, 960.5, '2021-07-20', 'A', '2021-07-20 05:25:41', '2021-07-20 05:25:41'),
(40, 9, '0095', 'Prueba Producto', 'ZahevO.jpg', 'hola prueba', 12, 80.5, 200.5, 120, '2021-08-02', 'A', '2021-08-03 04:34:58', '2021-08-26 06:09:16'),
(41, 10, '0024', 'Cafetera Industrial', 'Maquina-de-Expresso-Breville-1-289x300.jpg', '', 1, 120, 2185, 2065, '2021-08-04', 'A', '2021-08-04 05:44:55', '2021-08-21 18:28:50'),
(42, 10, '0038', 'Olla Arrocera Industrial', 'olla-arrocera-industrial-y-algo-mas-4768518z0-16575446.jpg', '', 0, 0, 1700.5, 1700.5, '2021-08-04', 'A', '2021-08-04 05:46:21', '2021-08-04 05:46:21'),
(43, 10, '0041', 'Tostadora Industrial', 'tostadora-industrial-29258728z0-13291967.jpg', '', 0, 0, 999, 999, '2021-08-04', 'A', '2021-08-04 05:46:59', '2021-08-04 05:46:59'),
(44, 10, '0043', 'Juguera Metvisa', 'unnamed.jpg', '', 0, 0, 1880, 1880, '2021-08-04', 'A', '2021-08-04 05:48:07', '2021-08-04 05:48:07'),
(45, 11, '0055', 'Máquina para algodon de azucar', 'MAQ-DE-ALGODON-AZUCAR-MESA1.png', '', 0, 0, 255, 255, '2021-08-04', 'A', '2021-08-04 05:56:52', '2021-08-04 05:56:52'),
(46, 11, '0067', 'Maquinas para Hot Dog\'s', 'sta-35ssa.lg.jpg', '', 3, 340.5, 1600, 1259.5, '2021-08-04', 'A', '2021-08-04 05:57:52', '2021-09-03 09:51:39'),
(47, 11, '0076', 'Máquinas para churros', '517IrFuN15L._AC_SY679_.jpg', '', 15, 250, 3400, 3150, '2021-08-04', 'A', '2021-08-04 05:59:35', '2021-10-20 20:05:56'),
(48, 11, '0098', 'Juguera', '2.jpg', '', 2, 1200.2, 1666, 465.8, '2021-08-04', 'A', '2021-08-04 06:00:24', '2021-09-01 05:18:08'),
(52, 13, '0923', 'Panaderia', '141_1.jpg', '', 16, 250, 980, 730, '2021-08-05', 'A', '2021-08-06 03:21:41', '2021-08-06 04:59:10'),
(53, 13, '0000', 'Batidora', 'batidora-industrial-de-10L-marca-Exhibir-Equipos-2.jpg', 'Batidora de 10, 20, 30 Litros', 15, 680.35, 804, 123.65, '2021-08-05', 'A', '2021-08-06 04:51:49', '2021-10-02 01:18:44'),
(54, 13, '00345', 'Amasadora', 'amasadora.jpg', '', 20, 150, 772, 622, '2021-08-06', 'A', '2021-08-06 14:54:25', '2021-10-02 01:22:22'),
(55, 14, '0208', 'Vitrina para Pasteleras', 'vitrina-pastelera-12-mts.jpg', '', 10, 440.34, 960, 519.66, '2021-08-06', 'A', '2021-08-06 15:21:42', '2021-09-03 10:01:45'),
(57, 14, '0056', 'Vitrina', '141_1.jpg', '', 0, 0, 9500, 9500, '2021-07-23', 'A', '2021-08-26 06:07:54', '2021-08-26 06:07:54'),
(58, 15, '0050', 'Maquina Express', 'Maquina-de-Expresso-Breville-1-289x300.jpg', 'Calderas de agua desde 6 hasta 14 litros', 2, 1800.5, 2.26, -1798.24, '2021-08-30', 'A', '2021-08-31 03:23:06', '2021-08-31 19:45:08'),
(59, 15, '0068', 'Cafetera', 'maquina-para-cafe-automatica.jpg', '', 0, 0, 2230.5, 2230.5, '2021-09-01', 'A', '2021-09-01 05:14:16', '2021-09-01 05:14:16'),
(60, 10, '0924', 'Plancha', '15941440_1524633117547645_5523975686166210634_n.png', '', 0, 0, 630.25, 630.25, '2021-09-03', 'A', '2021-09-03 09:13:20', '2021-09-03 09:13:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `ruc` varchar(13) DEFAULT NULL,
  `razon_social` varchar(200) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `ruc`, `razon_social`, `direccion`, `correo`, `fecha`, `telefono`, `estado`, `created_at`, `updated_at`) VALUES
(1, '2323243243243', 'ElectroHertz', 'Guayas', 'electro@gmail.com', '2021-07-12', '0365447852', 'A', '2021-07-12 17:45:07', '2021-07-12 17:45:07'),
(2, '5261515651561', 'Agro', 'Quito', 'agroficial@gmail.com', '2021-07-12', '0987452123', 'A', '2021-07-12 17:49:05', '2021-10-20 20:45:00'),
(3, '1236578912346', 'ChillerAndrade', 'Peru', 'chile@gmail.com', '2021-07-12', '9999999999', 'A', '2021-07-12 17:58:14', '2021-10-20 20:42:57'),
(4, '1717502023001', 'Herrera Fundiciones', 'SANTO DOMINGO DE LOS TSACHILAS/ SANTO DOMINGO/ RIO VERDE\n', 'representaciones_herrera@outlook.com', '2021-08-04', '0942176762', 'A', '2021-08-05 02:05:34', '2021-10-20 20:15:40'),
(5, '1791770722001', 'Dtmedical', 'Guayaquil', 'info@dtmedical.com.ec', '2021-08-26', '0932398556', 'A', '2021-08-26 06:20:32', '2021-08-26 06:20:32'),
(6, ' 099257380500', 'FRITEGA.S.A', 'Av. Juan Tanca Marengo, km. 6.5, Frente al Colegio Americano \nECUADOR', 'info@veritrade-ltd.com', '2021-08-26', '0525130110', 'A', '2021-08-26 06:24:45', '2021-08-26 06:24:45'),
(7, '1791321413001', 'ADEUCARPI CIA .LTDA.', 'RIO COCA E8-32 Y AV. DE LOS SHYRIS', 'ventas1@adeucarpi.com.ec', '2021-08-26', '096959 689', 'A', '2021-08-26 06:30:58', '2021-08-26 06:30:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `cargo` varchar(100) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `cargo`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 'A', '2021-07-09 00:11:34', '2021-07-09 00:11:34'),
(2, 'Bodeguero', 'A', '2021-07-09 00:17:54', '2021-07-09 00:17:54'),
(3, 'Vendedor', 'A', '2021-07-09 00:17:54', '2021-07-09 00:17:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `persona_id` int(11) DEFAULT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `img` varchar(250) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `conf_clave` varchar(255) DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `persona_id`, `rol_id`, `usuario`, `img`, `clave`, `conf_clave`, `estado`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'gaby', 'default.jpg', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'A', '2021-07-09 00:21:56', '2021-07-09 00:21:56'),
(2, 19, 2, 'pedro', 'user-default.jpg', 'ee5cd7d5d96c8874117891b2c92a036f96918e66c102bc698ae77542c186f981', 'ee5cd7d5d96c8874117891b2c92a036f96918e66c102bc698ae77542c186f981', 'A', '2021-10-21 18:51:39', '2021-10-21 18:51:39'),
(3, 20, 3, 'Burrito', 'user-default.jpg', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'A', '2021-10-21 19:17:00', '2021-10-21 20:06:17'),
(4, 21, 1, 'prueba', 'user-default.jpg', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'A', '2021-10-21 19:21:49', '2021-10-21 19:21:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `serie` varchar(20) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `subtotal` float DEFAULT NULL,
  `iva` float DEFAULT NULL,
  `descuento_efectivo` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `fecha_venta` date DEFAULT NULL,
  `hora_venta` time DEFAULT NULL,
  `estado` char(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `serie`, `usuario_id`, `cliente_id`, `subtotal`, `iva`, `descuento_efectivo`, `total`, `fecha_venta`, `hora_venta`, `estado`, `created_at`, `updated_at`) VALUES
(8, '0001', 1, 2, 601.5, 72.18, 0, 673.68, '2021-08-26', '01:09:16', 'A', '2021-08-26 06:09:16', '2021-08-26 06:09:16'),
(9, '0002', 1, 3, 1608, 192.96, 0, 1800.96, '2021-08-26', '01:15:43', 'A', '2021-08-26 06:15:43', '2021-08-26 06:15:43'),
(10, '0003', 1, 5, 804, 96.48, 0, 900.48, '2021-08-26', '01:16:47', 'A', '2021-08-26 06:16:47', '2021-08-26 06:16:47'),
(11, '0008', 1, 5, 1666, 199.92, 0, 1865.92, '2021-08-26', '20:15:06', 'A', '2021-08-27 01:15:06', '2021-08-27 01:15:06'),
(12, '0006', 1, 6, 4998, 599.76, 0, 5597.76, '2021-08-27', '00:07:52', 'A', '2021-08-27 05:07:52', '2021-08-27 05:07:52'),
(13, '0004', 1, 10, 1608, 192.96, 0, 1800.96, '2021-08-29', '15:14:36', 'A', '2021-08-29 20:14:37', '2021-08-29 20:14:37'),
(14, '0007', 1, 15, 2.26, 0.27, 0, 2.53, '2021-08-30', '22:29:05', 'A', '2021-08-31 03:29:05', '2021-08-31 03:29:05'),
(15, '00123', 1, 3, 199.99, 24, 0, 223.99, '2021-08-31', '14:43:54', 'A', '2021-08-31 19:43:55', '2021-08-31 19:43:55'),
(16, '0005', 1, 3, 2316, 277.92, 0, 2593.92, '2021-08-31', '14:44:29', 'A', '2021-08-31 19:44:29', '2021-08-31 19:44:29'),
(17, '0009', 1, 4, 2.26, 0.27, 0, 2.53, '2021-08-31', '14:45:08', 'A', '2021-08-31 19:45:08', '2021-08-31 19:45:08'),
(18, '0000', 1, 5, 1544, 185.28, 0, 1729.28, '2021-09-01', '00:00:34', 'A', '2021-09-01 05:00:40', '2021-09-01 05:00:40'),
(19, '0010', 1, 7, 1666, 199.92, 0, 1865.92, '2021-09-01', '00:18:01', 'A', '2021-09-01 05:18:07', '2021-09-01 05:18:07'),
(20, '00021', 1, 7, 182.99, 21.96, 0, 204.95, '2021-09-01', '02:22:47', 'A', '2021-09-01 07:22:47', '2021-09-01 07:22:47'),
(21, '0022', 1, 5, 350, 42, 0, 392, '2021-09-01', '23:15:22', 'A', '2021-09-02 04:15:23', '2021-09-02 04:15:23'),
(22, '0023', 1, 4, 449, 53.88, 0, 502.88, '2021-09-02', '01:19:53', 'A', '2021-09-02 06:19:53', '2021-09-02 06:19:53'),
(23, '0011', 1, 12, 1550, 186, 0, 1736, '2021-09-03', '03:51:32', 'A', '2021-09-03 08:51:32', '2021-09-03 08:51:32'),
(24, '0024', 1, 9, 1600, 192, 0, 1792, '2021-09-03', '04:51:39', 'A', '2021-09-03 09:51:39', '2021-09-03 09:51:39'),
(25, '0025', 1, 3, 772, 92.64, 0, 864.64, '2021-10-01', '20:22:22', 'A', '2021-10-02 01:22:22', '2021-10-02 01:22:22'),
(26, '0026', 1, 8, 199, 23.88, 0, 222.88, '2021-10-13', '14:55:54', 'A', '2021-10-13 19:55:54', '2021-10-13 19:55:54'),
(27, '0325', 1, 8, 17000, 2040, 0, 19040, '2021-10-20', '15:05:56', 'A', '2021-10-20 20:05:56', '2021-10-20 20:05:56');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cliente_persona` (`persona_id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_compras_proveedores` (`proveedor_id`),
  ADD KEY `fk_compras_usuarios` (`usuario_id`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detalle_compra` (`compra_id`),
  ADD KEY `fk_detalle_producto` (`producto_id`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detalle_venta` (`venta_id`),
  ADD KEY `fk_detalle_productos` (`producto_id`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_permisos_menus` (`menu_id`),
  ADD KEY `fk_permisos_roles` (`rol_id`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_productos_categorias` (`categoria_id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `fk_usuarios_personas` (`persona_id`),
  ADD KEY `fk_usuarios_roles` (`rol_id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ventas_usuarios` (`usuario_id`),
  ADD KEY `fk_ventas_clientes` (`cliente_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_cliente_persona` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`);

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `fk_compras_proveedores` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`),
  ADD CONSTRAINT `fk_compras_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `fk_detalle_compra` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`),
  ADD CONSTRAINT `fk_detalle_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `fk_detalle_productos` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `fk_detalle_venta` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`);

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `fk_permisos_menus` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`),
  ADD CONSTRAINT `fk_permisos_roles` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_categorias` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_personas` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_ventas_clientes` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `fk_ventas_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;