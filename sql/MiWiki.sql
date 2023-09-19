-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-05-2023 a las 22:04:53
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
-- Base de datos: `miwiki`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'undefined'),
(2, 'biography'),
(3, 'science'),
(4, 'history'),
(5, 'sports'),
(6, 'politics'),
(7, 'culture');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category_reports`
--

CREATE TABLE `category_reports` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `category_reports`
--

INSERT INTO `category_reports` (`id`, `category_id`, `user_id`, `description`, `created_at`) VALUES
(1, 6, 2, "I don't like this category", '2023-05-11 21:11:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `pages`
--

INSERT INTO `pages` (`id`, `title`, `category`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'José de Barrasa y Fernández de Castro', 2, '2023-05-02 20:09:50', 1, '2023-06-02 20:09:59', 1),
(2, 'Hyperbola', 3, '2023-05-08 21:09:50', 2, '2023-05-10 22:09:59', 1),
(3, 'World War I', 4, '2023-05-12 22:00:50', 1, '2023-05-20 22:00:59', 1),
(4, 'Linguaggi e tecnologie per il Web', 7, '2023-05-19 15:32:07', 2, '2023-05-19 15:32:07', 2),
(5, 'Von Neumann architecture', 3, '2023-05-23 11:47:20', 2, '2023-05-24 09:11:27', 2);


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `page_reports`
--

CREATE TABLE `page_reports` (
  `id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `page_reports`
--

INSERT INTO `page_reports` (`id`, `page_id`, `user_id`, `description`, `created_at`) VALUES
(1, 5, 2, 'All the information on this page is false', '2023-05-09 17:29:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `email` varchar(120) NOT NULL,
  `fullname` varchar(120) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `users`
--

-- La contraseña usada para estos 3 usuarios es "Linguaggi23"
INSERT INTO `users` (`id`, `username`, `email`, `fullname`, `password`, `admin`) VALUES
(1, 'user1', 'user1@example.com', 'Leonardo da Vinci', '$2y$10$vPJeJMOApGEp0XnXMXIUG.MLBt2FFoG7CTsKlb6sBauzV7viIb9Yy', 0),
(2, 'user2', 'user2@example.com', 'Galileo Galilei', '$2y$10$vPJeJMOApGEp0XnXMXIUG.MLBt2FFoG7CTsKlb6sBauzV7viIb9Yy', 0),
(3, 'admin', 'admin@example.com', 'Dante Alighieri', '$2y$10$vPJeJMOApGEp0XnXMXIUG.MLBt2FFoG7CTsKlb6sBauzV7viIb9Yy', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `category_reports`
--
ALTER TABLE `category_reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indices de la tabla `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `category` (`category`);

--
-- Indices de la tabla `page_reports`
--
ALTER TABLE `page_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_id` (`page_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `category_reports`
--
ALTER TABLE `category_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `page_reports`
--
ALTER TABLE `page_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `category_reports`
--
ALTER TABLE `category_reports`
  ADD CONSTRAINT `category_reports_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `category_reports_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pages_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pages_ibfk_3` FOREIGN KEY (`category`) REFERENCES `categories` (`id`);

--
-- Filtros para la tabla `page_reports`
--
ALTER TABLE `page_reports`
  ADD CONSTRAINT `page_reports_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`),
  ADD CONSTRAINT `page_reports_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
