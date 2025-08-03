-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-08-2025 a las 21:56:55
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
-- Estructura de tabla para la tabla `activity`
--

CREATE TABLE `activity` (
  `id_activity` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apprenticereserves`
--

CREATE TABLE `apprenticereserves` (
  `id_apprenticereserves` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_calendar` int(11) NOT NULL,
  `entry_time` time NOT NULL,
  `departure_time` time NOT NULL,
  `reservation_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendar`
--

CREATE TABLE `calendar` (
  `id_calendar` int(11) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `id_user` int(11) NOT NULL,
  `max_capacity` int(11) NOT NULL,
  `status` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `exercise`
--

CREATE TABLE `exercise` (
  `id_exercise` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `example` varchar(255) NOT NULL,
  `id_musclegroup` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `exercise`
--

INSERT INTO `exercise` (`id_exercise`, `name`, `example`, `id_musclegroup`) VALUES
(1, 'Flexiones', 'https://fitcron.com/wp-content/uploads/2021/03/06621301-Push-up-m_Chest-FIX_720.gif', 1),
(2, 'Banco Plano', 'https://i.makeagif.com/media/10-01-2017/jspT4N.gif', 1),
(3, 'Banco Inclinado', 'https://static.strengthlevel.com/images/exercises/incline-dumbbell-bench-press/incline-dumbbell-bench-press-800.jpg', 1),
(4, 'Aperturas', 'https://fitnessprogramer.com/wp-content/uploads/2021/02/Incline-dumbbell-Fly.gif', 1),
(5, 'Pullover', 'https://i.pinimg.com/originals/d2/43/1a/d2431a33e8619902629d58ecee73c454.gif', 1),
(6, 'Mariposa Canina Pecho', 'https://static.strengthlevel.com/images/exercises/machine-chest-fly/machine-chest-fly-800.jpg', 1),
(7, 'Apertura Cross Over', 'https://i.pinimg.com/originals/a8/62/8f/a8628f044d98a0dc3e7750e47148e4de.gif', 1),
(8, 'Flexión de Biceps con Barra', 'https://realidadfitness.com/wp-content/uploads/2023/07/CURL-CON-BARRA-PARADO-GIF.gif', 1),
(9, 'Predicador', 'https://media.tenor.com/m2Dfyh507FQAAAAM/8preacher-curl.gif', 1),
(10, 'Concentrado', 'https://realidadfitness.com/wp-content/uploads/2023/07/CURL-DE-CONCENTRACION-GIF.gif', 1),
(11, 'Dominadas Cerradas', 'https://i.pinimg.com/736x/22/b7/66/22b7669189c834d9b693540b48855603.jpg', 1),
(12, 'Martillo', 'https://boxlifemagazine.com/wp-content/uploads//2023/06/curl-haltere-prise-neutre-5.gif', 1),
(13, 'Curl Barra Cross Over', 'https://cdn.shopify.com/s/files/1/0618/9462/3460/files/cable-curls.gif?v=1741771141', 1),
(14, 'Press Frances', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQIKTxvV1yoaDUt6FTYMUTh5G8XTny_pGAnoB3ZfXZ1Z2uNI_qeXVZdaz6pi7ut_6mF7rc&usqp=CAU', 1),
(15, 'Fondos en dos Bancos', 'https://static.strengthlevel.com/images/exercises/bench-dips/bench-dips-800.jpg', 1),
(16, 'Fondos en Paralela', 'https://fitcron.com/wp-content/uploads/2021/03/08141301-Triceps-Dip_Upper-Arms_720.gif', 1),
(17, 'Patada atras Mancuernas', 'https://i.pinimg.com/originals/f1/b6/16/f1b616965d2583544602ffc922e99e5a.gif', 1),
(18, 'Copa dos Manos', 'https://www.musculacion.net/images/extension-de-triceps-sobre-la-cabeza-mancuerna.jpg', 1),
(19, 'Press Polea atras Cross Over', 'https://fitcron.com/wp-content/uploads/2021/04/17241301-Cable-Rope-High-Pulley-Overhead-Tricep-Extension_Upper-Arms_720.gif', 1),
(20, 'Press Polea Barra', 'https://www.thingys.com.ar/gymapps/tutorial/7c9218fc52e8256003159658198439e2.gif', 1),
(21, 'Rodillo de Cuerda', 'https://st5.depositphotos.com/80218270/66486/v/450/depositphotos_664861800-stock-illustration-man-doing-step-knee-raises.jpg', 1),
(22, 'Supino Flexión con Barra', 'https://cdn.shopify.com/s/files/1/0425/7667/4983/files/FOTOS_BLOG_INSIDE_39a19406-d81a-4691-bb55-f7a04ad07bb3.gif?v=1713255025', 1),
(23, 'Prono Flexión con Barra', 'https://fitcron.com/wp-content/uploads/2021/04/01101301-Barbell-Standing-Reverse-Grip-Curl_Forearms_720.gif', 1),
(24, 'Elevación Pierna atras', 'https://fitcron.com/wp-content/uploads/2021/04/03331301-Dumbbell-Kickback_Upper-Arms_720.gif', 1),
(25, 'Eleveación lateral Mancuerna', 'https://fitcron.com/wp-content/uploads/2021/04/03341301-Dumbbell-Lateral-Raise_shoulder-AFIX_720.gif', 1),
(26, 'Extensión atras Mancuerna', 'https://fitcron.com/wp-content/uploads/2021/04/17301301-Dumbbell-Seated-Bent-Over-Alternate-Kickback_Upper-Arms_720.gif', 1),
(27, 'Subir Elevación pierna atras', 'https://fitcron.com/wp-content/uploads/2021/04/05821301-Lever-Kneeling-Leg-Curl-plate-loaded_Thighs_720.gif', 1),
(28, 'Hip Thrust', 'https://i.pinimg.com/originals/f9/65/95/f96595d8990e81472452ab65ae227ff8.gif', 1),
(29, 'Cross Over Abductores', 'https://fitcron.com/wp-content/uploads/2021/04/30481301-Cable-hip-abduction-version-2-male_Hips_720.gif', 1),
(30, 'Elevación Laterla de Pie', 'https://fitcron.com/wp-content/uploads/2021/04/38801301-Cable-Leaning-Lateral-Raise_Shoulders_720.gif', 1),
(31, 'Elevación Lateral Disco', 'https://helysfit.com/wp-content/uploads/ezgif.com-gif-maker-2.gif', 1),
(32, 'Cross Over Aductores', 'https://fitcron.com/wp-content/uploads/2021/04/30481301-Cable-hip-abduction-version-2-male_Hips_720.gif', 1),
(33, 'Sentadilla Sumo', 'https://i.pinimg.com/originals/c7/96/aa/c796aafc735c14237d2172beece29e24.gif', 1),
(34, 'Prensa', 'https://i.pinimg.com/originals/60/fb/4a/60fb4a02b481d7a1b71fbb1795d6109b.gif', 1),
(35, 'Elevación de talon con barras', 'https://fitcron.com/wp-content/uploads/2021/04/05851301-Lever-Leg-Extension_Thighs_720.gif', 1),
(36, 'Elevación de talón de pie', 'https://i.pinimg.com/originals/6b/aa/56/6baa56db563127e0cd7eb954ccf0ad9f.gif', 1),
(37, 'Hack', 'https://media.tenor.com/jiqHF0MkHeYAAAAM/gym.gif', 1),
(38, 'Prensa', 'https://i.pinimg.com/originals/60/fb/4a/60fb4a02b481d7a1b71fbb1795d6109b.gif', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `exerciseroutine`
--

CREATE TABLE `exerciseroutine` (
  `id_exerciseroutine` int(11) NOT NULL,
  `series` varchar(5) NOT NULL,
  `repetitions` varchar(5) NOT NULL,
  `weight` varchar(45) NOT NULL,
  `id_exercise` int(11) DEFAULT NULL,
  `id_routine` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `group`
--

CREATE TABLE `group` (
  `id_group` int(11) NOT NULL,
  `token_number` varchar(15) NOT NULL,
  `number_aprenttices` int(11) DEFAULT NULL,
  `status` varchar(15) NOT NULL,
  `star_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `id_trainingprogram` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `group`
--

INSERT INTO `group` (`id_group`, `token_number`, `number_aprenttices`, `status`, `star_date`, `end_date`, `id_trainingprogram`) VALUES
(1, '2873707', 12, 'activo', '2024-01-23', '2025-08-22', 1),
(2, '2873711', 30, 'activo', '2024-01-23', '2025-08-22', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incomerecord`
--

CREATE TABLE `incomerecord` (
  `id_incomerecord` int(11) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_activity` int(11) DEFAULT NULL,
  `id_trainer` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `musclegroup`
--

CREATE TABLE `musclegroup` (
  `id_musclegroup` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `musclegroup`
--

INSERT INTO `musclegroup` (`id_musclegroup`, `name`, `image`) VALUES
(1, 'Biceps', 'https://builtforathletes.com/cdn/shop/articles/Bench_press_and_biceps.jpg?v=1653385398');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `progresscontrol`
--

CREATE TABLE `progresscontrol` (
  `id_progresscontrol` int(11) NOT NULL,
  `date_completion` date NOT NULL,
  `peso` decimal(10,0) DEFAULT NULL,
  `waist` decimal(10,0) DEFAULT NULL,
  `hip` decimal(10,0) DEFAULT NULL,
  `right_thigh` decimal(10,0) DEFAULT NULL,
  `left_thigh` decimal(10,0) DEFAULT NULL,
  `right_arm` decimal(10,0) DEFAULT NULL,
  `left_arm` decimal(10,0) DEFAULT NULL,
  `right_forearm` decimal(10,0) DEFAULT NULL,
  `left_forearm` decimal(10,0) DEFAULT NULL,
  `right_calf` decimal(10,0) DEFAULT NULL,
  `left_calf` decimal(10,0) DEFAULT NULL,
  `medical_examination` varchar(255) DEFAULT NULL,
  `observations` text DEFAULT NULL,
  `exam_date` date DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`id_role`, `name`) VALUES
(1, 'admin'),
(2, 'entrenador'),
(3, 'aprendiz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `routine`
--

CREATE TABLE `routine` (
  `id_routine` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `routineuser`
--

CREATE TABLE `routineuser` (
  `id_user` int(11) DEFAULT NULL,
  `id_routine` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trainingcenter`
--

CREATE TABLE `trainingcenter` (
  `id_trainingcenter` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `trainingcenter`
--

INSERT INTO `trainingcenter` (`id_trainingcenter`, `name`) VALUES
(1, 'Industria'),
(2, 'Automatización'),
(3, 'Comercio'),
(4, 'Cafetera');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trainingprogram`
--

CREATE TABLE `trainingprogram` (
  `id_trainingprogram` int(11) NOT NULL,
  `token_number` varchar(15) NOT NULL,
  `name` varchar(100) NOT NULL,
  `id_trainingcenter` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `trainingprogram`
--

INSERT INTO `trainingprogram` (`id_trainingprogram`, `token_number`, `name`, `id_trainingcenter`) VALUES
(1, '2873707', 'ADSO', 1),
(2, '2873711', 'ADSO', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `document_type` char(2) NOT NULL,
  `document` varchar(20) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `gender` char(1) NOT NULL,
  `status` varchar(15) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `eps` varchar(20) DEFAULT NULL,
  `blood_type` char(3) NOT NULL,
  `weight` decimal(10,0) DEFAULT NULL,
  `stature` decimal(10,0) DEFAULT NULL,
  `emergency_phone` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `observations` text DEFAULT NULL,
  `id_role` int(11) DEFAULT NULL,
  `id_group` int(11) DEFAULT NULL,
  `id_trainingcenter` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id_user`, `name`, `picture`, `document_type`, `document`, `birthdate`, `email`, `gender`, `status`, `phone`, `eps`, `blood_type`, `weight`, `stature`, `emergency_phone`, `password`, `observations`, `id_role`, `id_group`, `id_trainingcenter`) VALUES
(1, 'Admin', 'https://pbs.twimg.com/media/Bhf_XUwCYAAfY2A.jpg', 'CC', '123456789', '2007-05-11', 'admin@gmail.com', 'M', 'activo', '123456789', 'Salud Total S.A.S', 'B+', 66, 165, '123456789', '$2y$10$9Tn3darIHZ29CYM4GFw2gutN3ayIUDlGr9Dwge5COBtX.2g284MZC', NULL, 1, NULL, NULL),
(2, 'Entrenador', 'https://cdn.hobbyconsolas.com/sites/navi.axelspringer.es/public/media/image/2021/12/cyberpunk-2077-johnny-silverhand-keanu-reeves-2567861.jpg?tf=1200x1200', 'CC', '123456788', '2007-05-11', 'entrenador@gmail.com', 'M', 'activo', '123456788', 'Salud Total S.A.S', 'B+', 66, 165, '123456788', '$2y$10$BGQlOv1/eWrXvlffMUFz2ea34Vg8Bo4R6gInZsALtCn5eEf9uNWu.', NULL, 2, NULL, NULL),
(3, 'Aprendiz', 'https://image-cdn.flowgpt.com/trans-images/1751467202353-8ed9cdc2-b149-484e-bedd-2f4bcd788e10.webp', 'CC', '123456787', '2007-05-11', 'aprendiz@gmail.com', 'M', 'activo', '123456787', 'Salud Total S.A.S', 'B+', 66, 165, '123456787', '$2y$10$FxAqCRLIO1KciStk.gfbRedz9nJCmKPr2FLW1zL6ACgnqdrdUfVtq', 'La vida es una serie de cambios naturales y espontáneos.', 3, 1, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id_activity`);

--
-- Indices de la tabla `apprenticereserves`
--
ALTER TABLE `apprenticereserves`
  ADD PRIMARY KEY (`id_apprenticereserves`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_calendar` (`id_calendar`);

--
-- Indices de la tabla `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`id_calendar`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `exercise`
--
ALTER TABLE `exercise`
  ADD PRIMARY KEY (`id_exercise`),
  ADD KEY `id_musclegroup` (`id_musclegroup`);

--
-- Indices de la tabla `exerciseroutine`
--
ALTER TABLE `exerciseroutine`
  ADD PRIMARY KEY (`id_exerciseroutine`),
  ADD KEY `id_exercise` (`id_exercise`),
  ADD KEY `id_routine` (`id_routine`);

--
-- Indices de la tabla `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id_group`),
  ADD KEY `id_trainingprogram` (`id_trainingprogram`);

--
-- Indices de la tabla `incomerecord`
--
ALTER TABLE `incomerecord`
  ADD PRIMARY KEY (`id_incomerecord`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_activity` (`id_activity`),
  ADD KEY `id_trainer` (`id_trainer`);

--
-- Indices de la tabla `musclegroup`
--
ALTER TABLE `musclegroup`
  ADD PRIMARY KEY (`id_musclegroup`);

--
-- Indices de la tabla `progresscontrol`
--
ALTER TABLE `progresscontrol`
  ADD PRIMARY KEY (`id_progresscontrol`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indices de la tabla `routine`
--
ALTER TABLE `routine`
  ADD PRIMARY KEY (`id_routine`);

--
-- Indices de la tabla `routineuser`
--
ALTER TABLE `routineuser`
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_routine` (`id_routine`);

--
-- Indices de la tabla `trainingcenter`
--
ALTER TABLE `trainingcenter`
  ADD PRIMARY KEY (`id_trainingcenter`);

--
-- Indices de la tabla `trainingprogram`
--
ALTER TABLE `trainingprogram`
  ADD PRIMARY KEY (`id_trainingprogram`),
  ADD KEY `id_trainingcenter` (`id_trainingcenter`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `document` (`document`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_group` (`id_group`),
  ADD KEY `id_trainingcenter` (`id_trainingcenter`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `activity`
--
ALTER TABLE `activity`
  MODIFY `id_activity` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `apprenticereserves`
--
ALTER TABLE `apprenticereserves`
  MODIFY `id_apprenticereserves` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `calendar`
--
ALTER TABLE `calendar`
  MODIFY `id_calendar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `exercise`
--
ALTER TABLE `exercise`
  MODIFY `id_exercise` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `exerciseroutine`
--
ALTER TABLE `exerciseroutine`
  MODIFY `id_exerciseroutine` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `group`
--
ALTER TABLE `group`
  MODIFY `id_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `incomerecord`
--
ALTER TABLE `incomerecord`
  MODIFY `id_incomerecord` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `musclegroup`
--
ALTER TABLE `musclegroup`
  MODIFY `id_musclegroup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `progresscontrol`
--
ALTER TABLE `progresscontrol`
  MODIFY `id_progresscontrol` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `routine`
--
ALTER TABLE `routine`
  MODIFY `id_routine` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trainingcenter`
--
ALTER TABLE `trainingcenter`
  MODIFY `id_trainingcenter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `trainingprogram`
--
ALTER TABLE `trainingprogram`
  MODIFY `id_trainingprogram` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `apprenticereserves`
--
ALTER TABLE `apprenticereserves`
  ADD CONSTRAINT `apprenticereserves_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `apprenticereserves_ibfk_2` FOREIGN KEY (`id_calendar`) REFERENCES `calendar` (`id_calendar`);

--
-- Filtros para la tabla `calendar`
--
ALTER TABLE `calendar`
  ADD CONSTRAINT `calendar_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Filtros para la tabla `exercise`
--
ALTER TABLE `exercise`
  ADD CONSTRAINT `exercise_ibfk_1` FOREIGN KEY (`id_musclegroup`) REFERENCES `musclegroup` (`id_musclegroup`);

--
-- Filtros para la tabla `exerciseroutine`
--
ALTER TABLE `exerciseroutine`
  ADD CONSTRAINT `exerciseroutine_ibfk_1` FOREIGN KEY (`id_exercise`) REFERENCES `exercise` (`id_exercise`),
  ADD CONSTRAINT `exerciseroutine_ibfk_2` FOREIGN KEY (`id_routine`) REFERENCES `routine` (`id_routine`);

--
-- Filtros para la tabla `group`
--
ALTER TABLE `group`
  ADD CONSTRAINT `group_ibfk_1` FOREIGN KEY (`id_trainingprogram`) REFERENCES `trainingprogram` (`id_trainingprogram`);

--
-- Filtros para la tabla `incomerecord`
--
ALTER TABLE `incomerecord`
  ADD CONSTRAINT `incomerecord_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `incomerecord_ibfk_2` FOREIGN KEY (`id_activity`) REFERENCES `activity` (`id_activity`),
  ADD CONSTRAINT `incomerecord_ibfk_3` FOREIGN KEY (`id_trainer`) REFERENCES `user` (`id_user`);

--
-- Filtros para la tabla `progresscontrol`
--
ALTER TABLE `progresscontrol`
  ADD CONSTRAINT `progresscontrol_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Filtros para la tabla `routineuser`
--
ALTER TABLE `routineuser`
  ADD CONSTRAINT `routineuser_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `routineuser_ibfk_2` FOREIGN KEY (`id_routine`) REFERENCES `routine` (`id_routine`);

--
-- Filtros para la tabla `trainingprogram`
--
ALTER TABLE `trainingprogram`
  ADD CONSTRAINT `trainingprogram_ibfk_1` FOREIGN KEY (`id_trainingcenter`) REFERENCES `trainingcenter` (`id_trainingcenter`);

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`id_group`) REFERENCES `group` (`id_group`),
  ADD CONSTRAINT `user_ibfk_3` FOREIGN KEY (`id_trainingcenter`) REFERENCES `trainingcenter` (`id_trainingcenter`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
