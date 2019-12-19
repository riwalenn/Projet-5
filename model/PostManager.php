<?php

class PostManager extends Connexion
{
    public function liste()
    {
        $bdd = $this->dbConnect();
        $listPosts = $bdd->prepare('SELECT posts.id, posts.title, posts.kicker, users.pseudo, posts.content, posts.url, posts.created_at, posts.modified_at, categories.category, categories.img FROM `posts` INNER JOIN categories ON posts.id_category = categories.id INNER JOIN users ON posts.author = users.id WHERE posts.state = 1 ORDER BY posts.created_at');
        $listPosts->execute();
        return $listPosts->fetchAll(PDO::FETCH_CLASS, 'Post');
    }
}