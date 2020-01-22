<?php

class PostManager extends Connexion
{
    public function getPosts()
    {
        $bdd = $this->dbConnect();
        $page = $_REQUEST['page'];
        if (isset($page)) {
            $listPosts = $bdd->prepare('SELECT posts.id, posts.title, posts.kicker, users.pseudo, posts.content, posts.url, posts.created_at, posts.modified_at, categories.category, categories.id FROM `posts` INNER JOIN categories ON posts.id_category = categories.id INNER JOIN users ON posts.author = users.id WHERE posts.state = 1 ORDER BY posts.created_at DESC LIMIT ' . (($page - 1) * 3) . ',3');
        } else {
            $listPosts = $bdd->prepare('SELECT posts.id, posts.title, posts.kicker, users.pseudo, posts.content, posts.url, posts.created_at, posts.modified_at, categories.category, categories.id FROM `posts` INNER JOIN categories ON posts.id_category = categories.id INNER JOIN users ON posts.author = users.id WHERE posts.state = 1 ORDER BY posts.created_at DESC LIMIT 0,3');
        }
        $listPosts->execute();
        return $listPosts->fetchAll(PDO::FETCH_CLASS, 'Post');
    }

    public function countPages()
    {
        $bdd = $this->dbConnect();
        $countPages = $bdd->prepare('SELECT COUNT(*)/3 AS nb_pages FROM `posts`');
        $countPages->execute();
        return $countPages->fetch();
    }
}