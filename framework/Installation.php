<?php

class Installation extends Connexion
{
    public function showTables()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SHOW TABLES');
        $statement->execute();
        return $statement->fetchAll();
    }

    public function installCategoriesTable()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('DROP TABLE IF EXISTS `categories`');
        $statement->execute();

        $statement = $bdd->prepare('CREATE TABLE IF NOT EXISTS `categories` 
                                                (
                                                  `id` int(10) NOT NULL AUTO_INCREMENT,
                                                  `category` varchar(155) NOT NULL,
                                                  PRIMARY KEY (`id`),
                                                  KEY `category` (`category`)
                                                ) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=latin1');
        $statement->execute();
    }

    public function installCommentsTable()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('DROP TABLE IF EXISTS `comments`');
        $statement->execute();

        $statement = $bdd->prepare('CREATE TABLE IF NOT EXISTS `comments` 
                                                (
                                                  `id` int(10) NOT NULL AUTO_INCREMENT,
                                                  `id_post` int(10) NOT NULL,
                                                  `id_user` int(10) NOT NULL,
                                                  `created_at` datetime DEFAULT NULL,
                                                  `title` varchar(155) NOT NULL,
                                                  `content` text NOT NULL,
                                                  `state` tinyint(4) NOT NULL DEFAULT \'0\' COMMENT \'0 en attente - 1 valide - 2 archive - 3 suppression\',
                                                  PRIMARY KEY (`id`),
                                                  KEY `state` (`state`),
                                                  KEY `lien_post_comment` (`id_post`),
                                                  KEY `lien_comment_author` (`id_user`)
                                                ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1');
        $statement->execute();
    }

    public function installFavoritesTable()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('DROP TABLE IF EXISTS `favorites_posts`');
        $statement->execute();

        $statement = $bdd->prepare('CREATE TABLE IF NOT EXISTS `favorites_posts` 
                                                (
                                                  `id` int(11) NOT NULL AUTO_INCREMENT,
                                                  `id_user` int(11) NOT NULL,
                                                  `id_post` int(11) NOT NULL,
                                                  PRIMARY KEY (`id`),
                                                  UNIQUE KEY `id_user` (`id_user`,`id_post`) USING BTREE
                                                ) ENGINE=InnoDB DEFAULT CHARSET=latin1');
        $statement->execute();
    }

    public function installPortfolioTable()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('DROP TABLE IF EXISTS `portfolio`');
        $statement->execute();

        $statement = $bdd->prepare('CREATE TABLE IF NOT EXISTS `portfolio` 
                                                (
                                                  `id` int(10) NOT NULL AUTO_INCREMENT,
                                                  `title` varchar(155) NOT NULL,
                                                  `kicker` tinytext NOT NULL,
                                                  `content` text NOT NULL,
                                                  `date_conception` year(4) NOT NULL,
                                                  `client` tinytext NOT NULL,
                                                  `categories` tinytext NOT NULL,
                                                  PRIMARY KEY (`id`)
                                                ) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1');
        $statement->execute();
    }

    public function installPostsTable()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('DROP TABLE IF EXISTS `posts`');
        $statement->execute();

        $statement = $bdd->prepare('CREATE TABLE IF NOT EXISTS `posts` 
                                                (
                                                  `id` int(10) NOT NULL AUTO_INCREMENT,
                                                  `title` varchar(155) NOT NULL,
                                                  `kicker` tinytext NOT NULL,
                                                  `author` int(10) NOT NULL,
                                                  `content` longtext NOT NULL,
                                                  `url` varchar(155) DEFAULT NULL,
                                                  `created_at` date NOT NULL,
                                                  `modified_at` datetime NOT NULL,
                                                  `id_category` int(10) NOT NULL,
                                                  `state` tinyint(1) NOT NULL DEFAULT \'0\' COMMENT \'0 en attente - 1 valide - 2 archive - 3 suppression\',
                                                  PRIMARY KEY (`id`),
                                                  KEY `title` (`title`,`kicker`(255)),
                                                  KEY `modified_at` (`modified_at`),
                                                  KEY `id_category` (`id_category`),
                                                  KEY `created_at` (`created_at`),
                                                  KEY `lien_author_posts` (`author`)
                                                ) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1');
        $statement->execute();
    }

    public function installTokensTable()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('DROP TABLE IF EXISTS `tokens`');
        $statement->execute();

        $statement = $bdd->prepare('CREATE TABLE IF NOT EXISTS `tokens` 
                                                (
                                                  `id_token` int(10) NOT NULL AUTO_INCREMENT,
                                                  `token` varchar(150) NOT NULL,
                                                  `id_user` int(10) NOT NULL,
                                                  `expiration_token` datetime NOT NULL,
                                                  PRIMARY KEY (`id_token`),
                                                  UNIQUE KEY `id_user` (`id_user`),
                                                  UNIQUE KEY `token` (`token`,`id_user`)
                                                ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1');
        $statement->execute();
    }


    public function installUsersTable()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('DROP TABLE IF EXISTS `users`');
        $statement->execute();

        $statement = $bdd->prepare('CREATE TABLE IF NOT EXISTS `users` 
                                                (
                                                  `id` int(10) NOT NULL AUTO_INCREMENT,
                                                  `pseudo` varchar(155) NOT NULL,
                                                  `role` tinyint(1) NOT NULL DEFAULT \'2\' COMMENT \'1 - admin 2 - user\',
                                                  `email` varchar(155) NOT NULL,
                                                  `password` varchar(155) NOT NULL,
                                                  `date_modification` datetime NOT NULL,
                                                  `date_inscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                                  `cgu` tinyint(1) NOT NULL,
                                                  `state` tinyint(1) NOT NULL DEFAULT \'0\' COMMENT \'0 validation utilisateur demandée - 1 validation moderateur demandée - 2 - validé - 3 - suppression\',
                                                  PRIMARY KEY (`id`),
                                                  UNIQUE KEY `email` (`email`),
                                                  KEY `state` (`state`),
                                                  KEY `pseudo` (`pseudo`)
                                                ) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1');
        $statement->execute();
    }

    public function addConstraints()
    {
        $bdd = $this->dbConnect();

        $statement = $bdd->prepare('ALTER TABLE `comments`
                                                ADD CONSTRAINT `lien_comment_author` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
                                                ADD CONSTRAINT `lien_post_comment` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE');
        $statement->execute();

        $statement = $bdd->prepare('ALTER TABLE `favorites_posts`
                                                ADD CONSTRAINT `lien_favorites_posts_author` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE');
        $statement->execute();

        $statement = $bdd->prepare('ALTER TABLE `posts`
                                                ADD CONSTRAINT `lien_author_posts` FOREIGN KEY (`author`) REFERENCES `users` (`id`) ON UPDATE CASCADE');
        $statement->execute();

        $statement = $bdd->prepare('ALTER TABLE `posts` 
                                                ADD CONSTRAINT `lien_categories_posts` FOREIGN KEY (`id_category`) REFERENCES `categories`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE');

        $statement->execute();

        $statement = $bdd->prepare('ALTER TABLE `tokens`
                                                ADD CONSTRAINT `lien_user_token` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE');
        $statement->execute();
    }

    public function installData()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('INSERT INTO `categories` (`id`, `category`) VALUES
                                                    (11, \'administratif\'),
                                                    (10, \'applications mobiles\'),
                                                    (16, \'autres\'),
                                                    (4, \'e-commerce\'),
                                                    (6, \'emailing\'),
                                                    (7, \'gestion de projet\'),
                                                    (1, \'graphismes, design\'),
                                                    (14, \'growth hacking\'),
                                                    (3, \'landing page\'),
                                                    (13, \'marketing, analytique\'),
                                                    (15, \'médias\'),
                                                    (18, \'php & sql\'),
                                                    (2, \'prototypage\'),
                                                    (12, \'ressources humaines\'),
                                                    (100, \'Sans catégorie\'),
                                                    (99, \'sécurité\'),
                                                    (5, \'social media\'),
                                                    (8, \'vente\'),
                                                    (17, \'wordpress\')');
        $statement->execute();

        $statement = $bdd->prepare('INSERT INTO `portfolio` (`id`, `title`, `kicker`, `content`, `date_conception`, `client`, `categories`) VALUES
                                                        (1, \'La cuisine de Cécile\', \'Conception d un site internet en php . \', \'Conception d un site en php pour un projet de fin d études.\', 2011, \'La cuisine de Cécile\', \'Html/css/php\'),
                                                        (2, \'Festival Jazz à Juan-les-pins\', \'Intégration web pour Constellation Network.\', \'Intégration web en Xtml à partir d une maquette créée par le graphiste . \', 2011, \'Ville de Juan-les-pins\', \'Intégration\'),
                                                        (3, \'Gîtes de France\', \'Intégration web pour Constellation Network.\', \'Intégration web en Xhtml à partir de la charte graphique des gîtes de France.\', 2011, \'Gîtes de France Ardèche\', \'Intégration\'),
                                                        (4, \'Projet n°2\', \'Intégration d un thème wordpress . \', \'Intégration d un thème wordpress(au choix) pour le cadre d un projet OpenClassrooms.\', 2017, \'Chalets & Caviar (projet fictif)\', \'Intégration/wordpress\'),
                                                        (5, \'Projet n°3\', \'Création d un site en html & css . \', \'Création d un site web en html 5 et Css 3, responsive pour le cadre d un projet OpenClassrooms (j ai aussi créé la maquette).\', 2017, \'Festival des films plein air (projet fictif)\', \'html/css\'),
                                                        (6, \'Projet n°4\', \'Conception de solution technique d une application . \', \'Conception de diagrammes UML et modélisation de la base de données.\', 2017, \'Express Food (projet fictif)\', \'Conception UML\'),
                                                        (7, \'Projet n°5\', \'Conception d un blog responsive en php . \', \'Conception de diagrammes UML, modélisation de la bdd et site en php.\', 2020, \'Riwalenn Bas\', \'Conception UML/bootstrap/php\'),
                                                        (8, \'Paperfly\', \'Conception d un blog responsive en php . \', \'Conception de diagrammes UML, modélisation de la bdd et site en php.\', 2019, \'Mickaël R.\', \'Conception UML/bootstrap/php\')');
        $statement->execute();

        $statement = $bdd->prepare('INSERT INTO `users` (`id`, `pseudo`, `role`, `email`, `password`, `date_modification`, `date_inscription`, `cgu`, `state`) VALUES
                                                    (1, \'Compte-Admin\', 1, \'admin@gmail.com\', \'$2y$10$iBDBBcm8ZzVjbyh98bgSGuiHAao5dfRMiAQAAxYU4t8PWoiFrDHhe\', \'2020-05-12 14:43:59\', \'2019-12-01 16:37:47\', 1, 2),
                                                    (2, \'Anonyme\', 2, \'no-reply@riwalennbas.com\', \'$2y$10$sT/NGEIrb8z5XwCvPv9NpeeF3fuge7Vyyf4AWIEQPr7ZWmuJIS2gC\', \'2019-12-01 00:00:00\', \'2019-12-01 21:48:31\', 1, 2),
                                                    (4, \'Compte-User\', 2, \'user@gmail.com\', \'$2y$10$oCwODFhW5hoq2zAXKFpgeOaRENHAd2oSJ6wcKMd1.6yQtCyBFW35W\', \'2020-05-12 14:43:15\', \'2019-12-01 15:04:47\', 1, 2),
                                                    (5, \'test0\', 2, \'test1@gmail.com\', \'$2y$10$ixuvHwqwn65wW9PCVIQKLeTupGZjv74qQKWdkuB6BZOr.IZnY.gi6\', \'2020-04-06 10:58:42\', \'2020-04-06 10:58:42\', 1, 0),
                                                    (6, \'test1\', 2, \'test2@gmail.com\', \'$2y$10$ixuvHwqwn65wW9PCVIQKLeTupGZjv74qQKWdkuB6BZOr.IZnY.gi6\', \'2020-05-07 13:41:44\', \'2019-12-01 10:58:42\', 1, 1),
                                                    (7, \'test2\', 2, \'test3@gmail.com\', \'$2y$10$ixuvHwqwn65wW9PCVIQKLeTupGZjv74qQKWdkuB6BZOr.IZnY.gi6\', \'2020-05-07 11:59:51\', \'2019-12-01 10:58:42\', 1, 2),
                                                    (8, \'CommentsTest\', 2, \'commentsTest@gmail.com\', \'$2y$10$ixuvHwqwn65wW9PCVIQKLeTupGZjv74qQKWdkuB6BZOr.IZnY.gi6\', \'2020-05-06 14:14:10\', \'2020-04-06 10:58:42\', 1, 1)');
        $statement->execute();

        $statement = $bdd->prepare('INSERT INTO `posts` (`id`, `title`, `kicker`, `author`, `content`, `url`, `created_at`, `modified_at`, `id_category`, `state`) VALUES
(1, \'Erat autem diritatis\', \'Erat autem diritatis eius hoc quoque indicium nec obscurum nec latens\', 1, \'Erat autem diritatis eius hoc quoque indicium nec obscurum nec latens, quod ludicris cruentis delectabatur et in circo sex vel septem aliquotiens vetitis certaminibus pugilum vicissim se concidentium perfusorumque sanguine specie ut lucratus ingentia laetabatur.\', \'\', \'2019-12-15\', \'2020-04-30 14:23:39\', 1, 1),
(2, \'Hoc inmaturo interitu\', \'Hoc inmaturo interitu ipse quoque sui pertaesus excessit e vita aetatis nono anno atque vicensimo\', 1, \'Hoc inmaturo interitu ipse quoque sui pertaesus excessit e vita aetatis nono anno atque vicensimo cum quadriennio imperasset. natus apud Tuscos in Massa Veternensi, patre Constantio Constantini fratre imperatoris, matreque Galla sorore Rufini et Cerealis, quos trabeae consulares nobilitarunt et praefecturae.\', \'\', \'2019-12-20\', \'2020-04-30 14:23:48\', 5, 1),
(3, \'Post emensos\', \'Post emensos insuperabilis expeditionis eventus languentibus partium animis\', 1, \'Post emensos insuperabilis expeditionis eventus languentibus partium animis, quas periculorum varietas fregerat et laborum, nondum tubarum cessante clangore vel milite locato per stationes hibernas, fortunae saevientis procellae tempestates alias rebus infudere communibus per multa illa et dira facinora Caesaris Galli, qui ex squalore imo miseriarum in aetatis adultae primitiis ad principale culmen insperato saltu provectus ultra terminos potestatis delatae procurrens asperitate nimia cuncta foedabat. propinquitate enim regiae stirpis gentilitateque etiam tum Constantini nominis efferebatur in fastus, si plus valuisset, ausurus hostilia in auctorem suae felicitatis, ut videbatur.\', \'\', \'2019-12-23\', \'2020-04-30 14:24:01\', 1, 1),
(4, \'Hoc inmaturo interitu\', \'Hoc inmaturo interitu ipse quoque sui pertaesus excessit e vita aetatis nono anno atque vicensimo cum \', 1, \'Hoc inmaturo interitu ipse quoque sui pertaesus excessit e vita aetatis nono anno atque vicensimo cum quadriennio imperasset. natus apud Tuscos in Massa Veternensi, patre Constantio Constantini fratre imperatoris, matreque Galla sorore Rufini et Cerealis, quos trabeae consulares nobilitarunt et praefecturae.\', \'\', \'2020-01-05\', \'2020-04-30 14:24:10\', 1, 1),
(5, \'Sed maximum\', \'Sed maximum est in amicitia parem esse inferiori. Saepe enim excellentiae quaedam sun\', 1, \'Sed maximum est in amicitia parem esse inferiori. Saepe enim excellentiae quaedam sunt, qualis erat Scipionis in nostro, ut ita dicam, grege. Numquam se ille Philo, numquam Rupilio, numquam Mummio anteposuit, numquam inferioris ordinis amicis, Q. vero Maximum fratrem, egregium virum omnino, sibi nequaquam parem, quod is anteibat aetate, tamquam superiorem colebat suosque omnes per se posse esse ampliores volebat.\', \'\', \'2019-12-29\', \'2020-04-30 14:24:48\', 14, 1)');
        $statement->execute();

        $statement = $bdd->prepare('INSERT INTO `tokens` (`id_token`, `token`, `id_user`, `expiration_token`) VALUES
                                                    (3, \'046280e85dc8fef38b2565f29dc8d602da0137370d9cd4cde184be5fdf335265\', 5, \'2020-04-11 10:58:42\')');
        $statement->execute();

        $statement = $bdd->prepare('INSERT INTO `favorites_posts` (`id`, `id_user`, `id_post`) VALUES
                                                (1, 4, 1),
                                                (2, 4, 3)');
        $statement->execute();

        $statement = $bdd->prepare('INSERT INTO `comments` (`id`, `id_post`, `id_user`, `created_at`, `title`, `content`, `state`) VALUES
                                                (1, 4, 1, \'2020-05-18 11:50:31\', \'test\', \'test comm admin\', 1)');
        $statement->execute();
    }
}