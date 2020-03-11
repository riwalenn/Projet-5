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
                $controller->afficherListeArticles();
                break;

            case 'connexion' :
                $controller->afficherLoginForm();
                break;

            case 'nouvelInscrit' :
                $controller->afficherNewLoginForm();
                break;

            case 'inscription' :
                $controller->inscription();
                break;

            case 'recherche' :
                $controller->afficherResultatRecherche();
                break;

            case 'confirmationInscriptionByEmail' :
               $controller->confirmationByToken();
                break;

            default :
                break;
        }
    } else {
        $controller->afficherIndex();
    }
}

catch (PDOException $e){
    $controller->erreurPDO($e);
}

catch (ExceptionOutput $e) {
    $controller->erreurOutput($e);
}

catch (InvalidArgumentException $e)
{
   $controller->erreur();
}

catch (Exception $e) {
    echo 'Exception : ' . $e->getMessage() . '(code :' . $e->getCode() . '), ligne ' . $e->getLine() . ' dans le fichier ' . $e->getFile();
}