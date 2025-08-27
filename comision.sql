-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-01-2024 a las 00:46:40
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `comision`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`) VALUES
(1, 'Comercial'),
(2, 'Redes'),
(3, 'Sistema');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `errores`
--

CREATE TABLE `errores` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `numeroerrores` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `solucionoperativa` text NOT NULL,
  `soluciontecnica` text NOT NULL,
  `poster` varchar(100) NOT NULL,
  `video` varchar(254) NOT NULL,
  `fecha_alta` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `errores`
--

INSERT INTO `errores` (`id`, `id_categoria`, `numeroerrores`, `descripcion`, `solucionoperativa`, `soluciontecnica`, `poster`, `video`, `fecha_alta`) VALUES
(0, 1, '8376', 'ioeruwo', 'euiruw', 'eiorower', 'posters/0_0.jpg,posters/0_1.png,posters/0_2.png', 'posters/0.mp4', '2024-01-29 17:13:56'),
(1, 1, '984923', 'comision', 'se dio a conocer el error de codigo', 'exito', 'posters/1_0.jpg', 'posters/1.mp4', '2023-12-01 23:43:26'),
(2, 2, '10288732', 'dasdasda', 'Sistema erronea ', 'porque', 'posters/2_0.jpg,posters/2_1.jpg', '', '2023-12-05 21:00:36'),
(3, 2, '5433232', 'sdfsfawefa', 'teereqwr', 'yjtyj4tj4y', 'posters/3_0.jpg,posters/3_1.jpg,posters/3_2.png', '', '2023-12-05 21:03:20'),
(4, 2, '10288732', 'jkdajsksaj', 'Sistema erronea ', 'porque', 'posters/4_0.jpg', '', '2023-12-06 20:50:26'),
(5, 3, '3241431', 'sdfasfs', 'asdfa', 'rewtrtw', 'posters/5_0.png', '', '2023-12-07 00:38:09'),
(6, 0, '', '', '', '', '', '', '2023-12-08 08:29:53'),
(7, 2, '834928492', 'Vazquez', 'cksasdkjka', 'kasdka', 'posters/7_0.jpg,posters/7_1.png', '', '2023-12-08 10:00:14'),
(9, 1, '92019', 'sdakjdak', 'dalkla', 'kdkajda', 'posters/9.jpg', '', '2023-12-10 19:53:31'),
(11, 2, '36273642', 'jkjsadaisjdai', 'samantha', 'msdmsuyfuds', 'posters/11_0.png', 'posters/11.mp4', '2023-12-11 08:57:39'),
(12, 3, '89238492', 'jdjfsdfjsdfn', 'mvisdjsd', 'jidisfjsd', 'posters/.jpg', '', '2023-12-11 09:05:29'),
(13, 2, '76745423', 'fgfgrtyradsfdfsd', 'mcsrtertd', 'trufhnvncvxc', 'posters/13.jpg', '', '2023-12-11 09:12:10'),
(14, 1, '123456789', 'No entiendo porque me aparece el error del sistema ', 'Dar una solucion correcta ', 'Verificar el punto o la descripcion ', 'posters/14.jpg', '', '2023-12-18 20:43:01'),
(15, 1, '737373(2', 'Samantha', 'Vazquez ', 'Solucion comprobado', 'posters/15.jpg', '', '2023-12-18 21:04:37'),
(16, 1, '83738383', 'Solucion para verificar ', 'Dyifiyfiyf9', 'Errore', 'posters/16.jpg', '', '2024-01-06 22:32:41'),
(18, 2, '898762', 'fefewrfew', 'Cantidad de errores', 'verificar el error', 'posters/18.jpg', '', '2024-01-08 18:54:15'),
(20, 1, '386386', 'Hidugxitc', 'Gudiyxiy', 'Oufojcojc', 'posters/20.jpg', '', '2024-01-08 20:07:52'),
(21, 1, '8921839123', 'fcdfs', 'Cantidad de errores', 'verificar el error', 'posters/21.jpg', 'posters/21.mp4', '2024-01-10 17:29:02'),
(22, 2, '8298398423', 'jsksdjaksjda', 'jksjdkad', 'dkjsdjaks', 'posters/22.jpg', '', '2024-01-12 11:54:36'),
(23, 3, '8910983', 'kajdksjdw', 'iwiniwe', 'nuuiwuewq', 'posters/23.jpg', '', '2024-01-12 12:24:39'),
(24, 2, '8928492', 'jkadljfs', 'jkdncjsdncka', 'ckdclakj', 'posters/24_0.jpg', '', '2024-01-14 15:48:01'),
(26, 0, '', '', '', '', '', '', '2024-01-15 13:10:43'),
(27, 1, '4234234', 'kjksjdka', ' Estos programas se ejecutan en modo ', 'Solucion tecnica terminado', 'posters/27_0.jpg,posters/27_1.jpg,posters/27_2.jpg,posters/27_3.jpg', 'posters/27.mp4', '2024-01-15 13:11:37'),
(28, 2, '1234553', 'se cambio el codigo', 'verificado', 'El software correctamente', 'posters/28.jpg', 'posters/28.mp4', '2024-01-15 14:39:21'),
(29, 2, '89899', 'hkjhh', 'hchcj', 'vvnvm', 'posters/29_0.jpg', 'posters/29.mp4', '2024-01-18 08:50:20'),
(30, 1, '89899', 'jujiu', 'hchcj', 'vvnvm', '', 'posters/30.mp4', '2024-01-18 09:01:35'),
(31, 0, '', '', '', '', '', '', '2024-01-18 09:07:50'),
(32, 3, '545324', 'fgsdfs', 'ererwert', 'jklssssss', '', 'posters/32.mp4', '2024-01-19 13:18:43'),
(33, 0, '', '', '', '', '', '', '2024-01-19 13:19:42'),
(34, 0, '', '', '', '', '', '', '2024-01-19 13:21:11'),
(35, 2, '879879', 'lasdlasdak', 'nnnnn', 'dddd', '', 'posters/35.mp4', '2024-01-19 13:23:58'),
(36, 2, '98432', 'ioiwoqiq', 'mkdslkdcklds', 'sdjo', '', 'posters/36.mp4', '2024-01-19 13:27:44'),
(37, 2, '98028402', 'jsaldksaja', 'klksla', 'kaksla', '', 'posters/37.mp4', '2024-01-19 13:30:14'),
(38, 1, '98028402', 'ksklklkklalksa', 'klksla', 'kaksla', '', 'posters/38.mp4', '2024-01-19 13:36:17'),
(39, 2, '8978798', 'jhjhkjhk', 'retetetetr', 'ewrwrw', '', 'posters/39.mp4', '2024-01-19 13:39:31'),
(40, 1, '0832092', 'jksajdlkas', 'kldjalsk', 'dlasdjka', '160', 'posters/40.mp4', '2024-01-19 13:50:20'),
(41, 2, '1212321', 'jkjsksjkasa', 'xxhhxuxchxuch', 'ueiwruwierw', '', 'posters/41.mp4', '2024-01-19 14:10:33'),
(42, 0, '', '', '', '', '', '', '2024-01-19 14:15:38'),
(43, 1, '1212321', 'kajskakjska', 'xxhhxuxchxuch', 'ueiwruwierw', '', 'posters/43.mp4', '2024-01-19 14:25:17'),
(44, 3, '3918391', 'jksdjskd', 'kjdskd', 'ksdjksd', '', 'posters/44.mp4', '2024-01-19 14:27:40'),
(45, 2, '3918391', 'sasasasa', 'kjdskd', 'ksdjksd', '', 'posters/45.mp4', '2024-01-19 14:29:26'),
(46, 0, '', '', '', '', '', '', '2024-01-19 14:33:41'),
(47, 0, '', '', '', '', '', '', '2024-01-19 14:37:28'),
(48, 2, '1212321', 'jkjkkjkj', 'xxhhxuxchxuch', 'ueiwruwierw', '', 'posters/48.mp4', '2024-01-19 14:39:53'),
(49, 3, '1212321', 'hjhjhj', 'xxhhxuxchxuch', 'ueiwruwierw', '', 'posters/49.mp4', '2024-01-19 14:42:09'),
(50, 0, '', '', '', '', '', '', '2024-01-19 14:50:55'),
(51, 2, '121238989', 'nmmnmn', 'xxhhxuxchxuch', 'ueiwruwierw', '', 'posters/51.mp4', '2024-01-19 14:52:00'),
(52, 2, '912891', 'sasasasasdas', 'sfsfsd', 'yryrtyrt', '', 'posters/52.mp4', '2024-01-19 14:57:29'),
(53, 3, '912891', 'sasas', 'sfsfsd', 'yryrtyrt', '', 'posters/53.mp4', '2024-01-19 15:00:35'),
(54, 0, '', '', '', '', '', '', '2024-01-19 15:06:45'),
(55, 2, '912891', 'hjk', 'sfsfsd', 'yryrtyrt', '', 'posters/55.mp4', '2024-01-19 15:11:10'),
(56, 1, '912891', 'jhjj', 'sfsfsd', 'yryrtyrt', '', 'posters/56.mp4', '2024-01-19 15:12:52'),
(57, 2, '912891', 'dsdsad', 'sfsfsd', 'yryrtyrt', '', 'posters/57.mp4', '2024-01-19 15:14:35'),
(58, 2, '912891', 'jkjkkj', 'sfsfsd', 'yryrtyrt', '', 'posters/58.mp4', '2024-01-19 15:15:31'),
(59, 2, '912891', 'jljlklkj', 'sfsfsd', 'yryrtyrt', '', 'posters/59.mp4', '2024-01-19 15:16:11'),
(60, 2, '912891', 'klkjoiy', 'sfsfsd', 'yryrtyrt', '', 'posters/60.mp4', '2024-01-19 15:17:21'),
(61, 2, '912891', 'ddsad', 'sfsfsd', 'yryrtyrt', '61.jpg,61.jpg', 'posters/61.mp4', '2024-01-19 15:19:13'),
(62, 3, '91289178', 'jkjkjk', 'sfsfsd', 'yryrtyrt', 'posters/62_0.jpg,posters/62_1.png', 'posters/62.mp4', '2024-01-19 15:21:34'),
(63, 2, '1234567', 'kasjajsd', 'kasdjkas', 'kjsaksjka', 'posters/63_0.jpg,posters/63_1.jpg,posters/63_2.jpg', 'posters/63.mp4', '2024-01-21 22:15:15'),
(64, 0, '', '', '', '', '', '', '2024-01-22 12:45:54'),
(65, 2, '9876544', 'hkjhkhkj', 'sdsdsds', 'fdfdf', 'posters/65_0.png,posters/65_1.jpg,posters/65_2.jpg,posters/65_3.jpg', 'posters/65.mp4', '2024-01-22 12:48:20'),
(66, 3, '889797987675', 'dkjshdkasjhda', 'kdjasdajsk', 'SIasiOAS', 'posters/66_0.jpg,posters/66_1.jpg,posters/66_2.jpg,posters/66_3.jpg,posters/66_4.jpg', 'posters/66.mp4', '2024-01-22 12:52:44'),
(67, 0, '', '', '', '', '', '', '2024-01-22 20:42:22'),
(68, 3, '727123', 'jdajdkas', 'gfdgsfs', 'tyertyedfds', 'posters/68_0.png,posters/68_1.jpg', 'posters/68.mp4', '2024-01-22 20:45:37'),
(69, 2, '1102836', 'Verificase dio el resukta  ', 'No encuentro el error ', 'Codigo ', 'posters/69_0.jpeg,posters/69_1.jpeg', 'posters/69.mp4', '2024-01-25 23:43:05'),
(70, 0, '', '', '', '', '', '', '2024-01-26 13:20:01'),
(71, 1, '98', 'Errores de estructura de archivo', 'Correr recovery', 'Correr programa recoveryen consola', 'posters/71_0.jpg', 'posters/71.mp4', '2024-01-26 13:23:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `rp` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `rol_nivel` varchar(50) NOT NULL,
  `permisos` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `rp`, `nombre`, `password`, `estado`, `rol_nivel`, `permisos`) VALUES
(1, '54321', 'Flores', '123456', 'queretaro', 'Consulta', 'consulta_permission_1,consulta_permission_2'),
(2, '2408', 'Mia', '123456', 'aguascaliente', 'Zona', 'zona_permission_1,zona_permission_2'),
(3, '9876', 'Martin', '1234', 'celaya', 'Administrador', 'admin_permission_1,admin_permission_2'),
(4, '1224', 'karla', '123456', 'queretaro', 'Zona', 'zona_permission_1,zona_permission_2');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `errores`
--
ALTER TABLE `errores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
