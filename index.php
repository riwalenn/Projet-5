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

            default :
                break;
        }
    } else {
        $controller->voirIndex();
    }
}

catch (PDOException $e){
    echo $e->getMessage();
}

catch (ExceptionOutput $e) {
    echo  'Message d\'erreur : ' . $e->getMessage() . ' (code : ' . $e->getCode() . '), ligne ' . $e->getLine() . ' dans le fichier ' . $e->getFile();
}

catch (InvalidArgumentException $e)
{
    echo $e->getMessage();
}

catch (Exception $e) {
    echo 'Exception : ' . $e->getMessage() . '(code :' . $e->getCode() . '), ligne ' . $e->getLine() . ' dans le fichier ' . $e->getFile();
}