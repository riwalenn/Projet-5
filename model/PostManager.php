<?php

class PostManager extends Connexion
{
    public function getPosts($page, $post = NULL)
    {
        $bdd = $this->dbConnect();
        if (!empty($page)) {
            $listPosts = $bdd->prepare('SELECT posts.id, posts.title, posts.kicker, users.pseudo, posts.content, posts.url, posts.created_at, posts.modified_at, categories.category, categories.id 
                                                    FROM `posts` INNER JOIN categories ON posts.id_category = categories.id INNER JOIN users ON posts.author = users.id 
                                                    WHERE posts.state = 1 ORDER BY posts.created_at DESC LIMIT ' . (($page - 1) * 3) . ',3');
        } else {
            $listPosts = $bdd->prepare('SELECT posts.id, posts.title, posts.kicker, users.pseudo, posts.content, posts.url, posts.created_at, posts.modified_at, categories.category, categories.id 
                                                    FROM `posts` INNER JOIN categories ON posts.id_category = categories.id INNER JOIN users ON posts.author = users.id 
                                                    WHERE posts.state = 1 ORDER BY posts.created_at DESC LIMIT 0,3');
        }
        $listPosts->execute();
        return $listPosts->fetchAll(PDO::FETCH_CLASS, 'Post');
    }

    public function getSearch($recherche, $page, $post = NULL)
    {
        $bdd = $this->dbConnect();
        if (!empty($recherche)) {
            if (!empty($page)) {
                $listPosts = $bdd->prepare('SELECT posts.id, posts.title, posts.kicker, users.pseudo, posts.content, posts.url, posts.created_at, posts.modified_at, categories.category, categories.id
                                                        FROM `posts` INNER JOIN categories ON posts.id_category = categories.id INNER JOIN users ON posts.author = users.id 
                                                        WHERE posts.state = 1 AND posts.title LIKE "%'.$recherche.'%" OR posts.kicker LIKE "%'.$recherche.'%" OR posts.content LIKE "%'.$recherche.'%"
                                                        ORDER BY posts.created_at DESC LIMIT' . (($page - 1) * 3) . ',3');
            } else {
                $listPosts = $bdd->prepare('SELECT posts.id, posts.title, posts.kicker, users.pseudo, posts.content, posts.url, posts.created_at, posts.modified_at, categories.category, categories.id
                                                        FROM `posts` INNER JOIN categories ON posts.id_category = categories.id INNER JOIN users ON posts.author = users.id 
                                                        WHERE posts.state = 1 AND posts.title LIKE "%'.$recherche.'%" OR posts.kicker LIKE "%'.$recherche.'%" OR posts.content LIKE "%'.$recherche.'%"
                                                        ORDER BY posts.created_at DESC LIMIT 0,3');
            }
            $listPosts->execute();
            return $listPosts->fetchAll(PDO::FETCH_CLASS, 'Post');
        } else {
            $this->getPosts();
        }
    }

    public function countPages()
    {
        $bdd = $this->dbConnect();
        $countPages = $bdd->prepare('SELECT COUNT(*)/3 AS nb_pages FROM `posts`');
        $countPages->execute();
        $resultat = $countPages->fetch();
        return intval($resultat['nb_pages']);
    }
}