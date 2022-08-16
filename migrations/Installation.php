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

    public function installPortfolioCategoriesColorTable()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('DROP TABLE IF EXISTS `folio_categories_color`');

        $statement = $bdd->prepare('DROP TABLE IF EXISTS `folio_categories_color`;
                                                CREATE TABLE IF NOT EXISTS `folio_categories_color` (
                                                  `id` int(10) NOT NULL AUTO_INCREMENT,
                                                  `category` varchar(20) NOT NULL,
                                                  `color` varchar(10) NOT NULL,
                                                  UNIQUE KEY `id` (`id`)
                                                ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');
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

        $statement = $bdd->prepare('ALTER TABLE `portfolio` ADD `codacy` TEXT NULL AFTER `client`');
        $statement->execute();

        $statement = $bdd->prepare('ALTER TABLE `portfolio` ADD `link` TEXT NULL AFTER `client`');
        $statement->execute();
    }

    public function installPortfolioCategoriesTable()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('DROP TABLE IF EXISTS `folio_categories`');
        $statement->execute();

        $statement = $bdd->prepare('CREATE TABLE IF NOT EXISTS `folio_categories` (
                                                  `id_folio` int(10) NOT NULL,
                                                  `id_folio_cat` int(10) NOT NULL,
                                                  KEY `id_folio` (`id_folio`,`id_folio_cat`),
                                                  KEY `folio_category` (`id_folio_cat`)
                                                ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');
        $statement->execute();

        $statement = $bdd->prepare('ALTER TABLE `folio_categories`
                                              ADD CONSTRAINT `folio_category` FOREIGN KEY (`id_folio_cat`) REFERENCES `folio_categories_color` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                                              ADD CONSTRAINT `folio_folio` FOREIGN KEY (`id_folio`) REFERENCES `portfolio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;');
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
                                                  `role` tinyint(1) NOT NULL DEFAULT \'2\' COMMENT \'1 - admin 2 - user 3 - author\',
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
}