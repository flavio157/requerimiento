-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-08-2021 a las 19:55:00
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `reclamo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_reclamo`
--

CREATE TABLE `t_reclamo` (
  `ID` int(11) NOT NULL,
  `RUC` char(11) NOT NULL,
  `IDENTIFICACION` char(10) NOT NULL,
  `NRO_RECLAMO` char(9) NOT NULL,
  `FECH_RECLAMO` date NOT NULL DEFAULT current_timestamp(),
  `NOM_CONSUMIDOR` varchar(100) NOT NULL,
  `DIR_CONSUMIDOR` varchar(100) NOT NULL,
  `DNI` char(8) NOT NULL,
  `CEDULA` char(12) NOT NULL,
  `TELEFONO` decimal(11,0) NOT NULL,
  `CORREO` varchar(100) NOT NULL,
  `NOM_PADRES` varchar(100) NOT NULL,
  `PRODUCTO` varchar(50) NOT NULL,
  `SERVICIO` char(1) NOT NULL,
  `MONTO_RECLAMO` decimal(7,2) NOT NULL,
  `DESCRIPCION` varchar(200) NOT NULL,
  `RECLAMO` char(1) NOT NULL,
  `QUEJA` char(1) NOT NULL,
  `DETALLE` varchar(200) NOT NULL,
  `PEDIDO` varchar(200) NOT NULL,
  `FECH_RESPUESTA` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `t_reclamo`
--

INSERT INTO `t_reclamo` (`ID`, `RUC`, `IDENTIFICACION`, `NRO_RECLAMO`, `FECH_RECLAMO`, `NOM_CONSUMIDOR`, `DIR_CONSUMIDOR`, `DNI`, `CEDULA`, `TELEFONO`, `CORREO`, `NOM_PADRES`, `PRODUCTO`, `SERVICIO`, `MONTO_RECLAMO`, `DESCRIPCION`, `RECLAMO`, `QUEJA`, `DETALLE`, `PEDIDO`, `FECH_RESPUESTA`) VALUES
(12, '78978979789', '', '000000001', '0000-00-00', 'nombre', 'domicilio', '78975497', '', '9898989889', '', '', 'pro', 's', '99999.99', 'des', '1', '', 'dead', 'ewwe', '0000-00-00'),
(13, '23234324324', '', '000000002', '0000-00-00', 'asda', 'asd', '70785845', '', '98989898', '', '', 's', 's', '512.00', 'asdasd', '1', '', 'asd', 'asd', '0000-00-00'),
(20, '78978979', '', '000000006', '2021-08-21', 'dsdad', 'dsdssd', '23232323', '', '98989898', '', '', 'prodi', 's', '150.00', 'descripvoi', '', '2', 'sdasdasd', 'asdasd', '2007-12-15'),
(21, '78978979', '', '000000006', '2007-05-12', 'dsdad', 'dsdssd', '23232323', '', '98989898', '', '', 'prodi', 's', '150.00', 'descripvoi', '', '2', 'sdasdasd', 'asdasd', '2007-12-15'),
(30, '23232323232', '2', '000000007', '2021-08-21', 'adasd', 'asdasd', '23232323', '', '98989898', '', '', 'asdasd', 's', '232.00', 'asdasd', '1', '', 'asdasd', 'asdasd', '2021-12-15'),
(31, '12323232323', '2', '000000008', '2021-08-21', 'asdasd', 'asd', '23131231', '', '98989898', '', '', 'sd', 's', '231.00', 'asdasd', '1', '', 'asdas', 'dasdasd', '2021-12-15');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `t_reclamo`
--
ALTER TABLE `t_reclamo`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `t_reclamo`
--
ALTER TABLE `t_reclamo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
