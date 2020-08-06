-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 31 juil. 2020 à 07:22
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

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `category`) VALUES
(11, 'administratif'),
(10, 'applications mobiles'),
(16, 'autres'),
(4, 'e-commerce'),
(6, 'emailing'),
(7, 'gestion de projet'),
(1, 'graphismes, design'),
(14, 'growth hacking'),
(3, 'landing page'),
(13, 'marketing, analytique'),
(15, 'médias'),
(18, 'php & sql'),
(2, 'prototypage'),
(12, 'ressources humaines'),
(100, 'Sans catégorie'),
(99, 'sécurité'),
(5, 'social media'),
(8, 'vente'),
(17, 'wordpress');

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
-- Structure de la table `favorites_posts`
--

DROP TABLE IF EXISTS `favorites_posts`;
CREATE TABLE IF NOT EXISTS `favorites_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_user` (`id_user`,`id_post`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `folio_categories`
--

DROP TABLE IF EXISTS `folio_categories`;
CREATE TABLE IF NOT EXISTS `folio_categories` (
  `id_folio` int(10) NOT NULL,
  `id_folio_cat` int(10) NOT NULL,
  KEY `id_folio` (`id_folio`,`id_folio_cat`),
  KEY `folio_category` (`id_folio_cat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `folio_categories`
--

INSERT INTO `folio_categories` (`id_folio`, `id_folio_cat`) VALUES
(1, 1),
(1, 3),
(1, 4),
(2, 8),
(3, 8),
(4, 6),
(4, 8),
(5, 3),
(5, 4),
(6, 7),
(7, 1),
(7, 5),
(7, 7),
(8, 1),
(8, 5),
(8, 7);

-- --------------------------------------------------------

--
-- Structure de la table `folio_categoriesColor`
--

DROP TABLE IF EXISTS `folio_categories_color`;
CREATE TABLE IF NOT EXISTS `folio_categories_color` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category` varchar(20) NOT NULL,
  `color` varchar(10) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `folio_categoriesColor`
--

INSERT INTO `folio_categories_color` (`id`, `category`, `color`) VALUES
(1, 'php', '#4F5D95'),
(2, 'javascript', '#f1e05a'),
(3, 'css', '#563d7c'),
(4, 'html', '#e34c26'),
(5, 'bootstrap', '#7952b3'),
(6, 'wordpress', '#003c56'),
(7, 'uml', 'red'),
(8, 'intégration', 'green'),
(9, 'python', '#3572A5'),
(10, 'vue', '#2c3e50'),
(11, 'typeScript', '#2b7489'),
(12, 'java', '#b07219'),
(13, 'swift', '#ffac45'),
(14, 'c', '#178600');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `portfolio`
--

INSERT INTO `portfolio` (`id`, `title`, `kicker`, `content`, `date_conception`, `client`, `categories`) VALUES
(1, 'La cuisine de Cécile', 'Conception d\'un site internet en php.', 'Conception d\'un site en php pour un projet de fin d\'études.', 2011, 'La cuisine de Cécile', 'html/css/php'),
(2, 'Festival Jazz à Juan-les-pins', 'Intégration web pour Constellation Network.', 'Intégration web en Xtml à partir d\'une maquette créée par le graphiste.', 2011, 'Ville de Juan-les-pins', 'intégration'),
(3, 'Gîtes de France', 'Intégration web pour Constellation Network.', 'Intégration web en Xhtml à partir de la charte graphique des gîtes de France.', 2011, 'Gîtes de France Ardèche', 'intégration'),
(4, 'Projet n°2', 'Intégration d\'un thème wordpress.', 'Intégration d\'un thème wordpress (au choix) pour le cadre d\'un projet OpenClassrooms.', 2017, 'Chalets & Caviar (projet fictif)', 'intégration/wordpress'),
(5, 'Projet n°3', 'Création d\'un site en html & css.', 'Création d\'un site web en html 5 et Css 3, responsive pour le cadre d\'un projet OpenClassrooms (j\'ai aussi créé la maquette).', 2017, 'Festival des films plein air (projet fictif)', 'html/css'),
(6, 'Projet n°4', 'Conception de solution technique d\'une application.', 'Conception de diagrammes UML et modélisation de la base de données.', 2017, 'Express Food (projet fictif)', 'conception UML'),
(7, 'Projet n°5', 'Conception d\'un blog responsive en php.', 'Conception de diagrammes UML, modélisation de la bdd et site en php.<br>Système de favoris et fil d\'Arianne.', 2020, 'Riwalenn Bas', 'conception UML/bootstrap/php'),
(8, 'Paperfly', 'Conception d\'un blog responsive en php.', 'Conception de diagrammes UML, modélisation de la bdd et site en php.', 2019, 'Mickaël R.', 'conception UML/bootstrap/php');

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
  `url` varchar(155) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `kicker`, `author`, `content`, `url`, `created_at`, `modified_at`, `id_category`, `state`) VALUES
(1, 'Erat autem diritatis', 'Erat autem diritatis eius hoc quoque indicium nec obscurum nec latens', 1, 'Erat autem diritatis eius hoc quoque indicium nec obscurum nec latens, quod ludicris cruentis delectabatur et in circo sex vel septem aliquotiens vetitis certaminibus pugilum vicissim se concidentium perfusorumque sanguine specie ut lucratus ingentia laetabatur.\r\n\r\nHaec et huius modi quaedam innumerabilia ultrix facinorum impiorum bonorumque praemiatrix aliquotiens operatur Adrastia atque utinam semper quam vocabulo duplici etiam Nemesim appellamus: ius quoddam sublime numinis efficacis, humanarum mentium opinione lunari circulo superpositum, vel ut definiunt alii, substantialis tutela generali potentia partilibus praesidens fatis, quam theologi veteres fingentes Iustitiae filiam ex abdita quadam aeternitate tradunt omnia despectare terrena.\r\n\r\nCyprum itidem insulam procul a continenti discretam et portuosam inter municipia crebra urbes duae faciunt claram Salamis et Paphus, altera Iovis delubris altera Veneris templo insignis. tanta autem tamque multiplici fertilitate abundat rerum omnium eadem Cyprus ut nullius externi indigens adminiculi indigenis viribus a fundamento ipso carinae ad supremos usque carbasos aedificet onerariam navem omnibusque armamentis instructam mari committat.', '', '2019-12-15', '2020-04-30 14:23:39', 1, 1),
(2, 'Hoc inmaturo interitu', 'Hoc inmaturo interitu ipse quoque sui pertaesus excessit e vita aetatis nono anno atque vicensimo', 1, 'Hoc inmaturo interitu ipse quoque sui pertaesus excessit e vita aetatis nono anno atque vicensimo cum quadriennio imperasset. natus apud Tuscos in Massa Veternensi, patre Constantio Constantini fratre imperatoris, matreque Galla sorore Rufini et Cerealis, quos trabeae consulares nobilitarunt et praefecturae.\r\n\r\nNisi mihi Phaedrum, inquam, tu mentitum aut Zenonem putas, quorum utrumque audivi, cum mihi nihil sane praeter sedulitatem probarent, omnes mihi Epicuri sententiae satis notae sunt. atque eos, quos nominavi, cum Attico nostro frequenter audivi, cum miraretur ille quidem utrumque, Phaedrum autem etiam amaret, cotidieque inter nos ea, quae audiebamus, conferebamus, neque erat umquam controversia, quid ego intellegerem, sed quid probarem.\r\n\r\nQuod si rectum statuerimus vel concedere amicis, quidquid velint, vel impetrare ab iis, quidquid velimus, perfecta quidem sapientia si simus, nihil habeat res vitii; sed loquimur de iis amicis qui ante oculos sunt, quos vidimus aut de quibus memoriam accepimus, quos novit vita communis. Ex hoc numero nobis exempla sumenda sunt, et eorum quidem maxime qui ad sapientiam proxime accedunt.', '', '2019-12-20', '2020-04-30 14:23:48', 5, 1),
(3, 'Post emensos', 'Post emensos insuperabilis expeditionis eventus languentibus partium animis', 1, 'Post emensos insuperabilis expeditionis eventus languentibus partium animis, quas periculorum varietas fregerat et laborum, nondum tubarum cessante clangore vel milite locato per stationes hibernas, fortunae saevientis procellae tempestates alias rebus infudere communibus per multa illa et dira facinora Caesaris Galli, qui ex squalore imo miseriarum in aetatis adultae primitiis ad principale culmen insperato saltu provectus ultra terminos potestatis delatae procurrens asperitate nimia cuncta foedabat. propinquitate enim regiae stirpis gentilitateque etiam tum Constantini nominis efferebatur in fastus, si plus valuisset, ausurus hostilia in auctorem suae felicitatis, ut videbatur.\r\n\r\nOmitto iuris dictionem in libera civitate contra leges senatusque consulta; caedes relinquo; libidines praetereo, quarum acerbissimum extat indicium et ad insignem memoriam turpitudinis et paene ad iustum odium imperii nostri, quod constat nobilissimas virgines se in puteos abiecisse et morte voluntaria necessariam turpitudinem depulisse. Nec haec idcirco omitto, quod non gravissima sint, sed quia nunc sine teste dico.\r\n\r\nRogatus ad ultimum admissusque in consistorium ambage nulla praegressa inconsiderate et leviter proficiscere inquit ut praeceptum est, Caesar sciens quod si cessaveris, et tuas et palatii tui auferri iubebo prope diem annonas. hocque solo contumaciter dicto subiratus abscessit nec in conspectum eius postea venit saepius arcessitus.', '', '2019-12-23', '2020-04-30 14:24:01', 1, 1),
(4, 'Hoc inmaturo interitu', 'Hoc inmaturo interitu ipse quoque sui pertaesus excessit e vita aetatis nono anno atque vicensimo cum ', 1, 'Hoc inmaturo interitu ipse quoque sui pertaesus excessit e vita aetatis nono anno atque vicensimo cum quadriennio imperasset. natus apud Tuscos in Massa Veternensi, patre Constantio Constantini fratre imperatoris, matreque Galla sorore Rufini et Cerealis, quos trabeae consulares nobilitarunt et praefecturae.\r\n\r\nHaec dum oriens diu perferret, caeli reserato tepore Constantius consulatu suo septies et Caesaris ter egressus Arelate Valentiam petit, in Gundomadum et Vadomarium fratres Alamannorum reges arma moturus, quorum crebris excursibus vastabantur confines limitibus terrae Gallorum.\r\n\r\nNihil est enim virtute amabilius, nihil quod magis adliciat ad diligendum, quippe cum propter virtutem et probitatem etiam eos, quos numquam vidimus, quodam modo diligamus. Quis est qui C. Fabrici, M\'. Curi non cum caritate aliqua benevola memoriam usurpet, quos numquam viderit? quis autem est, qui Tarquinium Superbum, qui Sp. Cassium, Sp. Maelium non oderit? Cum duobus ducibus de imperio in Italia est decertatum, Pyrrho et Hannibale; ab altero propter probitatem eius non nimis alienos animos habemus, alterum propter crudelitatem semper haec civitas oderit.', '', '2020-01-05', '2020-04-30 14:24:10', 1, 1),
(5, 'Sed maximum', 'Sed maximum est in amicitia parem esse inferiori. Saepe enim excellentiae quaedam sun', 1, 'Sed maximum est in amicitia parem esse inferiori. Saepe enim excellentiae quaedam sunt, qualis erat Scipionis in nostro, ut ita dicam, grege. Numquam se ille Philo, numquam Rupilio, numquam Mummio anteposuit, numquam inferioris ordinis amicis, Q. vero Maximum fratrem, egregium virum omnino, sibi nequaquam parem, quod is anteibat aetate, tamquam superiorem colebat suosque omnes per se posse esse ampliores volebat.\r\n\r\nMartinus agens illas provincias pro praefectis aerumnas innocentium graviter gemens saepeque obsecrans, ut ab omni culpa inmunibus parceretur, cum non inpetraret, minabatur se discessurum: ut saltem id metuens perquisitor malivolus tandem desineret quieti coalitos homines in aperta pericula proiectare.\r\n\r\nQuam ob rem ut ii qui superiores sunt submittere se debent in amicitia, sic quodam modo inferiores extollere. Sunt enim quidam qui molestas amicitias faciunt, cum ipsi se contemni putant; quod non fere contingit nisi iis qui etiam contemnendos se arbitrantur; qui hac opinione non modo verbis sed etiam opere levandi sunt.', '', '2019-12-29', '2020-04-30 14:24:48', 14, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `role`, `email`, `password`, `date_modification`, `date_inscription`, `cgu`, `state`) VALUES
(1, 'Riwalenn', 1, 'riwalenn@gmail.com', '$2y$10$iBDBBcm8ZzVjbyh98bgSGuiHAao5dfRMiAQAAxYU4t8PWoiFrDHhe', '2020-07-30 09:08:33', '2019-12-01 16:37:47', 1, 2),
(2, 'Anonyme', 2, 'no-reply@riwalennbas.com', '$2y$10$sT/NGEIrb8z5XwCvPv9NpeeF3fuge7Vyyf4AWIEQPr7ZWmuJIS2gC', '2019-12-01 00:00:00', '2019-12-01 21:48:31', 1, 2),
(4, 'Compte-User', 2, 'user@gmail.com', '$2y$10$oCwODFhW5hoq2zAXKFpgeOaRENHAd2oSJ6wcKMd1.6yQtCyBFW35W', '2020-07-30 09:44:32', '2019-12-01 15:04:47', 1, 2);

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
-- Contraintes pour la table `favorites_posts`
--
ALTER TABLE `favorites_posts`
  ADD CONSTRAINT `lien_favorites_posts_author` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `folio_categories`
--
ALTER TABLE `folio_categories`
  ADD CONSTRAINT `folio_category` FOREIGN KEY (`id_folio_cat`) REFERENCES `folio_categories_color` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `folio_folio` FOREIGN KEY (`id_folio`) REFERENCES `portfolio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `lien_author_posts` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `lien_user_token` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
