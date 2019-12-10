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
        $view = new View('Liste des articles');
        $view->render('view/articlesView.php');
    }
}