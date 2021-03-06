<?php


class DataInstallation extends Connexion
{
    public function installRelatedData()
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
                                                    (12, \'public humaines\'),
                                                    (100, \'Sans catégorie\'),
                                                    (99, \'sécurité\'),
                                                    (5, \'social media\'),
                                                    (8, \'vente\'),
                                                    (17, \'wordpress\')');
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

    public function installOthersData()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare("INSERT INTO `portfolio` (`id`, `title`, `kicker`, `content`, `date_conception`, `client`, `categories`) VALUES
                                                    (1, 'La cuisine de Cécile', 'Conception d\'un site internet en php.', 'Conception d\'un site en php pour un projet de fin d\'études.', 2011, 'La cuisine de Cécile', 'html/css/php'),
                                                    (2, 'Festival Jazz à Juan-les-pins', 'Intégration web pour Constellation Network.', 'Intégration web en Xtml à partir d\'une maquette créée par le graphiste.', 2011, 'Ville de Juan-les-pins', 'intégration'),
                                                    (3, 'Gîtes de France', 'Intégration web pour Constellation Network.', 'Intégration web en Xhtml à partir de la charte graphique des gîtes de France.', 2011, 'Gîtes de France Ardèche', 'intégration'),
                                                    (4, 'Projet n°2', 'Intégration d\'un thème wordpress.', 'Intégration d\'un thème wordpress (au choix) pour le cadre d\'un projet OpenClassrooms.', 2017, 'Chalets & Caviar (projet fictif)', 'wordpress/intégration'),
                                                    (5, 'Projet n°3', 'Création d\'un site en html & css.', 'Création d\'un site web en html 5 et Css 3, responsive pour le cadre d\'un projet OpenClassrooms (j\'ai aussi créé la maquette).', 2017, 'Festival des films plein air (projet fictif)', 'html/css'),
                                                    (6, 'Projet n°4', 'Conception de solution technique d\'une application.', 'Conception de diagrammes UML et modélisation de la base de données.', 2017, 'Express Food (projet fictif)', 'conception UML'),
                                                    (7, 'Projet n°5', 'Conception d\'un blog responsive en php.', 'Conception de diagrammes UML, modélisation de la bdd et site en php.<br>Système de favoris et fil d\'Arianne.', 2020, 'Riwalenn Bas', 'conception UML/bootstrap/php/javascript'),
                                                    (8, 'Projet n°6', 'Conception d\'un site communautaire sur le snowboarding.', 'Conception de diagrammes UML, modélisation de la bdd et créé avec le framework Symfony.', 2020, 'Jimmy Sweat (faux client)', 'symfony/twig/php/javascript/bootstrap/uml');
");
        $statement->execute();

        $statement = $bdd->prepare("INSERT INTO `folio_categories_color` (`id`, `category`, `color`) VALUES
                                                    (1, 'php', '#4F5D95'),
                                                    (2, 'javascript', '#f1e05a'),
                                                    (3, 'css', '#563d7c'),
                                                    (4, 'html', '#e34c26'),
                                                    (5, 'bootstrap 4.3', '#7952b3'),
                                                    (6, 'wordpress', '#003c56'),
                                                    (7, 'uml', 'red'),
                                                    (8, 'intégration', 'green'),
                                                    (9, 'python', '#3572A5'),
                                                    (10, 'vue', '#2c3e50'),
                                                    (11, 'typeScript', '#2b7489'),
                                                    (12, 'java', '#b07219'),
                                                    (13, 'swift', '#ffac45'),
                                                    (14, 'c', '#178600'),
                                                    (15, 'twig', '#bacf29'),
                                                    (16, 'tests unitaires', '#89e051'),
                                                    (17, 'css 3', '#563d7c'),
                                                    (18, 'html 5', '#e34c26'),
                                                    (19, 'bootstrap 4.5', '#7952b3');");
        $statement->execute();

        $statement = $bdd->prepare('INSERT INTO `folio_categories` (`id_folio`, `id_folio_cat`) VALUES
                                                    (1, 1),
                                                    (1, 3),
                                                    (1, 4),
                                                    (2, 3),
                                                    (2, 4),
                                                    (2, 8),
                                                    (3, 3),
                                                    (3, 4),
                                                    (3, 8),
                                                    (4, 3),
                                                    (4, 6),
                                                    (4, 8),
                                                    (5, 3),
                                                    (5, 4),
                                                    (6, 7),
                                                    (7, 2),
                                                    (7, 5),
                                                    (7, 7),
                                                    (7, 17),
                                                    (7, 18),
                                                    (8, 1),
                                                    (8, 2),
                                                    (8, 7),
                                                    (8, 15),
                                                    (8, 16),
                                                    (8, 17),
                                                    (8, 18);');
        $statement->execute();
    }
}