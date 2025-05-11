-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : lamp_mysql
-- Généré le : dim. 11 mai 2025 à 22:26
-- Version du serveur : 8.0.41
-- Version de PHP : 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `Utilisateur`
--

-- --------------------------------------------------------

--
-- Structure de la table `film`
--

CREATE TABLE `film` (
  `id` int NOT NULL,
  `title` varchar(250) NOT NULL,
  `synopsis` varchar(150) NOT NULL,
  `studio` varchar(255) NOT NULL,
  `img` blob NOT NULL,
  `img_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `film`
--

INSERT INTO `film` (`id`, `title`, `synopsis`, `studio`, `img`, `img_type`) VALUES
(1, 'LeBon', 'Western', 'moi', '', ''),
(2, 'Galaxy Defenders', 'Un groupe de héros défend la galaxie contre une invasion alien.', 'Star Studios', '', ''),
(3, 'Le Temps d’un Souvenir', 'Une histoire émouvante d’un homme qui voyage dans ses souvenirs.', 'Émotion Pictures', '', ''),
(4, 'Cyber Choc', 'Dans un futur dystopique, une intelligence artificielle prend le contrôle.', 'Future Film Corp', '', ''),
(5, 'Rires et Larmes', 'Une comédie dramatique sur la vie de deux frères très différents.', 'Studio du Rire', '', ''),
(6, 'Le Secret du Dragon Bleu', 'Une jeune fille découvre qu’elle est liée à une ancienne prophétie.', 'Mythic Entertainment', '', ''),
(7, 'Tempête sur Neptune', 'Un vaisseau spatial échoué doit survivre sur la planète Neptune.', 'Nova Films', '', ''),
(8, 'L’Écho des Ombres', 'Un détective enquête sur des meurtres étranges liés à un culte ancien.', 'Darkline Studios', '', ''),
(9, 'Dans les Nuages', 'Deux inconnus se rencontrent à bord d’un vol intercontinental.', 'LoveFilm Productions', '', ''),
(121, 'test', 'test', 'test', 0x666575722e6a7067, 'default'),
(122, 'test2', 'test2', 'test2', 0x666575722e6a7067, 'default');

-- --------------------------------------------------------

--
-- Structure de la table `perso`
--

CREATE TABLE `perso` (
  `id` int NOT NULL,
  `lore` varchar(250) NOT NULL,
  `famille` varchar(150) NOT NULL,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `perso`
--

INSERT INTO `perso` (`id`, `lore`, `famille`, `nom`) VALUES
(24, 'nlknlklkn', 'ui', 'yes'),
(25, '', 'caillault', 'jerem'),
(28, 'test', '1234', 'nolan'),
(29, 'setsetstsetstset', 'test', '0'),
(32, 'feur', 'test12', 'test12');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `login` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `login`, `email`, `password`, `role`) VALUES
(25, 'nolan', 'nolan.pichon87@gmail.com', '$2y$10$zraDilvJ35cTpABP1OWFx.ehqEejWPXUJOEU8dHfrMwZTtk3RVeQ.', 'admin'),
(27, 'yeslan', 'yeslan@yeslan.com', '$2y$10$1z.QptLuXO4ONf2BS3NeXeCESox34vkm9zYMcVplrXygsQgZz7svK', 'invite');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `synopsis` (`synopsis`);

--
-- Index pour la table `perso`
--
ALTER TABLE `perso`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `film`
--
ALTER TABLE `film`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT pour la table `perso`
--
ALTER TABLE `perso`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
