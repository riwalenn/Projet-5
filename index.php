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

            case 'filtres' :
                $controller->voirFiltres();
                break;

            default :
                break;
        }
    } elseif(isset($_REQUEST['connexion'])) {
        $controller->pageConnexion();

    } else {
        $controller->voirIndex();
    }
}

catch (PDOException $e){
    $controller->erreurPDO();
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