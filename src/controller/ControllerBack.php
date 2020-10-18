<?php


class ControllerBack
{
    private $dashboardAdminView = Constantes::PATH_FOLDER_TEMPLATES_SECURITY.'dashboardAdminView.php';


    /**
     * --------- BACKEND ADMIN ---------
     */

    //Affiche le backend Admin
    public function getBackendDashboard()
    {
        $userManager                = new UserManager();
        $postManager                = new PostManager();
        $commentManager             = new CommentManager();
        $categoryManager            = new CategoryManager();
        $portfolioManager           = new PortfolioManager();
        $folioCategoriesManager     = new FolioCategoriesManager();

        $portfolio = $portfolioManager->getPortfolio();

        $user = $userManager->getUserBySessionId();
        if ($user->getRole() == Constantes::ROLE_ADMIN && $user->getState() == Constantes::USER_STATUS_VALIDATED) :
            $value = filter_input(INPUT_GET, 'value');
            if (isset($value)) {
                switch ($value) {
                    case 'tokenExpired':
                        $userManager->deleteUsersExpiredToken();
                        break;

                    case 'connexionExpired':
                        $userManager->deleteUsersExpiredConnection();
                        break;

                    case 'postsToDelete':
                        $postManager->deletePosts();
                        break;
                }
            }
            //Compteurs utilisateurs
            $nbUsersTotal               = $userManager->countAllUsers();
            $nbUsersReferent            = $userManager->countReferents();
            $nbUsersWaitingList         = $userManager->countUsersUncheckedByModo();
            $nbUsersConnexionExpired    = $userManager->countUsersExpiredConnection();
            $nbUsersTokenExpired        = $userManager->countUsersExpiredToken();
            $nbUsersTokenNotValidate    = $userManager->countUsersTokenUnchecked();
            $nbUsersToDelete            = $userManager->countUsersToDelete();


            //Compteurs articles
            $nbPostTotal                = $postManager->countAllPosts();
            $nbPostsUnchecked           = $postManager->countPostsUnckecked();
            $nbPostsArchived            = $postManager->countPostsArchived();
            $nbPostsToDelete            = $postManager->countPostsToDelete();
            $nbPostsByCategory          = $postManager->countPostsByCategory();

            //Compteur commentaires
            $nbCommentsUnchecked        = $commentManager->countCommentsUncheked();
            $nbCommentsToDelete         = $commentManager->countCommentsToDelete();

            $categories                 = $categoryManager->selectAllCategories();

            $nbFolioCategories          = $folioCategoriesManager->getNbCategoriesFolio();

            $view = new View('Tableau de bord');
            $view->render($this->dashboardAdminView, ['portfolio' => $portfolio, 'nbFolioCategories' => $nbFolioCategories, 'user' => $user, 'nbPostsUnchecked' => $nbPostsUnchecked, 'nbPostsArchived' => $nbPostsArchived, 'nbPostsToDelete' => $nbPostsToDelete, 'nbUsersTotal' => $nbUsersTotal, 'nbUsersReferent' => $nbUsersReferent, 'nbUsersWaitingList' => $nbUsersWaitingList, 'nbUsersTokenExpired' => $nbUsersTokenExpired, 'nbUsersConnexionExpired' => $nbUsersConnexionExpired, 'nbUsersTokenNotValidate' => $nbUsersTokenNotValidate, 'nbUsersToDelete' => $nbUsersToDelete, 'nbPostTotal' => $nbPostTotal, 'nbPostsByCategory' => $nbPostsByCategory, 'nbCommentsUnchecked' => $nbCommentsUnchecked, 'nbCommentsToDelete' => $nbCommentsToDelete, 'categories' => $categories]);
        else:
            $message = "Vous n'avez pas les autorisations pour accéder à cette page !";
            throw new ExceptionOutput($message);
        endif;
    }
}