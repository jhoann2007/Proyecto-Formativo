-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-06-2025 a las 20:46:00
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mydb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE `actividad` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centroformacion`
--

CREATE TABLE `centroformacion` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `centroformacion`
--

INSERT INTO `centroformacion` (`id`, `nombre`) VALUES
(1, 'cpic');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `controlprogreso`
--

CREATE TABLE `controlprogreso` (
  `id` int(10) UNSIGNED NOT NULL,
  `fechaRealizacion` date NOT NULL,
  `peso` decimal(10,0) DEFAULT NULL,
  `cintura` decimal(10,0) DEFAULT NULL,
  `cadera` decimal(10,0) DEFAULT NULL,
  `musloDerecho` decimal(10,0) DEFAULT NULL,
  `musloIsquierdo` decimal(10,0) DEFAULT NULL,
  `brazoDerecho` decimal(10,0) DEFAULT NULL,
  `brazoIzquierdo` decimal(10,0) DEFAULT NULL,
  `antebrazoDerecho` decimal(10,0) DEFAULT NULL,
  `antebrazoIzquierdo` decimal(10,0) DEFAULT NULL,
  `pantorrillaDerecha` decimal(10,0) DEFAULT NULL,
  `pantorrillaIzquierda` decimal(10,0) DEFAULT NULL,
  `examenMedico` varchar(255) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `fechaExamen` date DEFAULT NULL,
  `fkIdUsuario` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicios`
--

CREATE TABLE `ejercicios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `video` varchar(255) NOT NULL,
  `fkIdGrupomuscular` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ejercicios`
--

