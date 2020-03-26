<?php

class PostManager extends Connexion
{
    private $offset = 3;

    public function getPosts($page, $post = NULL)
    {
        $bdd = $this->dbConnect();
        if (!empty($page)) {
            $listPosts = $bdd->prepare('SELECT posts.id, posts.title, posts.kicker, users.pseudo, posts.content, posts.url, posts.created_at, posts.modified_at, categories.category, categories.id 
                                                    FROM `posts` INNER JOIN categories ON posts.id_category = categories.id INNER JOIN users ON posts.author = users.id 
                                                    WHERE posts.state = 1 ORDER BY posts.created_at DESC LIMIT :page,:offset');
            $listPosts->bindValue(':page', intval(($page -1) * 3), PDO::PARAM_INT);
            $listPosts->bindValue(':offset', intval($this->offset), PDO::PARAM_INT);
        } else {
            $listPosts = $bdd->prepare('SELECT posts.id, posts.title, posts.kicker, users.pseudo, posts.content, posts.url, posts.created_at, posts.modified_at, categories.category, categories.id 
                                                    FROM `posts` INNER JOIN categories ON posts.id_category = categories.id INNER JOIN users ON posts.author = users.id 
                                                    WHERE posts.state = 1 ORDER BY posts.created_at DESC LIMIT 0,:offset');
            $listPosts->bindValue(':offset', intval($this->offset), PDO::PARAM_INT);
        }
        $listPosts->execute();
        return $listPosts->fetchAll(PDO::FETCH_CLASS, 'Post');
    }

    public function getLastsPosts($post = NULL)
    {
        $bdd = $this->dbConnect();
        $listPosts = $bdd->prepare('SELECT `title`, `kicker` FROM `posts` WHERE state = 1 ORDER BY modified_at DESC LIMIT 0,:offset');
        $listPosts->bindValue(':offset', intval($this->offset), PDO::PARAM_INT);
        $listPosts->execute();
        return $listPosts->fetchAll(PDO::FETCH_CLASS, 'Post');
    }

    public function getSearch($recherche, $page, $post = NULL)
    {
        $bdd = $this->dbConnect();
        if (isset($recherche)) {
            if (isset($page)) {
                $listPosts = $bdd->prepare("SELECT posts.id, posts.title, posts.kicker, users.pseudo, posts.content, posts.url, posts.created_at, posts.modified_at, categories.category, categories.id
                                                        FROM `posts` INNER JOIN categories ON posts.id_category = categories.id INNER JOIN users ON posts.author = users.id 
                                                        WHERE posts.state = 1 AND posts.title LIKE CONCAT('%', :recherche, '%') OR posts.kicker LIKE CONCAT('%', :recherche, '%') OR posts.content LIKE CONCAT('%', :recherche, '%')
                                                        ORDER BY posts.created_at DESC LIMIT :page,:offset");
                $listPosts->bindValue(':recherche', htmlspecialchars($recherche), PDO::PARAM_STR);
                $listPosts->bindValue(':page', intval(($page -1) * 3), PDO::PARAM_INT);
                $listPosts->bindValue(':offset', intval($this->offset), PDO::PARAM_INT);
            } else {
                $listPosts = $bdd->prepare("SELECT posts.id, posts.title, posts.kicker, users.pseudo, posts.content, posts.url, posts.created_at, posts.modified_at, categories.category, categories.id
                                                        FROM `posts` INNER JOIN categories ON posts.id_category = categories.id INNER JOIN users ON posts.author = users.id 
                                                        WHERE posts.state = 1 AND posts.title LIKE CONCAT('%', :recherche, '%') OR posts.kicker LIKE CONCAT('%', :recherche, '%') OR posts.content LIKE CONCAT('%', :recherche, '%')
                                                        ORDER BY posts.created_at DESC LIMIT 0,:offset");
                $listPosts->bindValue(':recherche',  htmlspecialchars($recherche), PDO::PARAM_STR);
                $listPosts->bindValue(':offset', intval($this->offset), PDO::PARAM_INT);
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
        return $resultat['nb_pages'];
    }

    public function countPagesSearchResult($recherche)
    {
        $bdd = $this->dbConnect();
        if (!empty($recherche))
        {
            $countPages = $bdd->prepare("SELECT COUNT(*)/3 AS nb_pages FROM `posts` 
                                                    WHERE posts.state = 1 AND posts.title LIKE CONCAT('%', :recherche, '%') OR posts.kicker LIKE CONCAT('%', :recherche, '%') OR posts.content LIKE CONCAT('%', :recherche, '%')");
            $countPages->bindValue(':recherche',  htmlspecialchars($recherche), PDO::PARAM_STR);
            $countPages->execute();
            $resultat = $countPages->fetch();
            return $resultat['nb_pages'];
        } else {
            $this->countPages();
        }
    }
}