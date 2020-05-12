<?php
//clone pour les infos sensibles

//Chemin du template de la vue
define('TEMPLATE_PATH', 'view/template.php');

//Chemin de l'autoload
require_once 'framework/autoload.php';

//Début session
session_start();

define('BASE_URL', 'http://riwalenn');

//Connexion à la base de données
define('SGBD', 'mysql');
define('HOST', 'localhost');
define('DB_NAME', '');
define('USER', '');
define('PASSWORD', '');
define('CHARSET', 'utf8');