<?php

class Controller
{
    // --------- Index ---------
    public function afficherIndex()
    {
        $portfolioManager = new PortfolioManager();
        $portfolio = $portfolioManager->getPortfolio();

        $view = new View('Index');
        $view->render('view/indexView.php', ['portfolio' => $portfolio]);
    }

    // --------- Connexion ---------

    public function afficherLoginForm()
    {
        $view = new View('Connexion');
        $view->render('view/loginView.php');
    }

    public function afficherNewLoginForm()
    {
        $userManager = new User();
        $messagePassword = $userManager->helpPassword();
        $messagePseudo = $userManager->helpPseudo();

        $view = new View('Inscription');
        $view->render('view/registrationView.php', ['messagePassword' => $messagePassword, 'messagePseudo' => $messagePseudo]);
    }

    public function verifierNewLogin()
    {
        $user = new User($_REQUEST);
        $user->setRole(2);
        $user->setState(0);
        $userManager = new UserManager();
        $request = $userManager->registration($user);
        $this->afficherLoginForm();
    }

    // --------- Recherche ---------

    public function afficherResultatRecherche()
    {
        $pageCourante = $_REQUEST['page'] ?? 1;
        $submitRecherche = $_REQUEST['submit'] ?? "";
        $postManager = new PostManager();
        $listPosts = $postManager->getSearch($submitRecherche, $pageCourante);

        $commentManager = new CommentManager();
        foreach ($listPosts as $post) {
            $commentManager->fillCommentInPost($post);
        }

        $nbPages = $postManager->countPagesSearchResult($submitRecherche);

        $categoryManager = new CategoryManager();
        foreach ($listPosts as $post) {
            $categoryManager->fillCategoryInPost($post);
        }

        $view = new View('Liste des articles');
        $view->render('view/articlesView.php', ['listPosts' => $listPosts, 'nbPages' => $nbPages, 'pageCourante' => $pageCourante, 'submitRecherche' => $submitRecherche]);
    }

    // --------- Articles ---------

    public function afficherListeArticles()
    {
       $pageCourante = $_REQUEST['page'] ?? 1;
        $postManager = new PostManager();
        $listPosts = $postManager->getPosts($pageCourante);

        $commentManager = new CommentManager();
        foreach ($listPosts as $post) {
            $commentManager->fillCommentInPost($post);
        }

        $nbPages = $postManager->countPages();

        $categoryManager = new CategoryManager();
        foreach ($listPosts as $post) {
            $categoryManager->fillCategoryInPost($post);
        }

        $view = new View('Liste des articles');
        $view->render('view/articlesView.php', ['listPosts' => $listPosts, 'nbPages' => $nbPages, 'pageCourante' => $pageCourante]);
    }

    // --------- Erreurs ---------

    public function erreurPDO($pdoException)
    {
        $erreurMessage = $pdoException->getMessage();
        $erreurCode = $pdoException->getCode();
        $erreurLine = $pdoException->getLine();
        $erreurFile = $pdoException->getFile();

        $view = new View('Erreur PDO');
        $view->render('view/errorView.php', ['erreurMessage' => $erreurMessage, 'erreurCode' => $erreurCode, 'erreurLine' => $erreurLine, 'erreurFile' => $erreurFile]);
    }

    public function erreurOutput($outputException)
    {
        $erreurMessage = $outputException->getMessage();
        $erreurCode = $outputException->getCode();
        $erreurLine = $outputException->getLine();
        $erreurFile = $outputException->getFile();

        $view = new View('Erreur Output');
        $view->render('view/errorView.php', ['erreurMessage' => $erreurMessage, 'erreurCode' => $erreurCode, 'erreurLine' => $erreurLine, 'erreurFile' => $erreurFile]);
    }

    public function erreur()
    {
        $erreurManager = new Exception();
        $erreurMessage = $erreurManager->getMessage();
        $erreurCode = $erreurManager->getCode();
        $erreurLine = $erreurManager->getLine();
        $erreurFile = $erreurManager->getFile();

        $view = new View('Exception');
        $view->render('view/errorView.php', ['erreurMessage' => $erreurMessage, 'erreurCode' => $erreurCode, 'erreurLine' => $erreurLine, 'erreurFile' => $erreurFile]);
    }
}