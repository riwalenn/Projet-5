<?php


class DashboardUserController
{
    private $dashboardView = Constantes::PATH_FOLDER_TEMPLATES_SECURITY.'dashboardView.php';

    //Affichage le tableau de bord de l'utilisateur
    public function getDashboardUser($errorMessage = NULL)
    {
        $userManager = new UserManager();
        $listPosts = new PostManager();
        $commentManager = new CommentManager();
        $categoryManager = new CategoryManager();

        $user = $userManager->getUserBySessionId();
        if ($user->getRole() == Constantes::ROLE_USER && $user->getState() == Constantes::USER_STATUS_VALIDATED) :
            $favoritesPosts = $listPosts->getFavoritePostByIdUser($user);
            foreach ($favoritesPosts as $post) :
                $commentManager->fillCommentInPost($post);
                $categoryManager->fillCategoryInPost($post);
            endforeach;

            $lastPosts = $listPosts->getPosts(1, 1);
            foreach ($lastPosts as $post) :
                $commentManager->fillCommentInPost($post);
                $categoryManager->fillCategoryInPost($post);
                $listPosts->fillFavoriteInPost($user, $post);
            endforeach;

            $view = new View('Tableau de bord');
            $view->render($this->dashboardView, ['favoritesPosts' => $favoritesPosts, 'errorMessage' => $errorMessage, 'lastPosts' => $lastPosts, 'user' => $user]);
        else:
            $message = "Vous n'avez pas les autorisations pour accéder à cette page.";
            throw new ExceptionOutput($message);
        endif;
    }
}