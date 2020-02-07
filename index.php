<?php
require_once 'config/config.php';
try
{
    $controller = new controller();
    if (isset($_REQUEST['action']))
    {
        $action = $_REQUEST['action'];
        switch ($action)
        {
            case 'articlesListe' :
                $controller->voirListeArticles();
                break;

            case 'connexion' :
                $controller->loginPage();
                break;

            case 'inscription' :
                $controller->userRegistration();
                break;

            case 'recherche' :
                $controller->getResultatRecherche();
                break;

            default :
                break;
        }
    } else {
        $controller->voirIndex();
    }
}

catch (PDOException $e){
    $controller->erreurPDO($e);
}

catch (ExceptionOutput $e) {
    $controller->erreurOutput();
}

catch (InvalidArgumentException $e)
{
   $controller->erreur();
}

catch (Exception $e) {
    echo 'Exception : ' . $e->getMessage() . '(code :' . $e->getCode() . '), ligne ' . $e->getLine() . ' dans le fichier ' . $e->getFile();
}