-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 02 fév. 2020 à 17:38
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

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `category`) VALUES
(1, 'graphismes, design'),
(2, 'prototypage'),
(3, 'landing page'),
(4, 'e-commerce'),
(5, 'social media'),
(6, 'emailing'),
(7, 'gestion de projet'),
(8, 'vente'),
(10, 'applications mobiles'),
(11, 'administratif'),
(12, 'ressources humaines'),
(13, 'marketing, analytique'),
(14, 'growth hacking'),
(15, 'médias'),
(16, 'autres'),
(17, 'wordpress'),
(18, 'php & sql'),
(99, 'sécurité');

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `id_post`, `id_user`, `created_at`, `title`, `content`, `state`) VALUES
(5, 1, 1, '2020-01-27 17:25:00', 'nop', 'retest', 1),
(4, 1, 2, '2020-01-26 16:24:00', 'TinEye ?', 'test', 1);

--
-- Déchargement des données de la table `portfolio`
--

INSERT INTO `portfolio` (`id`, `title`, `kicker`, `content`, `date_conception`, `client`, `categories`) VALUES
(1, 'La cuisine de Cécile', 'Conception d\'un site internet en php.', 'Conception d\'un site en php pour un projet de fin d\'études.', 2011, 'La cuisine de Cécile', 'Html/css/php'),
(2, 'Festival Jazz à Juan-les-pins', 'Intégration web pour Constellation Network.', 'Intégration web en Xtml à partir d\'une maquette créée par le graphiste.', 2011, 'Ville de Juan-les-pins', 'Intégration'),
(3, 'Gîtes de France', 'Intégration web pour Constellation Network.', 'Intégration web en Xhtml à partir de la charte graphique des gîtes de France.', 2011, 'Gîtes de France Ardèche', 'Intégration'),
(4, 'Projet n°2', 'Intégration d\'un thème wordpress.', 'Intégration d\'un thème wordpress (au choix) pour le cadre d\'un projet OpenClassrooms.', 2017, 'Chalets & Caviar (projet fictif)', 'Intégration/wordpress'),
(5, 'Projet n°3', 'Création d\'un site en html & css.', 'Création d\'un site web en html 5 et Css 3, responsive pour le cadre d\'un projet OpenClassrooms (j\'ai aussi créé la maquette).', 2017, 'Festival des films plein air (projet fictif)', 'html/css'),
(6, 'Projet n°4', 'Conception de solution technique d\'une application.', 'Conception de diagrammes UML et modélisation de la base de données.', 2017, 'Express Food (projet fictif)', 'Conception UML'),
(7, 'Projet n°5', 'Conception d\'un blog responsive en php.', 'Conception de diagrammes UML, modélisation de la bdd et site en php.', 2020, 'Riwalenn Bas', 'Conception UML/bootstrap/php'),
(8, 'Paperfly', 'Conception d\'un blog responsive en php.', 'Conception de diagrammes UML, modélisation de la bdd et site en php.', 2020, 'Mickaël R.', 'Conception UML/bootstrap/php');

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `kicker`, `author`, `content`, `url`, `created_at`, `modified_at`, `id_category`, `state`) VALUES
(1, 'Trouver la source d\'une image', 'Avec l\'afflux d\'informations relayé par internet, on ne sait pas toujours d\'où provient une image.', 1, '<b>TinEye</b> est un moteur de recherche d\'image inversé. Il vous suffit d\'upload ou copier le lien de l\'image dans le moteur et ce dernier fait le travail. Vos images ne sont pas sauvegardées par le moteur et une extension est disponible pour votre navigateur.\r\nVous pouvez filtrer la recherche par collection ou si elle fait partie du stock d\'une banque d\'image. <b>TinEye</b>compare, aussi, rapidement la différence entre 2 images.\r\nAvec <b>TinEye</b> vous n\'aurez plus aucun doute sur la provenance d\'une information.', 'https://www.tineye.com/', '2019-12-15', '2019-12-18 21:13:00', 1, 1),
(2, 'Gérer et analyser les groupes facebook', 'Obtenez des informations sur les groupes, rapports et archives de données, optimiser la publication', 1, 'Grytics vous permet de mesurer, prévoir et améliorer les performances, de gagner du temps pour vos rapports.\r\nGérer tous vos groupes au même endroit, coordonnez vos équipes, catégorisez avec un système de tags.\r\nOptimisez votre communication et partage social.\r\nL\'outil existe aussi pour workplace.', 'https://grytics.com/', '2019-12-20', '2019-12-20 17:41:00', 5, 1),
(3, 'Compresser une image pour le web', 'Lorsque l\'on créé un site internet, nous sommes souvent confrontés à des images trop lourdes qui feront ralentir le site.', 1, '<b>TinyPng</b> est un outil de compression d\'images intelligent. Vous y déposez vos images au format png (avec un poids maximum de 5Mb chacune, pour les fichiers jpeg vous pouvez vous rendre à cette adresse : <b>https://tinyjpg.com</b>) et il vous les compressera en réduisant le nombre de couleurs dans votre fichier. La transparence est tout à fait compatible.<br>\r\nL\'image est compressée à plus de 70% et vous n\'y verrez que du feu !<br>\r\nUne extension existe aussi pour Magento ainsi qu\'un plugin pour Wordpress.<br>\r\nLes images jpeg sont, quand à elles, compressées en enlevant les informations non nécessaires au fichier, la qualité restant intacte.<br>\r\n\r\n<img class=\"img-fluid d-block mx-auto\" src=\"ressources/img/articles/tiny-image.png\">', 'https://tinypng.com/', '2019-12-23', '2019-12-23 20:58:00', 1, 1),
(4, 'Banques d\'images', 'A la recherche d\'une image particulière ?', 1, 'Ci-dessous les liens de plusieurs banques d\'images (libres de droits ou payantes) :<br>\r\n- <a href=\"https://www.pexels.com/\">Pexels</a><br>\r\n- <a href=\"https://www.shutterstock.com/fr/search/\">Shutterstock</a><br>\r\n- <a href=\"https://deathtothestockphoto.com\">Deathtothestockphoto</a><br>\r\n- <a href=\"https://burst.shopify.com/\">Burst</a><br>\r\n- <a href=\"https://stock.adobe.com/fr/\">Adobe</a><br>\r\n- <a href=\"https://gratisography.com/\">Gratisography</a><br>\r\n- <a href=\" https://www.sitebuilderreport.com/stock-up\">Sitebuilderreport</a><br>\r\n- <a href=\"https://unsplash.com/\">Unsplash</a><br>\r\n- <a href=\"https://nos.twnsnd.co/\">Twnsnd</a><br>\r\n- <a href=\"https://stocksnap.io/\">Stocksnap</a><br>\r\n- <a href=\"https://www.flickr.com/\">Flickr</a><br>\r\n- <a href=\"https://500px.com/\">500px</a><br>\r\n- <a href=\"http://www.stickpng.com/\">Stickpng</a><br>\r\n- <a href=\"http://thestocks.im/\">The stocks</a><br>\r\n- <a href=\"https://www.everypixel.com/\">EveryPixel</a><br>\r\n- <a href=\"https://pixabay.com/\">Pixabay</a><br>\r\n- <a href=\"https://fr.fotolia.com/\">Fotolia</a><br>\r\n- <a href=\"https://www.istockphoto.com/fr\">Istockphoto</a><br>', '', '2020-01-05', '2020-01-05 19:42:00', 1, 1),
(5, 'Le référencement', 'Le référencement est important pour la visibilité de votre site internet sur les moteurs de recherche...', 1, 'Il y a deux sortes de référencements :<br>\r\n- le référencement naturel ou SEO,<br>\r\n- le référencement payant ou SEA.<br>\r\n\r\n<h3>Le SEO</h3>\r\nL’algorithme Google (qui est le moteur de recherche le plus utilisé en France), est tel qu\'il est important d\'avoir un SEO parfait. L\'algorithme analyse méticuleusement chaque requête de recherche effectuée afin de s\'améliorer avec le temps. Une fois les mots, dans la recherche, analysés, le moteur recherche les pages web correspondantes aux informations. Cette recherche est effectuée dans l\'index des sites pour y trouver les pages correspondantes à votre requête puis la pertinence dans la page (titres, sous-titres ou encore le corps du texte).<br>\r\nIl est évident que pour une recherche, il existe des millions de pages web correspondantes. L\'algorithme analyse une centaine de facteurs pour évaluer le degré de fiabilité d\'une page. Google a mis en place une page avec des consignes pour webmasters afin d\'éviter le blacklisting qui pourrait être fatal pour l\'avenir d\'un site, comme la répétition de mots-clé qui est interdite pour l\'algorithme.<br>\r\nCertains détails sont importants pour l\'algorithme, qui, par exemple, analyse si votre site s\'affiche correctement dans différents navigateurs, s\'il est responsive et si les temps de chargement sont acceptable.<br>\r\nDes outils comme <a href=\"https://developers.google.com/speed/pagespeed/insights/\">PageSpeed Insights</a> ou <a href=\"https://www.webpagetest.org/\">webPage Test</a> sont de simples tests permettant de savoir si le site est conforme ou pas.<br>\r\nEn de termes simples, créez un index avec des mots simples (normalement il ne devrait y avoir qu\'un seul mot pour un lien) pour que l\'algorithme lise rapidement ce dernier.<br>\r\n<br>\r\n<h3>Le SEA</h3>\r\nLe SEA est un achat de liens sponsorisés qui consiste à louer un espace publicitaire mis à disposition par les moteurs de recherche, cet espace se trouve généralement en haut de la recherche.\r\nQuelques sites intéressants :<br>\r\n<a href=\"https://referralhero.com/?ref=maitre\">ReferralHero</a><br>\r\n<a href=\"https://www.getambassador.com/\">GetAmbassador</a><br>\r\n<a href=\"https://www.referralcandy.com/\">ReferralCandy</a><br>\r\n<a href=\"https://viral-loops.com/\">Viral-loop</a><br>', 'https://www.google.com/search/howsearchworks/algorithms/', '2019-12-29', '2020-01-19 17:39:00', 14, 1),
(6, 'Créer un prototype', 'Le prototype est à la création de d\'applications ce que le \"bon à tirer\" est à l\'imprimerie !', 1, 'Aujourd\'hui, la création d\'un site web ou d\'une application passe forcement par la case prototypage.<br>\r\nLa création d\'une application ou d\'un site internet est assez complexe et demande une bonne gestion de projet avec une réflexion sur le projet détaillée au plus près des besoins client avec un solide prototypage en amont.<br>\r\nCi-dessous quelques logiciels de prototypage qui vous permettront de tester le rendu de vos maquettes :<br>\r\n- <a href=\"https://marvelapp.com/\">Marvel</a><br>\r\n- <a href=\"https://www.sketch.com/\">Sketch</a><br>\r\n- <a href=\"https://www.hotgloo.com/\">HotGloo</a><br>\r\n- <a href=\"https://principleformac.com/\">Principle for Mac</a><br>\r\n- <a href=\"https://moqups.com/\">Moqups</a><br>\r\n- <a href=\"https://proto.io/\">Proto.io</a><br>\r\n- <a href=\"https://www.framer.com/\">Framer X (Mac)</a><br>\r\n- <a href=\"https://www.axure.com/\">Axure</a><br>\r\n- <a href=\"https://www.invisionapp.com/\">InVision</a><br>\r\n- <a href=\"https://www.adobe.com/fr/products/xd.html\">Adobe Xd</a><br>\r\n- <a href=\"https://origami.design/\">Origami Studio</a><br>\r\n- <a href=\"https://www.flinto.com/\">Flinto</a><br>', '', '2020-01-20', '2020-01-20 19:24:00', 2, 1),
(7, 'Le mot de passe', 'Le mot de passe est un élément important de notre vie quotidienne, que ce soit de l\'ordre du privé ou du professionnel.', 1, 'Après 20 ans d\'expérience en informatique, je peux affirmer une chose. Les personnes ne prennent pas assez sérieusement la sécurité de leurs mots de passe.<br>\r\nCréer un mot de passe à partir d\'éléments de votre vie privée revient à laisser la porte de votre maison grande ouverte avec votre carte bleue posée sur la table.<br>\r\nÇa n\'a aucun sens de laisser sa porte ouverte comme ça n\'en a pas d\'avoir un mot de passe facile à craquer. Et pourtant je dirais que plus de 90% des utilisateurs ont un mot de passe facile à craquer.<br>\r\nVoici donc quelques conseils pour vous aider à mieux sécuriser votre vie dématérialisée. <a href=\"https://www.ssi.gouv.fr/guide/mot-de-passe/\">Quelques conseils de l\'ANSSI</a> :<br>\r\n- Utilisez un mot de passe unique pour chaque service. En particulier, l’utilisation d’un même mot de passe entre sa messagerie professionnelle et sa messagerie personnelle est impérativement à proscrire ;<br>\r\n- Choisissez un mot de passe qui n’a pas de lien avec vous (mot de passe composé d’un nom de société, d’une date de naissance, etc.) ;<br>\r\n- Ne demandez jamais à un tiers de générer pour vous un mot de passe ;<br>\r\n- Modifiez systématiquement et au plus tôt les mots de passe par défaut lorsque les systèmes en contiennent ;<br>\r\n-Renouvelez vos mots de passe avec une fréquence raisonnable. Tous les 90 jours est un bon compromis pour les systèmes contenant des données sensibles ;<br>\r\n- Ne stockez pas les mots de passe dans un fichier sur un poste informatique particulièrement exposé au risque (exemple : en ligne sur Internet), encore moins sur un papier facilement accessible ;<br>\r\n- Ne vous envoyez pas vos propres mots de passe sur votre messagerie personnelle ;<br>\r\n- Configurez les logiciels, y compris votre navigateur web, pour qu’ils ne se « souviennent » pas des mots de passe choisis.<br>\r\n\r\nJe vous conseille soit d\'avoir ce que l\'on appelle un coffre-fort (qui gérera tous vos mots de passe au même endroit et sécurisés par un seul mot de passe - exemple : LastPass), soit de faire des phrases (si le site vous le permet) qui n\'ont pas de sens avec bien entendu, capitales, caractères spéciaux et chiffres dedans et des espaces si cela est possible => par exemple (non ce n\'est pas mon mot de passe) : Ilnepl3utJ@maisSurP3rpignan66<br>\r\nAttention à ne pas trop vouloir en faire, par exemple à trop vouloir remplacer vos lettres, cela pourrait avoir l\'effet inverse. Plus la phrase sera longue et mieux ce sera (malheureusement beaucoup de sites n\'autorisent pas de longs mots de passe) et une phrase non sens aura plus de difficulté à être craquée qu\'un mot de passe de 6 caractères (même si se sont des caractères spéciaux !). Pourquoi ?<br>\r\nPlus le temps passe et plus les ordinateurs sont performants et plus les hackers ont de facilitées à craquer des mots de passe de plus en plus longs, en même temps si vous mettez des informations personnelles que l\'on peut retrouver sur votre facebook, tweeter, instagram, snap...<br>\r\nVous devez savoir que les hackers disposent de ce que l\'on appelle d\'un dictionnaire des mots de passe contenant des millions de mots et ils leurs suffit de rentrer ce dico dans l\'algorithme de l\'ordinateur pour vérifier si votre mot de passe à vous en fait parti (ce qui est un gain de temps pour eux), et ce dictionnaire s\'étoffe jour après jour.<br>\r\nVous avez des sites qui vous permettent de vérifier de la complexité de votre mot de passe : <br>\r\n- <a href=\"https://inforisque.fr/fiches-pratiques/tester-mot-de-passe.php\">Inforisque</a>,<br>\r\n- <a href=\"https://howsecureismypassword.net/\">How secure is my password</a>,<br>\r\n- <a href=\"https://www.undernews.fr/nos-services/tester-la-force-de-votre-mot-de-passe\">Undernews</a>,<br>\r\n- <a href=\"https://pwdtest.bee-secure.lu/\">BeeSecure</a>(clairement mon préféré car il ne vous demande pas votre mot de passe).<br>\r\n<br>\r\nPour résumer je dirais, n\'utilisez pas le même mot de passe un peu partout, vous n\'avez plus aucune excuse avec l\'utilisation des coffres fort (et si les coffres fort ne vous vont pas il existe des clés usb de sécurité), et n\'oubliez pas d\'avoir un mot de passe long et diversifié !', '', '2020-02-02', '2020-02-02 16:20:00', 99, 1);

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `role`, `email`, `password`, `date_inscription`, `state`) VALUES
(1, 'Administrateur', 1, 'riwalenn@gmail.com', '', '2019-12-15 00:00:00', 1),
(2, 'Morgane', 2, 'usved66@gmail.com', '', '2020-01-01 00:00:00', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
