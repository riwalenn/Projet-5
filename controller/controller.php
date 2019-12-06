<?php

class Controller
{
    public function voirIndex()
    {
        $view = new View('Index');
        $view->render('view/indexView.php');
    }
}