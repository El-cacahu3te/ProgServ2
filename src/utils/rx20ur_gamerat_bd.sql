-- phpMyAdmin SQL Dump
-- version 4.9.6
-- https://www.phpmyadmin.net/
--
-- Hôte : rx20ur.myd.infomaniak.com
-- Généré le :  jeu. 18 déc. 2025 à 09:57
-- Version du serveur :  10.6.19-MariaDB-deb11-log
-- Version de PHP :  7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `rx20ur_gamerat_bd`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Action'),
(2, 'RPG'),
(3, 'Adventure'),
(4, 'Shooter'),
(5, 'Strategy'),
(6, 'Simulation'),
(7, 'Sports'),
(8, 'Racing'),
(9, 'Fighting'),
(10, 'Survival'),
(11, 'Horror'),
(12, 'Puzzle'),
(13, 'Platformer'),
(14, 'Battle Royale'),
(15, 'MOBA'),
(16, 'MMO'),
(17, 'Sandbox');

-- --------------------------------------------------------

--
-- Structure de la table `game`
--

CREATE TABLE `game` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `release_date` date NOT NULL,
  `game_min_age` int(11) NOT NULL,
  `has_single_player` tinyint(1) DEFAULT 0,
  `has_multiplayer` tinyint(1) DEFAULT 0,
  `has_coop` tinyint(1) DEFAULT 0,
  `has_pvp` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `release_date` date NOT NULL,
  `game_min_age` int(11) NOT NULL,
  `has_single_player` tinyint(1) DEFAULT 0,
  `has_multiplayer` tinyint(1) DEFAULT 0,
  `has_coop` tinyint(1) DEFAULT 0,
  `has_pvp` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `games`
--

