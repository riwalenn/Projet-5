-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 12 mars 2020 à 20:45
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `oc_projets_n5`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category` varchar(155) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_post` int(10) NOT NULL,
  `id_user` int(10) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `title` varchar(155) NOT NULL,
  `content` text NOT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 en attente - 1 valide - 2 archive - 3 suppression',
  PRIMARY KEY (`id`),
  KEY `state` (`state`),
  KEY `lien_post_comment` (`id_post`),
  KEY `lien_comment_author` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `portfolio`
--

DROP TABLE IF EXISTS `portfolio`;
CREATE TABLE IF NOT EXISTS `portfolio` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(155) NOT NULL,
  `kicker` tinytext NOT NULL,
  `content` text NOT NULL,
  `date_conception` year(4) NOT NULL,
  `client` tinytext NOT NULL,
  `categories` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(155) NOT NULL,
  `kicker` tinytext NOT NULL,
  `author` int(10) NOT NULL,
  `content` longtext NOT NULL,
  `url` varchar(155) NOT NULL,
  `created_at` date NOT NULL,
  `modified_at` datetime NOT NULL,
  `id_category` int(10) NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 en attente - 1 valide - 2 archive - 3 suppression',
  PRIMARY KEY (`id`),
  KEY `title` (`title`,`kicker`(255)),
  KEY `modified_at` (`modified_at`),
  KEY `id_category` (`id_category`),
  KEY `created_at` (`created_at`),
  KEY `lien_author_posts` (`author`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tokens`
--

DROP TABLE IF EXISTS `tokens`;
CREATE TABLE IF NOT EXISTS `tokens` (
  `id_token` int(10) NOT NULL AUTO_INCREMENT,
  `token` varchar(150) NOT NULL,
  `id_user` int(10) NOT NULL,
  `expiration_token` datetime NOT NULL,
  PRIMARY KEY (`id_token`),
  UNIQUE KEY `id_user` (`id_user`),
  UNIQUE KEY `token` (`token`,`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(155) NOT NULL,
  `role` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1 - admin 2 - user',
  `email` varchar(155) NOT NULL,
  `password` varchar(155) NOT NULL,
  `date_modification` datetime NOT NULL,
  `date_inscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cgu` tinyint(1) NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 validation utilisateur demandée - 1 validation moderateur demandée - 2 - validé - 3 - suppression',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `state` (`state`),
  KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `lien_comment_author` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `lien_post_comment` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `lien_author_posts` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `lien_categories_posts` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `lien_user_token` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