INSERT INTO `ejercicios` (`id`, `nombre`, `video`, `fkIdGrupomuscular`) VALUES
(29, 'Flexiones', 'https://fitcron.com/wp-content/uploads/2021/03/06621301-Push-up-m_Chest-FIX_720.gif', 1),
(30, 'Banco_Plano', 'https://i.pinimg.com/originals/f2/3b/e9/f23be9a08d0cfa3b40edaaad0f29dff93.gif', 1),
(31, 'Banco_Inclinado', '', 1),
(32, 'Aperturas', 'https://fitnessprogramer.com/wp-content/uploads/2021/02/Incline-dumbbell-Fly.gif', 1),
(33, 'Pullover', 'https://i.pinimg.com/originals/d2/43/1a/d2431a33e8619902629d58ecee73c454.gif', 1),
(34, 'Mariposa_Canina_Pecho', 'https://newlife.com.cy/wp-content/uploads/2019/11/03081301-Dumbbell-Fly_Chest-FIX_360.gif', 1),
(35, 'Apertura_Cross_Over', 'https://i.pinimg.com/originals/a8/62/8f/a8628f044d98a0dc3e7750e47148e4de.gif', 1),
(36, 'Flexion de Biceps con barra', 'https://realidadfitness.com/wp-content/uploads/2023/07/CURL-CON-BARRA-PARADO-GIF.gif', 1),
(37, 'Predicador', 'https://media.tenor.com/m2Dfyh507FQAAAAM/8preacher-curl.gif', 1),
(38, 'Concentrado', 'https://realidadfitness.com/wp-content/uploads/2023/07/CURL-DE-CONCENTRACION-GIF.gif', 1),
(39, 'Dominadas Cerradas', '', 1),
(40, 'Martillo', 'https://boxlifemagazine.com/wp-content/uploads//2023/06/curl-haltere-prise-neutre-5.gif', 1),
(41, 'Curl barra cross over', 'https://cdn.shopify.com/s/files/1/0618/9462/3460/files/cable-curls.gif?v=1741771141', 1),
(42, 'Press Frances (Rompecocos)', '', 1),
(43, 'Fondos en dos bancos', '', 1),
(44, 'Fondos en paralela', 'https://fitcron.com/wp-content/uploads/2021/03/08141301-Triceps-Dip_Upper-Arms_720.gif', 1),
(45, 'Patada atras mancuernas', 'https://i.pinimg.com/originals/f1/b6/16/f1b616965d2583544602ffc922e99e5a.gif', 1),
(46, 'Copa dos manos', '', 1),
(47, 'Press polea atras cross over', 'https://fitcron.com/wp-content/uploads/2021/04/17241301-Cable-Rope-High-Pulley-Overhead-Tricep-Extension_Upper-Arms_720.gif', 1),
(48, 'Press polea barra', 'https://www.thingys.com.ar/gymapps/tutorial/7c9218fc52e8256003159658198439e2.gif', 1),
(49, 'Rodillo de cuerda', '', 1),
(50, 'Supino flexion con barra', 'https://cdn.shopify.com/s/files/1/0425/7667/4983/files/FOTOS_BLOG_INSIDE_39a19406-d81a-4691-bb55-f7a04ad07bb3.gif?v=1713255025', 1),
(51, 'Prono flexion con barra', 'https://fitcron.com/wp-content/uploads/2021/04/01101301-Barbell-Standing-Reverse-Grip-Curl_Forearms_720.gif', 1),
(52, 'Elevacion pierna atras', 'https://fitcron.com/wp-content/uploads/2021/04/03331301-Dumbbell-Kickback_Upper-Arms_720.gif', 1),
(53, 'Elevacion lateral mancuerna', 'https://fitcron.com/wp-content/uploads/2021/04/03341301-Dumbbell-Lateral-Raise_shoulder-AFIX_720.gif', 1),
(54, 'Extencion atrás mancuerna', 'https://fitcron.com/wp-content/uploads/2021/04/17301301-Dumbbell-Seated-Bent-Over-Alternate-Kickback_Upper-Arms_720.gif', 1),
(55, 'Subir elevación pierna atras', 'https://fitcron.com/wp-content/uploads/2021/04/05821301-Lever-Kneeling-Leg-Curl-plate-loaded_Thighs_720.gif', 1),
(56, 'Hip Thrust', 'https://i.pinimg.com/originals/f9/65/95/f96595d8990e81472452ab65ae227ff8.gif', 1),
(57, 'Cross over abductores', 'https://fitcron.com/wp-content/uploads/2021/04/30481301-Cable-hip-abduction-version-2-male_Hips_720.gif', 1),
(58, 'Elevación lateral de pie', 'https://fitcron.com/wp-content/uploads/2021/04/38801301-Cable-Leaning-Lateral-Raise_Shoulders_720.gif', 1),
(59, 'Elevación lateral disco', 'https://helysfit.com/wp-content/uploads/ezgif.com-gif-maker-2.gif', 1),
(60, 'Cross over aductores', 'https://fitcron.com/wp-content/uploads/2021/04/30481301-Cable-hip-abduction-version-2-male_Hips_720.gif', 1),
(61, 'Sentadilla sumo', 'https://i.pinimg.com/originals/c7/96/aa/c796aafc735c14237d2172beece29e24.gif', 1),
(62, 'Prensa', 'https://i.pinimg.com/originals/60/fb/4a/60fb4a02b481d7a1b71fbb1795d6109b.gif', 1),
(63, 'Elevación de talon con barras', 'https://fitcron.com/wp-content/uploads/2021/04/05851301-Lever-Leg-Extension_Thighs_720.gif', 1),
(64, 'Elevación de talon de pie', 'https://i.pinimg.com/originals/6b/aa/56/6baa56db563127e0cd7eb954ccf0ad9f.gif', 1),
(65, 'Hack', 'https://media.tenor.com/jiqHF0MkHeYAAAAM/gym.gif', 1),
(66, 'Prensa', 'https://i.pinimg.com/originals/60/fb/4a/60fb4a02b481d7a1b71fbb1795d6109b.gif', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejerutina`
--

CREATE TABLE `ejerutina` (
  `id` int(11) NOT NULL,
  `series` varchar(5) NOT NULL,
  `repeticones` varchar(5) NOT NULL,
  `descanso` varchar(45) NOT NULL,
  `fkIdEjercicios` int(11) NOT NULL,
  `fkIdRutina` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE `grupo` (
  `id` int(10) UNSIGNED NOT NULL,
  `ficha` varchar(15) NOT NULL,
  `cantidadAprendices` tinyint(3) UNSIGNED DEFAULT NULL,
  `estado` varchar(15) NOT NULL,
  `fechaInicioLectiva` date DEFAULT NULL,
  `fechaFinLectiva` date DEFAULT NULL,
  `fkIdProgForm` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`id`, `ficha`, `cantidadAprendices`, `estado`, `fechaInicioLectiva`, `fechaFinLectiva`, `fkIdProgForm`) VALUES
(1, '28737087', 11, 'activo', '2025-05-01', '2025-05-16', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupomuscular`
--

CREATE TABLE `grupomuscular` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupomuscular`
--

INSERT INTO `grupomuscular` (`id`, `nombre`, `imagen`) VALUES
(1, 'biceps', 'https://builtforathletes.com/cdn/shop/articles/Bench_press_and_biceps.jpg?v=1653385398');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programaformacion`
--

CREATE TABLE `programaformacion` (
  `id` int(10) UNSIGNED NOT NULL,
  `codigo` varchar(15) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `FkIdCentroFormacion` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `programaformacion`
--

INSERT INTO `programaformacion` (`id`, `codigo`, `nombre`, `FkIdCentroFormacion`) VALUES
(1, '2873707', 'ADSO', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registroingresos`
--

CREATE TABLE `registroingresos` (
  `id` int(10) UNSIGNED NOT NULL,
  `fechaIn` datetime NOT NULL,
  `fechaOut` datetime DEFAULT NULL,
  `fkIdUserGym` int(10) UNSIGNED NOT NULL,
  `fkIdActividad` int(10) UNSIGNED DEFAULT NULL,
  `fkIdTrainer` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombre`) VALUES
(1, 'admin'),
(2, 'entrenador'),
(3, 'aprendiz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutina`
--

CREATE TABLE `rutina` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `calentamiento` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutinausu`
--

CREATE TABLE `rutinausu` (
  `fkIdUsuario` int(10) UNSIGNED NOT NULL,
  `fkIdRutina` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `tipoDocumento` char(2) NOT NULL,
  `documento` varchar(20) NOT NULL,
  `fechaNacimiento` date DEFAULT NULL,
  `email` varchar(80) NOT NULL,
  `genero` char(1) NOT NULL,
  `estado` varchar(15) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `eps` varchar(20) DEFAULT NULL,
  `tipoSangre` char(3) NOT NULL,
  `peso` decimal(10,0) DEFAULT NULL,
  `estatura` decimal(10,0) DEFAULT NULL,
  `telefonoEmerjencia` varchar(15) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `fkIdRol` int(10) UNSIGNED NOT NULL,
  `fkIdGrupo` int(10) UNSIGNED DEFAULT NULL,
  `fkIdCentroFormacion` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `tipoDocumento`, `documento`, `fechaNacimiento`, `email`, `genero`, `estado`, `telefono`, `eps`, `tipoSangre`, `peso`, `estatura`, `telefonoEmerjencia`, `password`, `observaciones`, `fkIdRol`, `fkIdGrupo`, `fkIdCentroFormacion`) VALUES
(0, 'admin', 'CC', '1030080395', '2005-08-09', 'admin0009@gmail.com', 'N', 'activo', '3111132345', 'especial', 'AB-', 65, 2, '3136134631', '$2y$10$hnBiHt8VlIAOlulmH13tEenky3mQyDh/f6iaGOq420TPQVtNCHSou', 'nada', 1, 1, 1),
(1, 'entrenador', 'CC', '123456789', '2000-05-09', 'entrenador@gmail.com', 'M', 'activo', '12345656775', 'especial', 'A+', 65, 2, '123324324', '$2y$10$9o3jQ4rYBy.Cw8sUkw/N6.jv/8XJ8t/PbpBRJSv7.Dq1KStK1L5gm', 'que te importa', 2, 1, 1),
(2, 'aprendiz', 'T.', '192837465', '2016-05-11', 'aprendiz@gmail.com', 'F', 'activo', '198736453', 'especial', 'AB-', 65, 2, '1239874327', '$2y$10$fuTcAGOsd371cv/Xw5gT3.LLgrxG2ZBUpU6hl9z72q9eukLlMBwbq', 'gato', 3, 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `centroformacion`
--
ALTER TABLE `centroformacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `controlprogreso`
--
ALTER TABLE `controlprogreso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkIdUser` (`fkIdUsuario`);

--
-- Indices de la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkIdGrupomuscular` (`fkIdGrupomuscular`);

--
-- Indices de la tabla `ejerutina`
--
ALTER TABLE `ejerutina`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkIdEjercicios` (`fkIdEjercicios`),
  ADD KEY `fkIdRutina` (`fkIdRutina`);

--
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkIdProgFrom` (`fkIdProgForm`);

--
-- Indices de la tabla `grupomuscular`
--
ALTER TABLE `grupomuscular`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `programaformacion`
--
ALTER TABLE `programaformacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FkIdCentroFormacion` (`FkIdCentroFormacion`);

--
-- Indices de la tabla `registroingresos`
--
ALTER TABLE `registroingresos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkIdActividad` (`fkIdActividad`),
  ADD KEY `fkIdTrainer` (`fkIdTrainer`),
  ADD KEY `fkIdUserGymReg` (`fkIdUserGym`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rutina`
--
ALTER TABLE `rutina`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rutinausu`
--
ALTER TABLE `rutinausu`
  ADD PRIMARY KEY (`fkIdUsuario`,`fkIdRutina`),
  ADD KEY `fk_rutinaUsu_rutina` (`fkIdRutina`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkIdCentroFormacion2` (`fkIdCentroFormacion`),
  ADD KEY `fkIdGrupo` (`fkIdGrupo`),
  ADD KEY `fkIdRol` (`fkIdRol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `ejerutina`
--
ALTER TABLE `ejerutina`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grupomuscular`
--
ALTER TABLE `grupomuscular`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `rutina`
--
ALTER TABLE `rutina`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `controlprogreso`
--
ALTER TABLE `controlprogreso`
  ADD CONSTRAINT `fkIdUser` FOREIGN KEY (`fkIdUsuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  ADD CONSTRAINT `fkIdGrupomuscular` FOREIGN KEY (`fkIdGrupomuscular`) REFERENCES `grupomuscular` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ejerutina`
--
ALTER TABLE `ejerutina`
  ADD CONSTRAINT `fkIdEjercicios` FOREIGN KEY (`fkIdEjercicios`) REFERENCES `ejercicios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkIdRutina` FOREIGN KEY (`fkIdRutina`) REFERENCES `rutina` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD CONSTRAINT `fkIdProgFrom` FOREIGN KEY (`fkIdProgForm`) REFERENCES `programaformacion` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `programaformacion`
--
ALTER TABLE `programaformacion`
  ADD CONSTRAINT `FkIdCentroFormacion` FOREIGN KEY (`FkIdCentroFormacion`) REFERENCES `centroformacion` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `registroingresos`
--
ALTER TABLE `registroingresos`
  ADD CONSTRAINT `fkIdActividad` FOREIGN KEY (`fkIdActividad`) REFERENCES `actividad` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkIdTrainer` FOREIGN KEY (`fkIdTrainer`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkIdUserGymReg` FOREIGN KEY (`fkIdUserGym`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `rutinausu`
--
ALTER TABLE `rutinausu`
  ADD CONSTRAINT `fk_rutinaUsu_rutina` FOREIGN KEY (`fkIdRutina`) REFERENCES `rutina` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rutinaUsu_usuario` FOREIGN KEY (`fkIdUsuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fkIdCentroFormacion2` FOREIGN KEY (`fkIdCentroFormacion`) REFERENCES `centroformacion` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkIdGrupo` FOREIGN KEY (`fkIdGrupo`) REFERENCES `grupo` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkIdRol` FOREIGN KEY (`fkIdRol`) REFERENCES `rol` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
