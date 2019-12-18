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

        $view = new View('Liste des articles');
        $view->render('view/articlesView.php', ['listPosts' => $listPosts]);
        if (empty($listPosts)) {
            throw new Exception('La liste est vide');
        }
    }
}