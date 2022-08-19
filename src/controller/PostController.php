<?php


class PostController
{
    private $articleView = Constantes::PATH_FOLDER_TEMPLATES_FRONT.'articlesView.php';

    public function controllerFront()
    {
        $controller = new ControllerFront();
        return $controller;
    }

    /**
     * --------- ARTICLES & RECHERCHE ---------
     */

    //Affichage de la page des résultats de recherche des articles
    public function afficherResultatRecherche($errorMessage = NULL)
    {
        $postManager        = new PostManager();
        $userManager        = new UserManager();
        $categoryManager    = new CategoryManager();
        $commentManager     = new CommentManager();

        $errorMessage = '';
        if (empty(filter_input(INPUT_GET, 'submit'))) {
            $this->afficherListeArticles();
        }
        $pageCourante = filter_input(INPUT_GET, 'page') ?? 1;
        $submitRecherche = filter_input(INPUT_GET, 'submit') ?? "";
        $listPosts = $postManager->getSearch($submitRecherche, $pageCourante);

        foreach ($listPosts as $post) {
            $commentManager->fillCommentInPost($post);
        }

        $nbPages = $postManager->countPagesSearchResult($submitRecherche);
        foreach ($listPosts as $post) {
            $categoryManager->fillCategoryInPost($post);
            if (!empty($_SESSION['id'])) :
                $user = $userManager->getUserBySessionId();
                $postManager->fillFavoriteInPost($user, $post);
            endif;
        }

        $view = new View('Liste des articles');
        $view->render($this->articleView, ['listPosts' => $listPosts, 'errorMessage' => $errorMessage, 'nbPages' => $nbPages, 'pageCourante' => $pageCourante, 'submitRecherche' => $submitRecherche]);
    }

    //Affichage de la page des articles
    public function afficherListeArticles($errorMessage = NULL)
    {
        $postManager        = new PostManager();
        $commentManager     = new CommentManager();
        $categoryManager    = new CategoryManager();
        $userManager        = new UserManager();

        $errorMessage = '';
        $pageCourante = filter_input(INPUT_GET, 'page') ?? 1;
        $statut = 1; //Afficher les articles validés
        $listPosts = $postManager->getPosts($pageCourante, $statut);
        foreach ($listPosts as $post) {
            $commentManager->fillCommentInPost($post);
            $categoryManager->fillCategoryInPost($post);
            if (!empty($_SESSION['id'])) :
                $user = $userManager->getUserBySessionId();
                $postManager->fillFavoriteInPost($user, $post);
            endif;
        }

        $nbPages = $postManager->countPagesByState(3, Constantes::POST_STATUS_VALIDATED);

        $view = new View('Liste des articles');
        $view->render($this->articleView, ['listPosts' => $listPosts, 'errorMessage' => $errorMessage, 'nbPages' => $nbPages, 'pageCourante' => $pageCourante]);
    }

    // Ajout d'un commentaire pour un utilisateur connecté
    public function ajoutCommentaire()
    {
        $comment = new Comment($_REQUEST);
        $comment->setPseudo($_SESSION['id']);
        $comment->setState(Constantes::COM_PENDING_STATUS);

        $commentManager = new CommentManager();
        $commentManager->addComment($comment);

        $this->afficherListeArticles();
    }
}