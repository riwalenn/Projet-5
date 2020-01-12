<?php

class Controller
{
    public function voirIndex()
    {
        $view = new View('Index');
        $view->render('view/indexView.php');
    }

    public function voirListeArticles()
    {
        $postManager = new PostManager();
        $listPosts = $postManager->liste();
        $idComment = $listPosts['id'];
        $commentManager = new CommentManager();
        $listComments = $commentManager->ListByPost($idComment);

        $view = new View('Liste des articles');
        $view->render('view/articlesView.php', ['listPosts' => $listPosts, 'listComments' => $listComments]);
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

   /* public function voirListeCommentairesByPost()
    {
        $commentManager = new CommentManager();
        $listComments = $commentManager->ListByPost();
        $view = new View('Commentaires');
        $view->render('view/articlesView.php', ['listComments' => $listComments]);
    }*/
}