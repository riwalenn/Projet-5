<?php

class ControllerFront
{
    private $indexView  = Constantes::PATH_FOLDER_TEMPLATES_FRONT.'indexView.php';

    /**
     * --------- INDEX ---------
     */

    public function afficherIndex()
    {
        $portfolioManager = new PortfolioManager();
        $portfolio = $portfolioManager->getPortfolio();
        $portfolioCategoriesManager = new FolioCategoriesManager();

        foreach ($portfolio as $folio) :
            $portfolioCategoriesManager->fillCategoryInPortfolio($folio);
        endforeach;

        $view = new View('Riwalenn Bas - développeuse d\'applications PHP/Symfony');
        $view->render($this->indexView, ['portfolio' => $portfolio]);
    }

    /**
     * --------- ERREURS ---------
     */

    public function erreurPDO($pdoException)
    {
        $erreurMessage = $pdoException->getMessage();
        $erreurCode = $pdoException->getCode();
        $erreurLine = $pdoException->getLine();
        $erreurFile = $pdoException->getFile();

        $view = new View('Erreur PDO');
        $view->render('templates/errorView.php', ['erreurMessage' => $erreurMessage, 'erreurCode' => $erreurCode, 'erreurLine' => $erreurLine, 'erreurFile' => $erreurFile]);
    }

    public function erreurOutput($outputException)
    {
        $erreurMessage = $outputException->getMessage();
        $erreurCode = $outputException->getCode();
        $erreurLine = $outputException->getLine();
        $erreurFile = $outputException->getFile();

        $view = new View('Erreur');
        $view->render('templates/errorView.php', ['erreurMessage' => $erreurMessage, 'erreurCode' => $erreurCode, 'erreurLine' => $erreurLine, 'erreurFile' => $erreurFile]);
    }

    public function erreur()
    {
        $erreurManager = new Exception();
        $erreurMessage = $erreurManager->getMessage();
        $erreurCode = $erreurManager->getCode();
        $erreurLine = $erreurManager->getLine();
        $erreurFile = $erreurManager->getFile();

        $view = new View('Exception');
        $view->render('templates/errorView.php', ['erreurMessage' => $erreurMessage, 'erreurCode' => $erreurCode, 'erreurLine' => $erreurLine, 'erreurFile' => $erreurFile]);
    }
}