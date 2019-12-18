<?php

class PostManager extends Connexion
{
    private $id;

    public function liste()
    {
        $bdd = $this->dbConnect();
        $listPosts = $bdd->prepare('SELECT * FROM posts where state = 1 ORDER BY created_at DESC');
        $listPosts->execute();
        return $listPosts->fetchAll(PDO::FETCH_CLASS, 'Post');
    }
}