-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 16-09-2013 a las 02:23:02
-- Versión del servidor: 5.5.16
-- Versión de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `sogar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autores`
--

CREATE TABLE IF NOT EXISTS `autores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2A6A65D8D93D649` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `autores`
--

INSERT INTO `autores` (`id`, `user`) VALUES
(2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` text COLLATE utf8_spanish_ci NOT NULL,
  `tipo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=19 ;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `titulo`, `tipo`) VALUES
(1, 'inicio', 0),
(2, 'organizacion', 0),
(3, 'mensaje', 0),
(5, 'FP-09 Seguimiento y Liberación', 1),
(6, 'FP-10 Promoción e Impulso', 1),
(7, 'FP-06 Análisis de Solicitud de Fianzas', 1),
(8, 'FP-07 Toma de Decisión de Solic. de Fianza', 1),
(9, 'FP-08 Constitucion y Otogamiento', 1),
(10, 'FP-02 Analisis Solicitud Afiliación', 1),
(11, 'FP-03 Toma de Decisión Solic. Afiliación', 1),
(12, 'FP-04  Afiliación', 1),
(13, 'FP-05 Solicitud de Fianzas', 1),
(14, 'FP-01 Solicitud de Afilicación', 1),
(15, 'slideshow', 2),
(16, 'equipo', 2),
(17, 'Urgente', 3),
(18, 'Solicitud', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `data`
--

CREATE TABLE IF NOT EXISTS `data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `categoria` int(11) NOT NULL,
  `titulo` text COLLATE utf8_spanish_ci NOT NULL,
  `mensaje` text COLLATE utf8_spanish_ci NOT NULL,
  `adjunto` text COLLATE utf8_spanish_ci,
  `fecha` datetime NOT NULL,
  `habilitado` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `idcategoria` (`categoria`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `data`
--

INSERT INTO `data` (`id`, `user`, `categoria`, `titulo`, `mensaje`, `adjunto`, `fecha`, `habilitado`) VALUES
(12, 1, 16, 'prueba', 'fds', '6246e5a3e2fecf1ae326357d5d4b3b31776bc3b8.jpeg', '2013-09-16 02:05:20', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

CREATE TABLE IF NOT EXISTS `respuesta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sistema`
--

CREATE TABLE IF NOT EXISTS `sistema` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `descripcioncorta` longtext COLLATE utf8_unicode_ci NOT NULL,
  `descripcionlarga` longtext COLLATE utf8_unicode_ci NOT NULL,
  `acercade` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `sistema`
--

INSERT INTO `sistema` (`id`, `nombre`, `version`, `descripcioncorta`, `descripcionlarga`, `acercade`) VALUES
(1, 'SNGR', 'V.1.0', 'Sociedad Nacional de Garantias Reciprocas', 'Un portal desarrollado con el objetivo de proporcionar una plataforma tecnologica para la organizacion S.N.G.R.', 'Desarrollado por la bachiller Adriana');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `sexo` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `nombre`, `apellido`, `username`, `salt`, `password`, `email`, `sexo`, `is_active`, `path`, `descripcion`) VALUES
(1, 'jonathan', 'araul', 'Jonathan.araul', 'e1508464552a0178374563db109a450f', '8c09316865a0145de4f3a4a0cacd52e189582c07', 'Jonthan.araul@gmail.com', 0, 1, 'avatars/jonathan-araul.jpg', '&lt;p&gt;&lt;span class=\\&quot;text-success\\&quot;&gt;Web And Mobile Developer&lt;/span&gt;&lt;/p&gt; Con 5 \n\na&Atilde;&plusmn;os de experiencia. Creando mi propio camino, fundador de Zona de \n\nSistemas, ODU Monagas, Veninsoftware e Hispano Soluciones. &lt;a \n\nhref=\\&quot;https://twitter.com/jonathan_araul\\&quot; target=\\&quot;_blank\\&quot;&gt;Sigueme en 140 \n\ncaracteres&lt;/a&gt;.'),
(2, 'juan', 'juan', 'juan', '35cb17ec8a82d4c93cdce0cf6b351113', '182ee7097663032c2df87042a13d24041484796e', 'juan@gmail.com', 0, 1, 'images/avatar-man.png', 'soy juan');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `autores`
--
ALTER TABLE `autores`
  ADD CONSTRAINT `FK_2A6A65D8D93D649` FOREIGN KEY (`user`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `data`
--
ALTER TABLE `data`
  ADD CONSTRAINT `data_ibfk_2` FOREIGN KEY (`user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `data_ibfk_3` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`id`);

--
-- Filtros para la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD CONSTRAINT `respuesta_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
