<?php

class Controller
{
    public function voirIndex()
    {
        $portfolioManager = new PortfolioManager();
        $portfolio = $portfolioManager->getPortfolio();

        $view = new View('Index');
        $view->render('view/indexView.php', ['portfolio' => $portfolio]);
    }

    public function voirListeArticles()
    {
        $pageCourante = $_REQUEST['page'];
        $postManager = new PostManager();
        $listPosts = $postManager->getPosts($pageCourante);

        $userManager = new UserManager();
        $users = $userManager->usersUsed();

        $commentManager = new CommentManager();
        foreach ($listPosts as $post) {
            $commentManager->fillCommentInPost($post);
        }

        $nbPages = $postManager->countPages();

        $categoryManager = new CategoryManager();
        $categories = $categoryManager->categoriesUsed();
        foreach ($listPosts as $post) {
            $categoryManager->fillCategoryInPost($post);
        }

        $view = new View('Liste des articles');
        $view->render('view/articlesView.php', ['listPosts' => $listPosts, 'categories' => $categories, 'users' => $users, 'nbPages' => $nbPages, 'pageCourante' => $pageCourante]);
    }

    public function erreurPDO()
    {
        $erreurManager = new PDOException();
        $erreurMessage = $erreurManager->getMessage();
        $erreurCode = $erreurManager->getCode();
        $erreurLine = $erreurManager->getLine();
        $erreurFile = $erreurManager->getFile();

        $view = new View('Erreur PDO');
        $view->render('view/errorView.php', ['erreurMessage' => $erreurMessage, 'erreurCode' => $erreurCode, 'erreurLine' => $erreurLine, 'erreurFile' => $erreurFile]);
    }

    public function erreurOutput()
    {
        $erreurManager = new ExceptionOutput();
        $erreurMessage = $erreurManager->getMessage();
        $erreurCode = $erreurManager->getCode();
        $erreurLine = $erreurManager->getLine();
        $erreurFile = $erreurManager->getFile();

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