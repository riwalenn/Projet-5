<?php


class InstallationController extends ControllerFront
{
    private $indexView  = Constantes::PATH_FOLDER_TEMPLATES_FRONT.'indexView.php';

    public function installBlog()
    {
        //faire une vérification de la database avec show tables => si c'est vide créé les tables
        $installationManager        = new Installation();
        $constraintInstallation     = new ConstraintsInstallation();
        $dataInstallationManager    = new DataInstallation();
        $show = $installationManager->showTables();
        if (count($show) == 0) :
            $installationManager->installCategoriesTable();
            $installationManager->installCommentsTable();
            $installationManager->installFavoritesTable();
            $installationManager->installPortfolioCategoriesColorTable();
            $installationManager->installPortfolioTable();
            $installationManager->installPortfolioCategoriesTable();
            $installationManager->installPostsTable();
            $installationManager->installTokensTable();
            $installationManager->installUsersTable();
            $constraintInstallation->addConstraints();
            $dataInstallationManager->installRelatedData();
            $dataInstallationManager->installOthersData();
            $successMessage = "L\'installation c\'est bien passée";
            $view = new View('index');
            $view->render($this->indexView, ['successMessage' => $successMessage]);
        elseif (count($show) > 0):
            $errorMessage =  "Les tables existent déjà !";
            $view = new View('index');
            $view->render($this->indexView, ['successMessage' => $errorMessage]);
        endif;

        $this->afficherIndex();
    }
}