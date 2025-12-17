-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 17 déc. 2025 à 14:00
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `msarchi`
--

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `path` varchar(255) NOT NULL,
  `alt` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id`, `path`, `alt`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'storage/uploads/1765971930_vue-scenario-nuit2.webp', 'brpoo', '2025-12-17 12:45:30', '2025-12-17 12:45:30', NULL),
(2, 'storage/uploads/1765972074_vue-scenario-nuit2.webp', 'brpoo', '2025-12-17 12:47:54', '2025-12-17 12:47:54', NULL),
(3, 'storage/uploads/1765972465_vue-scenario-nuit2.webp', 'brpoo', '2025-12-17 12:54:25', '2025-12-17 12:54:25', NULL),
(4, 'storage/uploads/1765972465_soul-3.webp', 'brpoo', '2025-12-17 12:54:25', '2025-12-17 12:54:25', NULL),
(5, 'storage/uploads/1765974307_cropped-vue-panoramique.jpg', 'rrrrrrrr', '2025-12-17 13:25:07', '2025-12-17 13:25:07', NULL),
(6, 'storage/uploads/1765974307_cropped-facadeefec.png', 'rrrrrrrr', '2025-12-17 13:25:07', '2025-12-17 13:25:07', NULL),
(7, 'storage/uploads/1765979002_tigrou.png', 'OASIS MARRAKECH', '2025-12-17 14:43:22', '2025-12-17 14:43:22', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `location` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `projects`
--

INSERT INTO `projects` (`id`, `title`, `description`, `location`, `category`, `created_at`) VALUES
(8, 'testzzz', 'rea', 'za', 'Appartement', '2025-12-15 13:30:46'),
(9, 'brpoo', 'azrezaezzaeeza', 'Rabat', NULL, '2025-12-17 11:54:25'),
(10, 'rrrrrrrr', 'zezz', 'aaaaaaaaa', NULL, '2025-12-17 12:25:07');

-- --------------------------------------------------------

--
-- Structure de la table `project_images`
--

DROP TABLE IF EXISTS `project_images`;
CREATE TABLE IF NOT EXISTS `project_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `project_images`
--

INSERT INTO `project_images` (`id`, `project_id`, `image_path`, `image_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 8, 'app/public/bucket/img_69400d86ca9a62.30671098.jpg', '32.jpg', '2025-12-17 12:40:44', '2025-12-17 12:40:44', NULL),
(2, 8, 'app/public/bucket/img_69400d86cee8e7.50519727.png', 'mcd_tp1_bdd.png', '2025-12-17 12:40:44', '2025-12-17 12:40:44', NULL),
(3, 9, 'storage/uploads/1765972465_vue-scenario-nuit2.webp', 'vue-scenario-nuit2.webp', '2025-12-17 12:54:25', '2025-12-17 12:54:25', NULL),
(4, 9, 'storage/uploads/1765972465_soul-3.webp', 'soul-3.webp', '2025-12-17 12:54:25', '2025-12-17 12:54:25', NULL),
(5, 10, 'storage/uploads/1765974307_cropped-vue-panoramique.jpg', 'cropped-vue-panoramique.jpg', '2025-12-17 13:25:07', '2025-12-17 13:25:07', NULL),
(6, 10, 'storage/uploads/1765974307_cropped-facadeefec.png', 'cropped-facadeefec.png', '2025-12-17 13:25:07', '2025-12-17 13:25:07', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `is_admin`) VALUES
(1, 'tooto', 'toto@lol.com', '$2y$10$o72rLU1djQuzduW6/rXehu5Z3l7qotXNyyLy4EV8xMa0tuC7217YO', '2025-12-13 20:31:02', 1),
(2, 'titi', 'titi@www.cp', '$2y$10$7zenWwXQElQQlAaeDb7Y6u8hwBR87.Rnxj3cltA/MO7J2zYlvwNVe', '2025-12-17 10:22:51', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