INSERT INTO `games` (`id`, `name`, `release_date`, `game_min_age`, `has_single_player`, `has_multiplayer`, `has_coop`, `has_pvp`) VALUES
(1, 'The Witcher 3: Wild Hunt', '2015-05-19', 18, 1, 0, 0, 0),
(2, 'Minecraft', '2011-11-18', 7, 1, 1, 1, 1),
(3, 'Grand Theft Auto V', '2013-09-17', 18, 1, 1, 1, 1),
(4, 'The Legend of Zelda: Breath of the Wild', '2017-03-03', 12, 1, 0, 0, 0),
(5, 'Red Dead Redemption 2', '2018-10-26', 18, 1, 1, 1, 0),
(6, 'Cyberpunk 2077', '2020-12-10', 18, 1, 1, 0, 0),
(7, 'Elden Ring', '2022-02-25', 16, 1, 1, 1, 1),
(8, 'God of War', '2018-04-20', 18, 1, 0, 0, 0),
(9, 'The Last of Us Part II', '2020-06-19', 18, 1, 1, 1, 0),
(10, 'Horizon Zero Dawn', '2017-02-28', 16, 1, 0, 0, 0),
(11, 'Dark Souls III', '2016-04-12', 16, 1, 1, 1, 1),
(12, 'Sekiro: Shadows Die Twice', '2019-03-22', 16, 1, 0, 0, 0),
(13, 'Bloodborne', '2015-03-24', 16, 1, 1, 1, 0),
(14, 'Resident Evil Village', '2021-05-07', 18, 1, 0, 0, 0),
(15, 'Skyrim', '2011-11-11', 16, 1, 0, 0, 0),
(16, 'Fallout 4', '2015-11-10', 18, 1, 0, 0, 0),
(17, 'Assassin\'s Creed Valhalla', '2020-11-10', 18, 1, 1, 1, 0),
(18, 'Call of Duty: Modern Warfare', '2019-10-25', 18, 1, 1, 1, 1),
(19, 'Battlefield 2042', '2021-11-19', 16, 0, 1, 1, 1),
(20, 'Fortnite', '2017-07-25', 12, 0, 1, 1, 1),
(21, 'Apex Legends', '2019-02-04', 16, 0, 1, 1, 1),
(22, 'Overwatch 2', '2022-10-04', 12, 0, 1, 1, 1),
(23, 'Rainbow Six Siege', '2015-12-01', 16, 0, 1, 1, 1),
(24, 'Counter-Strike 2', '2023-09-27', 16, 0, 1, 0, 1),
(25, 'Valorant', '2020-06-02', 16, 0, 1, 0, 1),
(26, 'League of Legends', '2009-10-27', 12, 0, 1, 0, 1),
(27, 'Dota 2', '2013-07-09', 12, 0, 1, 0, 1),
(28, 'World of Warcraft', '2004-11-23', 12, 1, 1, 1, 1),
(29, 'Final Fantasy XIV', '2013-08-27', 12, 1, 1, 1, 1),
(30, 'Destiny 2', '2017-09-06', 16, 1, 1, 1, 1),
(31, 'Monster Hunter: World', '2018-01-26', 16, 1, 1, 1, 0),
(32, 'Diablo IV', '2023-06-06', 18, 1, 1, 1, 1),
(33, 'Path of Exile', '2013-10-23', 16, 1, 1, 1, 1),
(34, 'Stardew Valley', '2016-02-26', 7, 1, 1, 1, 0),
(35, 'Terraria', '2011-05-16', 12, 1, 1, 1, 1),
(36, 'Hollow Knight', '2017-02-24', 7, 1, 0, 0, 0),
(37, 'Celeste', '2018-01-25', 7, 1, 0, 0, 0),
(38, 'Hades', '2020-09-17', 12, 1, 0, 0, 0),
(39, 'Dead Cells', '2018-08-07', 16, 1, 0, 0, 0),
(40, 'Returnal', '2021-04-30', 16, 1, 0, 0, 0),
(41, 'Control', '2019-08-27', 16, 1, 0, 0, 0),
(42, 'Death Stranding', '2019-11-08', 18, 1, 1, 1, 0),
(43, 'Ghost of Tsushima', '2020-07-17', 18, 1, 1, 1, 0),
(44, 'Spider-Man', '2018-09-07', 16, 1, 0, 0, 0),
(45, 'Uncharted 4', '2016-05-10', 16, 1, 1, 1, 1),
(46, 'Ratchet & Clank: Rift Apart', '2021-06-11', 7, 1, 0, 0, 0),
(47, 'Demon\'s Souls', '2020-11-12', 16, 1, 1, 1, 0),
(48, 'Nioh 2', '2020-03-13', 18, 1, 1, 1, 0),
(49, 'Persona 5 Royal', '2019-10-31', 16, 1, 0, 0, 0),
(50, 'Dragon Quest XI', '2017-07-29', 12, 1, 0, 0, 0),
(51, 'Tales of Arise', '2021-09-10', 16, 1, 0, 0, 0),
(52, 'Ni no Kuni II', '2018-03-23', 12, 1, 0, 0, 0),
(53, 'Genshin Impact', '2020-09-28', 12, 1, 1, 1, 0),
(54, 'Honkai: Star Rail', '2023-04-26', 12, 1, 0, 0, 0),
(55, 'Baldur\'s Gate 3', '2023-08-03', 18, 1, 1, 1, 0),
(56, 'Divinity: Original Sin 2', '2017-09-14', 16, 1, 1, 1, 0),
(57, 'Pillars of Eternity II', '2018-05-08', 16, 1, 0, 0, 0),
(58, 'Wasteland 3', '2020-08-28', 18, 1, 1, 1, 0),
(59, 'XCOM 2', '2016-02-05', 16, 1, 0, 0, 0),
(60, 'Civilization VI', '2016-10-21', 12, 1, 1, 0, 1),
(61, 'Total War: Warhammer III', '2022-02-17', 16, 1, 1, 1, 1),
(62, 'Age of Empires IV', '2021-10-28', 12, 1, 1, 1, 1),
(63, 'StarCraft II', '2010-07-27', 12, 1, 1, 1, 1),
(64, 'Warcraft III: Reforged', '2020-01-28', 12, 1, 1, 1, 1),
(65, 'Anno 1800', '2019-04-16', 7, 1, 1, 1, 0),
(66, 'Cities: Skylines', '2015-03-10', 7, 1, 0, 0, 0),
(67, 'Planet Zoo', '2019-11-05', 7, 1, 0, 0, 0),
(68, 'The Sims 4', '2014-09-02', 12, 1, 0, 0, 0),
(69, 'Animal Crossing: New Horizons', '2020-03-20', 3, 1, 1, 1, 0),
(70, 'Mario Kart 8 Deluxe', '2017-04-28', 3, 1, 1, 1, 1),
(71, 'Super Smash Bros. Ultimate', '2018-12-07', 12, 1, 1, 1, 1),
(72, 'Splatoon 3', '2022-09-09', 7, 1, 1, 1, 1),
(73, 'Pokémon Scarlet', '2022-11-18', 7, 1, 1, 1, 1),
(74, 'Metroid Dread', '2021-10-08', 12, 1, 0, 0, 0),
(75, 'Fire Emblem: Three Houses', '2019-07-26', 12, 1, 0, 0, 0),
(76, 'Xenoblade Chronicles 3', '2022-07-29', 12, 1, 0, 0, 0),
(77, 'Kirby and the Forgotten Land', '2022-03-25', 7, 1, 1, 1, 0),
(78, 'Sonic Frontiers', '2022-11-08', 7, 1, 0, 0, 0),
(79, 'It Takes Two', '2021-03-26', 12, 0, 1, 1, 0),
(80, 'A Way Out', '2018-03-23', 18, 0, 1, 1, 0),
(81, 'Cuphead', '2017-09-29', 7, 1, 1, 1, 0),
(82, 'Ori and the Will of the Wisps', '2020-03-11', 7, 1, 0, 0, 0),
(83, 'Ori and the Blind Forest', '2015-03-11', 7, 1, 0, 0, 0),
(84, 'Rocket League', '2015-07-07', 3, 1, 1, 1, 1),
(85, 'Fall Guys', '2020-08-04', 7, 0, 1, 1, 0),
(86, 'Among Us', '2018-06-15', 7, 0, 1, 1, 0),
(87, 'Phasmophobia', '2020-09-18', 12, 1, 1, 1, 0),
(88, 'Lethal Company', '2023-10-23', 16, 0, 1, 1, 0),
(89, 'Sea of Thieves', '2018-03-20', 12, 0, 1, 1, 1),
(90, 'No Man\'s Sky', '2016-08-09', 7, 1, 1, 1, 0),
(91, 'Subnautica', '2018-01-23', 7, 1, 0, 0, 0),
(92, 'The Forest', '2018-04-30', 18, 1, 1, 1, 0),
(93, 'Rust', '2018-02-08', 16, 0, 1, 0, 1),
(94, 'ARK: Survival Evolved', '2017-08-29', 16, 1, 1, 1, 1),
(95, 'Valheim', '2021-02-02', 12, 1, 1, 1, 1),
(96, 'Satisfactory', '2020-06-08', 7, 1, 1, 1, 0),
(97, 'Factorio', '2020-08-14', 7, 1, 1, 1, 0),
(98, 'Rimworld', '2018-10-17', 16, 1, 0, 0, 0),
(99, 'Portal 2', '2011-04-19', 12, 1, 1, 1, 0),
(100, 'Half-Life: Alyx', '2020-03-23', 16, 1, 0, 0, 0),
(101, 'Age of Mythology', '2002-10-30', 12, 1, 1, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `games_categories`
--

CREATE TABLE `games_categories` (
  `games_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `games_categories`
--

INSERT INTO `games_categories` (`games_id`, `category_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 11),
(2, 17),
(3, 1),
(3, 3),
(4, 1),
(4, 3),
(5, 1),
(5, 3),
(6, 1),
(6, 2),
(7, 1),
(7, 2),
(8, 1),
(8, 3),
(9, 1),
(9, 3),
(10, 1),
(10, 2),
(11, 1),
(11, 2),
(12, 1),
(12, 2),
(13, 1),
(13, 2),
(14, 1),
(14, 11),
(15, 2),
(15, 3),
(16, 2),
(16, 4),
(17, 1),
(17, 2),
(18, 4),
(19, 4),
(20, 14),
(21, 4),
(21, 14),
(22, 4),
(23, 4),
(24, 4),
(25, 4),
(26, 15),
(27, 15),
(28, 2),
(28, 16),
(29, 2),
(29, 16),
(34, 7),
(35, 3),
(35, 17),
(36, 13),
(37, 13),
(38, 1),
(38, 2),
(39, 1),
(39, 13),
(40, 1),
(40, 4),
(41, 1),
(41, 3),
(42, 1),
(42, 3),
(43, 1),
(43, 3),
(44, 1),
(44, 3),
(45, 1),
(45, 3),
(46, 1),
(46, 13),
(49, 2),
(50, 2),
(51, 1),
(51, 2),
(55, 2),
(55, 6),
(56, 2),
(56, 6),
(59, 6),
(60, 6),
(61, 6),
(62, 6),
(63, 6),
(64, 6),
(64, 7),
(65, 7),
(66, 7),
(68, 7),
(69, 8),
(70, 9),
(73, 1),
(73, 13),
(76, 3),
(76, 13),
(77, 3),
(77, 13),
(81, 4),
(81, 13),
(82, 13),
(83, 13),
(84, 7),
(85, 12),
(86, 12),
(87, 11),
(87, 12),
(88, 11),
(88, 12),
(90, 11),
(90, 17),
(91, 3),
(91, 11),
(92, 11),
(92, 12),
(93, 11),
(94, 11),
(95, 11),
(95, 17),
(96, 7),
(97, 12),
(99, 6);

-- --------------------------------------------------------

--
-- Structure de la table `games_platforms`
--

CREATE TABLE `games_platforms` (
  `games_id` int(11) NOT NULL,
  `platforms_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `games_platforms`
--

INSERT INTO `games_platforms` (`games_id`, `platforms_id`) VALUES
(1, 1),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(4, 6),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(5, 6),
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(6, 5),
(7, 1),
(7, 2),
(7, 3),
(7, 4),
(7, 5),
(8, 1),
(8, 2),
(9, 1),
(9, 2),
(10, 1),
(10, 2),
(13, 3),
(15, 1),
(15, 4),
(15, 5),
(15, 6),
(16, 1),
(16, 2),
(16, 3),
(16, 4),
(16, 5),
(17, 1),
(17, 2),
(17, 3),
(17, 4),
(17, 5),
(17, 6),
(18, 1),
(18, 2),
(18, 3),
(18, 4),
(18, 5),
(19, 1),
(19, 2),
(19, 3),
(19, 4),
(19, 5),
(20, 1),
(20, 2),
(20, 3),
(20, 4),
(20, 5),
(20, 6),
(20, 7),
(21, 1),
(21, 2),
(21, 3),
(21, 4),
(21, 5),
(21, 6),
(22, 1),
(22, 2),
(22, 3),
(22, 4),
(22, 5),
(22, 6),
(23, 1),
(23, 2),
(23, 3),
(23, 4),
(23, 5),
(24, 1),
(25, 1),
(26, 1),
(26, 7),
(27, 1),
(28, 1),
(29, 1),
(29, 2),
(29, 3),
(29, 4),
(29, 5),
(30, 1),
(30, 2),
(30, 3),
(30, 4),
(30, 5),
(30, 6),
(34, 1),
(34, 2),
(34, 3),
(34, 4),
(34, 5),
(34, 6),
(34, 7),
(35, 1),
(35, 2),
(35, 3),
(35, 4),
(35, 5),
(35, 6),
(35, 7),
(36, 1),
(36, 2),
(36, 3),
(36, 4),
(36, 5),
(36, 6),
(37, 1),
(37, 2),
(37, 3),
(37, 4),
(37, 5),
(37, 6),
(38, 1),
(38, 2),
(38, 3),
(38, 4),
(38, 5),
(38, 6),
(40, 2),
(43, 1),
(43, 2),
(44, 1),
(44, 2),
(45, 1),
(45, 2),
(46, 2),
(47, 2),
(55, 1),
(55, 2),
(55, 3),
(56, 1),
(56, 2),
(56, 3),
(56, 4),
(56, 5),
(56, 6),
(59, 1),
(59, 4),
(59, 5),
(59, 6),
(60, 1),
(60, 2),
(60, 4),
(60, 5),
(61, 1),
(62, 1),
(62, 4),
(62, 5),
(63, 1),
(64, 1),
(65, 1),
(65, 2),
(65, 3),
(65, 4),
(65, 5),
(65, 6),
(67, 6),
(68, 1),
(68, 2),
(68, 3),
(68, 4),
(68, 5),
(69, 6),
(70, 6),
(71, 6),
(72, 6),
(73, 6),
(74, 6),
(75, 6),
(76, 6),
(79, 1),
(79, 2),
(79, 3),
(79, 4),
(79, 5),
(79, 6),
(80, 1),
(80, 2),
(80, 3),
(80, 4),
(80, 5),
(84, 1),
(84, 2),
(84, 3),
(84, 4),
(84, 5),
(84, 6),
(85, 1),
(85, 2),
(85, 3),
(85, 4),
(85, 5),
(85, 6),
(86, 1),
(86, 2),
(86, 3),
(86, 4),
(86, 5),
(86, 6),
(86, 7),
(87, 1),
(88, 1),
(89, 1),
(89, 4),
(89, 5),
(90, 1),
(90, 2),
(90, 3),
(90, 4),
(90, 5),
(90, 6),
(91, 1),
(91, 2),
(91, 3),
(91, 4),
(91, 5),
(91, 6),
(92, 1),
(92, 2),
(92, 3),
(92, 4),
(92, 5),
(93, 1),
(93, 2),
(93, 3),
(93, 4),
(93, 5),
(94, 1),
(94, 2),
(94, 3),
(94, 4),
(94, 5),
(94, 6),
(95, 1),
(95, 4),
(95, 5),
(96, 1),
(97, 1),
(97, 2),
(97, 3),
(97, 4),
(97, 5),
(97, 6),
(98, 1),
(99, 1);

-- --------------------------------------------------------

--
-- Structure de la table `games_studios`
--

CREATE TABLE `games_studios` (
  `studios_id` int(11) NOT NULL,
  `games_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `games_studios`
--

INSERT INTO `games_studios` (`studios_id`, `games_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(3, 5),
(1, 6),
(5, 7),
(6, 8),
(7, 9),
(8, 10),
(5, 11),
(5, 12),
(5, 13),
(9, 14),
(10, 15),
(10, 16),
(11, 17),
(12, 18),
(13, 19),
(14, 20),
(15, 21),
(16, 22),
(11, 23),
(17, 24),
(18, 25),
(18, 26),
(16, 27),
(16, 28),
(19, 29),
(20, 30),
(21, 31),
(16, 32),
(22, 34),
(23, 35),
(24, 36),
(24, 37),
(25, 38),
(24, 39),
(24, 40),
(24, 41),
(26, 42),
(27, 43),
(28, 44),
(7, 45),
(28, 46),
(5, 47),
(21, 48),
(29, 49),
(19, 50),
(21, 51),
(24, 52),
(30, 53),
(30, 54),
(31, 55),
(31, 56),
(24, 57),
(24, 58),
(32, 59),
(32, 60),
(33, 61),
(24, 62),
(24, 63),
(24, 64),
(34, 64),
(35, 65),
(24, 66),
(24, 67),
(36, 68),
(4, 69),
(4, 70),
(4, 71),
(4, 72),
(4, 73),
(4, 74),
(4, 75),
(4, 76),
(24, 77),
(37, 79),
(37, 80),
(24, 81),
(38, 82),
(38, 83),
(39, 84),
(40, 85),
(41, 86),
(42, 87),
(43, 88),
(44, 89),
(45, 90),
(46, 91),
(47, 92),
(48, 93),
(49, 94),
(50, 95),
(51, 96),
(17, 97),
(17, 98),
(24, 99);

-- --------------------------------------------------------

--
-- Structure de la table `platforms`
--

CREATE TABLE `platforms` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `platforms`
--

INSERT INTO `platforms` (`id`, `name`) VALUES
(1, 'PC'),
(2, 'PlayStation 5'),
(3, 'PlayStation 4'),
(4, 'Xbox Series X/S'),
(5, 'Xbox One'),
(6, 'Nintendo Switch'),
(7, 'Mobile');

-- --------------------------------------------------------

--
-- Structure de la table `studios`
--

CREATE TABLE `studios` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `studios`
--

INSERT INTO `studios` (`id`, `name`) VALUES
(1, 'CD Projekt Red'),
(2, 'Mojang Studios'),
(3, 'Rockstar Games'),
(4, 'Nintendo'),
(5, 'FromSoftware'),
(6, 'Sony Santa Monica'),
(7, 'Naughty Dog'),
(8, 'Guerrilla Games'),
(9, 'Capcom'),
(10, 'Bethesda Game Studios'),
(11, 'Ubisoft'),
(12, 'Activision'),
(13, 'DICE'),
(14, 'Epic Games'),
(15, 'Respawn Entertainment'),
(16, 'Blizzard Entertainment'),
(17, 'Valve'),
(18, 'Riot Games'),
(19, 'Square Enix'),
(20, 'Bungie'),
(21, 'Bandai Namco'),
(22, 'ConcernedApe'),
(23, 'Re-Logic'),
(24, 'Team Cherry'),
(25, 'Supergiant Games'),
(26, 'Kojima Productions'),
(27, 'Sucker Punch Productions'),
(28, 'Insomniac Games'),
(29, 'Atlus'),
(30, 'miHoYo'),
(31, 'Larian Studios'),
(32, 'Firaxis Games'),
(33, 'Creative Assembly'),
(34, 'Paradox Interactive'),
(35, 'Colossal Order'),
(36, 'Maxis'),
(37, 'Hazelight Studios'),
(38, 'Moon Studios'),
(39, 'Psyonix'),
(40, 'Mediatonic'),
(41, 'InnerSloth'),
(42, 'Kinetic Games'),
(43, 'Zeekerss'),
(44, 'Rare'),
(45, 'Hello Games'),
(46, 'Unknown Worlds'),
(47, 'Endnight Games'),
(48, 'Facepunch Studios'),
(49, 'Studio Wildcard'),
(50, 'Iron Gate Studio'),
(51, 'Coffee Stain Studios'),
(52, 'Wube Software'),
(53, 'Ludeon Studios');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `birthdate`, `bio`, `created_at`, `is_admin`) VALUES
(1, 'loann', '$2y$12$FoElDFSjKCY0cwPEGHViQe0SSFmL18D6sqKOKPVflfuHezEBI35my', 'loann.juillerat@heig-vd.ch', '1993-06-25', 'Labubu', '2025-11-17 14:05:31', 1),
(9, 'lolo23', '$2y$12$Tun99p.aqyGASGRsXwa5qumAH6WL8u6ainIUSeC7/4QVZY/qAytkC', 'loannjuillerat@gmail.com', '1999-06-25', '1345', '2025-11-24 19:02:59', 0),
(10, 'ludelafo', '$2y$12$3QLu9J.1BGs/aWGwvhCIHe7sNeiR3ddTNQP24e3ilg3vX5Cj/xQ9K', 'ludovic.delafontaine@gmail.com', '2025-11-25', 'Yay', '2025-11-25 13:48:20', 1),
(11, 'elia', '$2y$12$5xdrsGx.H1hESCoo9taThemwR9Y5LvuJXuI5XCb13RHZzzcWQqWpu', 'elia.nicolo14@gmail.com', '2002-09-14', 'Les jeux vidéos c\'est super chouette ', '2025-12-16 14:38:46', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users_favorites`
--

CREATE TABLE `users_favorites` (
  `users_id` int(11) NOT NULL,
  `games_id` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `games_categories`
--
ALTER TABLE `games_categories`
  ADD PRIMARY KEY (`games_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Index pour la table `games_platforms`
--
ALTER TABLE `games_platforms`
  ADD PRIMARY KEY (`games_id`,`platforms_id`),
  ADD KEY `platform_id` (`platforms_id`);

--
-- Index pour la table `games_studios`
--
ALTER TABLE `games_studios`
  ADD PRIMARY KEY (`games_id`,`studios_id`),
  ADD KEY `studios_id` (`studios_id`);

--
-- Index pour la table `platforms`
--
ALTER TABLE `platforms`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `studios`
--
ALTER TABLE `studios`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `users_favorites`
--
ALTER TABLE `users_favorites`
  ADD PRIMARY KEY (`users_id`,`games_id`),
  ADD KEY `game_id` (`games_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `game`
--
ALTER TABLE `game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT pour la table `platforms`
--
ALTER TABLE `platforms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `studios`
--
ALTER TABLE `studios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `games_categories`
--
ALTER TABLE `games_categories`
  ADD CONSTRAINT `games_categories_ibfk_1` FOREIGN KEY (`games_id`) REFERENCES `games` (`id`),
  ADD CONSTRAINT `games_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `games_platforms`
--
ALTER TABLE `games_platforms`
  ADD CONSTRAINT `games_platforms_ibfk_1` FOREIGN KEY (`games_id`) REFERENCES `games` (`id`),
  ADD CONSTRAINT `games_platforms_ibfk_2` FOREIGN KEY (`platforms_id`) REFERENCES `platforms` (`id`);

--
-- Contraintes pour la table `games_studios`
--
ALTER TABLE `games_studios`
  ADD CONSTRAINT `games_studios_ibfk_1` FOREIGN KEY (`games_id`) REFERENCES `games` (`id`),
  ADD CONSTRAINT `games_studios_ibfk_2` FOREIGN KEY (`studios_id`) REFERENCES `studios` (`id`);

--
-- Contraintes pour la table `users_favorites`
--
ALTER TABLE `users_favorites`
  ADD CONSTRAINT `users_favorites_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_favorites_ibfk_2` FOREIGN KEY (`games_id`) REFERENCES `games` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
