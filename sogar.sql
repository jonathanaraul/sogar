-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 21-09-2013 a las 19:39:15
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
  `usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2A6A65D2265B05D` (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` text COLLATE utf8_spanish_ci NOT NULL,
  `tipo` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=36 ;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `titulo`, `tipo`) VALUES
(1, 'inicio', 0),
(2, 'organizacion', 0),
(3, 'informacion', 0),
(15, 'slideshow', 2),
(16, 'equipo', 2),
(17, 'Inquietud', 3),
(18, 'Solicitud', 3),
(19, 'FP-01 Solicitud de Afilicación', 1),
(20, 'FP-02 Analisis Solicitud Afiliación', 1),
(21, 'FP-03 Toma de Decisión Solic. Afiliación', 1),
(22, 'FP-04  Afiliación', 1),
(23, 'FP-05 Solicitud de Fianzas', 1),
(24, 'FP-06 Análisis de Solicitud de Fianzas', 1),
(25, 'FP-07 Toma de Decisión de Solic. de Fianzas', 1),
(26, 'FP-08 Constitucion y Otogamiento', 1),
(27, 'FP-09 Seguimiento y Liberación', 1),
(28, 'FP-10 Promoción e Impulso', 1),
(29, 'Queja', 3),
(30, 'Sugerencia', 3),
(31, 'Procesado', 4),
(32, 'En espera', 4),
(33, 'Cancelado', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `data`
--

CREATE TABLE IF NOT EXISTS `data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` int(11) DEFAULT NULL,
  `categoria` int(11) DEFAULT NULL,
  `titulo` text COLLATE utf8_spanish_ci NOT NULL,
  `mensaje` text COLLATE utf8_spanish_ci NOT NULL,
  `adjunto` text COLLATE utf8_spanish_ci,
  `fecha` datetime NOT NULL,
  `habilitado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idcategoria` (`categoria`),
  KEY `IDX_ADF3F3632265B05D` (`usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=22 ;

--
-- Volcado de datos para la tabla `data`
--

INSERT INTO `data` (`id`, `usuario`, `categoria`, `titulo`, `mensaje`, `adjunto`, `fecha`, `habilitado`) VALUES
(1, 1, 16, 'Equipo SNGR', 'Equipo SNGR', '7efe20271ff5607b8ad4aff735cf0ca14644cc4c.jpeg', '2013-09-21 18:31:58', 1),
(2, 1, 16, 'Equipo SNGR', 'Equipo SNGR', '70985c3c6684c373760af3922d43b0c235a524cc.jpeg', '2013-09-21 18:33:15', 1),
(3, 1, 16, 'Equipo SNGR', 'Equipo SNGR', '56f3974793f50bba47cfc10d09b1b87999a57fa9.jpeg', '2013-09-21 18:33:53', 1),
(4, 1, 16, 'Equipo SNGR', 'Equipo SNGR', 'b3663c890e527aaea7336d1d10a4e6b00cb43e89.jpeg', '2013-09-21 18:34:31', 1),
(5, 1, 16, 'Equipo SNGR', 'Equipo SNGR', '14d8525b2ec23806d76ecb51186c087725dd2e10.jpeg', '2013-09-21 18:35:18', 1),
(6, 1, 16, 'Equipo SNGR', 'Equipo SNGR', '9252d2873cb7519321df997d1b9d1d629bcfe5e3.jpeg', '2013-09-21 18:36:04', 1),
(7, 1, 15, 'S1', 's1', 'aa78fc609f67cd6c23589b784e1e02d02c5816a2.jpeg', '2013-09-21 18:51:27', 1),
(8, 1, 15, 's2', 's2', 'c7db0ca59592ef135edb7be507a60649849508ac.jpeg', '2013-09-21 18:52:41', 1),
(9, 1, 15, 's3', 's3', '3bd90ef4ac82a5d68826397f378ad588af11021a.jpeg', '2013-09-21 18:54:09', 1),
(10, 1, 19, 'SNGR-SGC-FP-01', 'Solicitud de Afiliación Ed 00 Rev 13 04 2012', 'f3c41ddad7c9db4cca3afa52d4dce801b246fd5a.pdf', '2013-09-21 18:57:01', 1),
(11, 1, 19, 'F-SNGR-SGC-FP-01-04', 'FT-PJ Rev 02', 'ac53018f6fb2937b7572367b95d5d7ca55f4df09.xls', '2013-09-21 18:58:44', 1),
(12, 1, 19, 'F-SNGR-SGC-FP-01-02', 'FF-PJ Rev 02', 'ad67eaa67cbb19a512f6ce6bcd12a2c2225c87ca.xls', '2013-09-21 19:01:22', 1),
(13, 1, 19, 'F-SNGR-SGC-FP-01-01', 'FF-PN Rev 02', 'f6d74b4bd9fd86d1c22c259c3ed59fe738a6d415.xls', '2013-09-21 19:02:09', 1),
(14, 1, 19, 'F-SNGR-SGC-FP-01-05', 'Solicitud de Afiliación de Socio', '47a8536a36e433859eadab329c780fe987fdaf66.doc', '2013-09-21 19:02:56', 1),
(15, 1, 19, 'F-SNGR-SGC-FP-01-06', 'Planilla de declaración jurada y de origen de fondos', '4fcbc91aa9471c5df6f6239c426af5030cd4559d.doc', '2013-09-21 19:03:50', 1),
(16, 1, 20, 'SNGR-SGC-FP-02', 'Analisis de Solicitud de Afiliación Ed 00 Rev 02', '7e46396a211c8a8ba6a2417158f8efe5e1f570d7.pdf', '2013-09-21 19:06:11', 1),
(17, 1, 20, 'F-SNGR-SGC-FP-02-01', 'Informe Legal de Afiliación', '1f79e0264e6a3f4f97ec92796613b551d63fb90b.doc', '2013-09-21 19:07:10', 1),
(18, 1, 2, 'Estructura Organizativa', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam nec egestas nibh. Sed at rhoncus lectus. Maecenas ligula purus, hendrerit eu eleifend eu, faucibus eget erat. Praesent tempor molestie nisi eget hendrerit. Mauris turpis arcu, rhoncus in interdum sit amet, scelerisque et elit. Maecenas vitae diam feugiat velit mollis auctor. Aliquam tristique nunc ac sapien viverra nec mattis tellus tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam nec egestas nibh. Sed at rhoncus lectus. Maecenas ligula purus, hendrerit eu eleifend eu, faucibus eget erat. Praesent tempor molestie nisi eget hendrerit. Mauris turpis arcu, rhoncus in interdum sit amet, scelerisque et elit. Maecenas vitae diam feugiat velit mollis auctor. Aliquam tristique nunc ac sapien viverra nec mattis tellus tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Nam nec egestas nibh. Sed at rhoncus lectus. Maecenas ligula purus, hendrerit eu eleifend eu, faucibus eget erat. Praesent tempor molestie nisi eget hendrerit. Mauris turpis arcu, rhoncus in interdum sit amet, scelerisque et elit. Maecenas vitae diam feugiat velit mollis auctor. Aliquam tristique nunc ac sapien viverra nec mattis tellus tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Nam nec egestas nibh. Sed at rhoncus lectus. Maecenas ligula purus, hendrerit eu eleifend eu, faucibus eget erat. Praesent tempor molestie nisi eget hendrerit. Mauris turpis arcu, rhoncus in interdum sit amet, scelerisque et elit. Maecenas vitae diam feugiat velit mollis auctor. Aliquam tristique nunc ac sapien viverra nec mattis tellus tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.', 'a7ae8879409c921baf12ac3b447f908c24022eed.jpeg', '2013-09-21 19:14:30', 1),
(19, 1, 2, 'Reseña Histórica', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam nec egestas nibh. Sed at rhoncus lectus. Maecenas ligula purus, hendrerit eu eleifend eu, faucibus eget erat. Praesent tempor molestie nisi eget hendrerit. Mauris turpis arcu, rhoncus in interdum sit amet, scelerisque et elit. Maecenas vitae diam feugiat velit mollis auctor. Aliquam tristique nunc ac sapien viverra nec mattis tellus tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Nam nec egestas nibh. Sed at rhoncus lectus. Maecenas ligula purus, hendrerit eu eleifend eu, faucibus eget erat. Praesent tempor molestie nisi eget hendrerit. Mauris turpis arcu, rhoncus in interdum sit amet, scelerisque et elit. Maecenas vitae diam feugiat velit mollis auctor. Aliquam tristique nunc ac sapien viverra nec mattis tellus tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Nam nec egestas nibh. Sed at rhoncus lectus. Maecenas ligula purus, hendrerit eu eleifend eu, faucibus eget erat. Praesent tempor molestie nisi eget hendrerit. Mauris turpis arcu, rhoncus in interdum sit amet, scelerisque et elit. Maecenas vitae diam feugiat velit mollis auctor. Aliquam tristique nunc ac sapien viverra nec mattis tellus tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.', '021e9333538db96f020ea815d5cec87e43657e1a.jpeg', '2013-09-21 19:18:47', 1),
(21, 1, 3, '¡Estrenamos portal web!', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam nec egestas nibh. Sed at rhoncus lectus. Maecenas ligula purus, hendrerit eu eleifend eu, faucibus eget erat. Praesent tempor molestie nisi eget hendrerit. Mauris turpis arcu, rhoncus in interdum sit amet, scelerisque et elit. Maecenas vitae diam feugiat velit mollis auctor. Aliquam tristique nunc ac sapien viverra nec mattis tellus tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Nam nec egestas nibh. Sed at rhoncus lectus. Maecenas ligula purus, hendrerit eu eleifend eu, faucibus eget erat. Praesent tempor molestie nisi eget hendrerit. Mauris turpis arcu, rhoncus in interdum sit amet, scelerisque et elit. Maecenas vitae diam feugiat velit mollis auctor. Aliquam tristique nunc ac sapien viverra nec mattis tellus tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Nam nec egestas nibh. Sed at rhoncus lectus. Maecenas ligula purus, hendrerit eu eleifend eu, faucibus eget erat. Praesent tempor molestie nisi eget hendrerit. Mauris turpis arcu, rhoncus in interdum sit amet, scelerisque et elit. Maecenas vitae diam feugiat velit mollis auctor. Aliquam tristique nunc ac sapien viverra nec mattis tellus tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.', '2f12360ceffd6df6a3a8463f64f7c3d341d83a33.jpeg', '2013-09-21 19:28:16', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada`
--

CREATE TABLE IF NOT EXISTS `entrada` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` int(11) DEFAULT NULL,
  `nombre` longtext COLLATE utf8_unicode_ci NOT NULL,
  `email` longtext COLLATE utf8_unicode_ci NOT NULL,
  `mensaje` longtext COLLATE utf8_unicode_ci NOT NULL,
  `adjunto` longtext COLLATE utf8_unicode_ci,
  `fecha` datetime NOT NULL,
  `leido` tinyint(1) DEFAULT NULL,
  `respondido` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C949A2744E10122D` (`categoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `entrada`
--

INSERT INTO `entrada` (`id`, `categoria`, `nombre`, `email`, `mensaje`, `adjunto`, `fecha`, `leido`, `respondido`) VALUES
(1, 18, 'Jonathan Araul', 'jonathan.araul@gmail.com', 'Saludos tengo una solicitud con respecto a tal cosa.\r\n\r\nConsectetur adipiscing elit aeneane lorem lipsum, condimentum ultrices consequat eu, vehicula mauris lipsum adipiscing lipsum aenean orci lorem Asequat.\r\n\r\nConsectetur adipiscing elit aeneane lorem lipsum, condimentum ultrices consequat eu, vehicula mauris lipsum adipiscing lipsum aenean orci lorem Asequat.', 'fb23727d008217602672fea2005374f50f427ae6.png', '2013-09-20 16:15:41', 1, 1),
(2, 17, 'Jonathan Araul', 'jonathan.araul@gmail.com', 'Ok gracias a todos', NULL, '2013-09-20 16:16:41', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salida`
--

CREATE TABLE IF NOT EXISTS `salida` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` int(11) DEFAULT NULL,
  `categoria` int(11) DEFAULT NULL,
  `mensaje` longtext COLLATE utf8_unicode_ci NOT NULL,
  `adjunto` longtext COLLATE utf8_unicode_ci,
  `fecha` datetime NOT NULL,
  `visible` tinyint(1) DEFAULT NULL,
  `entrada` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_95F4C7484E10122D` (`categoria`),
  KEY `IDX_95F4C7482265B05D` (`usuario`),
  KEY `IDX_95F4C748C949A274` (`entrada`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `salida`
--

INSERT INTO `salida` (`id`, `usuario`, `categoria`, `mensaje`, `adjunto`, `fecha`, `visible`, `entrada`) VALUES
(1, 1, 32, 'Ok su mensaje ya esta siendo atendido por la gerencia en los proximos dias enviaremos respuesta', NULL, '2013-09-20 00:00:00', 1, 2),
(2, 1, 31, 'Aprobado!', NULL, '2013-09-20 03:00:00', 1, 2),
(4, 1, 31, 'Arrechisimo', '1b6d41b14583bf1edf89aa9b6b03818c66b844a7.txt', '2013-09-21 02:05:50', 1, 2),
(5, 1, 31, 'Ok', 'a49579f77a46898da69300d765a29806c6d8f851.txt', '2013-09-21 02:16:24', 1, 1);

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
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `jerarquia` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2265B05DF85E0677` (`username`),
  UNIQUE KEY `UNIQ_2265B05DE7927C74` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `apellido`, `username`, `salt`, `password`, `email`, `jerarquia`, `is_active`, `path`, `descripcion`) VALUES
(1, 'Jonathan', 'Araul', 'jonathan.araul', '1201fc9b8b0cadc7cd92a67119c106ed', 'b6b6738abaee989151214d358517cb5fe17c5e80', 'jonathan.araul@gmail.com', 1, 1, '9e588602d10f36732d985c42fe7472173027879c.jpeg', 'Todo marcha ok2');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `autores`
--
ALTER TABLE `autores`
  ADD CONSTRAINT `FK_2A6A65D2265B05D` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `data`
--
ALTER TABLE `data`
  ADD CONSTRAINT `data_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`id`),
  ADD CONSTRAINT `FK_ADF3F3632265B05D` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `entrada`
--
ALTER TABLE `entrada`
  ADD CONSTRAINT `FK_C949A2744E10122D` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`id`);

--
-- Filtros para la tabla `salida`
--
ALTER TABLE `salida`
  ADD CONSTRAINT `FK_95F4C7482265B05D` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `FK_95F4C748C949A274` FOREIGN KEY (`entrada`) REFERENCES `entrada` (`id`),
  ADD CONSTRAINT `salida_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
