-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 27-06-2011 a las 23:53:51
-- Versión del servidor: 5.5.8
-- Versión de PHP: 5.3.5

--
-- Ahora con Grupo
--
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `pinf`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuerpo`
--

CREATE TABLE IF NOT EXISTS `cuerpo` (
  `ID` varchar(8) NOT NULL,
  `contenido` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `cuerpo`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `esamigo`
--

CREATE TABLE IF NOT EXISTS `esamigo` (
  `usuarioA` varchar(20) NOT NULL,
  `usuarioB` varchar(20) NOT NULL,
  PRIMARY KEY (`usuarioA`,`usuarioB`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `esamigo`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE IF NOT EXISTS `grupo` (
  `ID` varchar(8) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `id_lider` varchar(20) NOT NULL,
  `id_muro` varchar(8) NOT NULL,
  `descripcion` text NOT NULL,
  `num_gusta` int(10) unsigned NOT NULL,
  `num_nogusta` int(10) unsigned NOT NULL,
  `num_miembros` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla de Grupo';

--
-- Volcar la base de datos para la tabla `grupo`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `muro`
--

CREATE TABLE IF NOT EXISTS `muro` (
  `ID` varchar(8) NOT NULL,
  `Num_Max_Publicaciones` int(10) unsigned NOT NULL,
  `Num_Publicaciones` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `muro`
--

INSERT INTO `muro` (`ID`, `Num_Max_Publicaciones`, `Num_Publicaciones`) VALUES
('M001', 100, 0),
('M002', 100, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia`
--

CREATE TABLE IF NOT EXISTS `noticia` (
  `ID` varchar(8) NOT NULL,
  `titulo` varchar(128) NOT NULL,
  `autor` varchar(40) NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` text NOT NULL,
  `num_gusta` int(10) unsigned NOT NULL,
  `num_nogusta` int(10) unsigned NOT NULL,
  `ID_Cuerpo` int(10) unsigned NOT NULL,
  `ID_Muro` int(10) unsigned NOT NULL,
  `ID_Admin` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `noticia`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE IF NOT EXISTS `perfil` (
  `usuario` varchar(20) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(50) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `Seguridad_ID` int(10) unsigned,
  `Muro_ID` int(10) unsigned,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(20) NOT NULL,
  `es_Admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`usuario`, `password`, `email`, `fechaNacimiento`, `Seguridad_ID`, `Muro_ID`, `nombre`, `apellido`, `es_Admin`) VALUES
('DebugAdmin', 'julia', 'sho@shomail.com', '0000-00-00', 0, 0, 'Juls', 'Mec', 1),
('DebugUser', 'mandi', 'shonnyMan@shomail.com', '0000-00-00', 0, 1, 'Yang', 'Ying', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguridad`
--

CREATE TABLE IF NOT EXISTS `seguridad` (
  `ID` int(10) unsigned NOT NULL,
  `preguntaSecreta` varchar(128) NOT NULL,
  `respuestaSecreta` varchar(32) NOT NULL,
  `privac_Fotos` tinyint(1) NOT NULL,
  `privac_Muro` tinyint(1) NOT NULL,
  `privac_Datos` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `seguridad`
--

INSERT INTO `seguridad` (`ID`, `preguntaSecreta`, `respuestaSecreta`, `privac_Fotos`, `privac_Muro`, `privac_Datos`) VALUES
(0, 'yoyo?', 'no yoyo', 1, 1, 1),
(1, 'yoyo?', 'no yoyo', 1, 1, 1);
