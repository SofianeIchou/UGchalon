-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 17 fév. 2021 à 16:09
-- Version du serveur :  5.7.24
-- Version de PHP : 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ugchalon`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210216141931', '2021-02-16 14:19:40', 23),
('DoctrineMigrations\\Version20210217095524', '2021-02-17 09:55:52', 44);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `register_date` datetime NOT NULL,
  `is_verified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `firstname`, `lastname`, `register_date`, `is_verified`) VALUES
(1, 'jean@castex.fr', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$Lk1SUVMzcVdveldtbVBMeg$kzzKz8Mu+VhK6K+5wUkbI48T9sZtCk8nambQvnQX08I', 'jean', 'castex', '2021-02-17 10:40:08', 0),
(2, 'aa@a.a', '[]', '$argon2id$v=19$m=65536,t=4,p=1$dFJsTWR6dHJrQWVDbHRVYg$azlh6rhhZ95Jlwz4TKg09ADYLojUhApcWn8um95IHTs', 'aa', 'aa', '2021-02-17 10:51:59', 0),
(3, 'b@b.b', '[]', '$argon2id$v=19$m=65536,t=4,p=1$Z2p6TjIvdWViMHYyS0VMaQ$swCIX5hMGoBrSA74pAcFzOayJ37znURJ7hKPLXPToa4', 'bb', 'bb', '2021-02-17 10:58:22', 0),
(4, 'cc@cc.cc', '[]', '$argon2id$v=19$m=65536,t=4,p=1$enVhSlZWMmR6QkxtQ1BabA$bMgyoST1V/whe6IwwgQ7fCNtRwH/R+bUrdsK6ek5u4s', 'cc', 'cc', '2021-02-17 11:00:16', 0),
(5, 'dd@dd.dd', '[]', '$argon2id$v=19$m=65536,t=4,p=1$RE13VlhQWGFMUUxwOGxJcg$P3AJlHh4Fz5QQgAzwSEx29MwFFsQ7npiA86+xcUaWtk', 'dd', 'dd', '2021-02-17 11:59:05', 1),
(6, 'ee@ee.ee', '[]', '$argon2id$v=19$m=65536,t=4,p=1$OXdrbHVjTEJydk8yemEvNg$eMsl1kItvHeCG4jKowcNrunlYHp/hKYTspX3EO14nGs', 'ee', 'ee', '2021-02-17 14:34:23', 0),
(7, 'ff@ff.ff', '[]', '$argon2id$v=19$m=65536,t=4,p=1$S2JYR1QwczZyMlBST2IuOQ$wt6daLlax6K1/a1TYZqNJpFuuETiSUz7jdRX1ySduVs', 'ff', 'ff', '2021-02-17 15:49:16', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
