<?php


class InstallationController
{
    public function installBlog()
    {
        $controller = new ControllerFront();
        //faire une vérification de la database avec show tables => si c'est vide créé les tables
        $installationManager = new Installation();
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
            $installationManager->addConstraints();
            $installationManager->installData();
            echo 'L\'installation c\'est bien passée';
        elseif (count($show) > 0):
            echo 'Les tables existent déjà !';
        endif;

        $controller->afficherIndex();
    }
}