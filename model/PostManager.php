<?php

class PostManager extends Connexion
{
    private $offset = 3;

    public function getPosts($page, $post = NULL)
    {
        $bdd = $this->dbConnect();
        $listPosts = $bdd->prepare('SELECT posts.id, posts.title, posts.kicker, users.pseudo, posts.content, posts.url, posts.created_at, posts.modified_at
                                                    FROM `posts` INNER JOIN users ON posts.author = users.id 
                                                    WHERE posts.state = 1 ORDER BY posts.created_at DESC LIMIT :page,:offset');
        if (!empty($page)) {
            $listPosts->bindValue(':page', intval(($page -1) * 3), PDO::PARAM_INT);
        } else {
            $listPosts->bindValue(':page', intval(0), PDO::PARAM_INT);
        }
        $listPosts->bindValue(':offset', intval($this->offset), PDO::PARAM_INT);
        $listPosts->execute();
        return $listPosts->fetchAll(PDO::FETCH_CLASS, 'Post');
    }

    public function getSearch($recherche, $page, $post = NULL)
    {
        $bdd = $this->dbConnect();
        if (isset($recherche)) {
            $listPosts = $bdd->prepare("SELECT posts.id, posts.title, posts.kicker, users.pseudo, posts.content, posts.url, posts.created_at, posts.modified_at 
                                                        FROM `posts` INNER JOIN users ON posts.author = users.id 
                                                        WHERE posts.state = 1 AND posts.title LIKE CONCAT('%', :recherche, '%') OR posts.kicker LIKE CONCAT('%', :recherche, '%') OR posts.content LIKE CONCAT('%', :recherche, '%')
                                                        ORDER BY posts.created_at DESC LIMIT :page,:offset");
            if (isset($page)) {
                $listPosts->bindValue(':page', intval(($page -1) * 3), PDO::PARAM_INT);
            }
            $listPosts->bindValue(':offset', intval($this->offset), PDO::PARAM_INT);
            $listPosts->bindValue(':recherche',  htmlspecialchars($recherche), PDO::PARAM_STR);
            $listPosts->execute();
            return $listPosts->fetchAll(PDO::FETCH_CLASS, 'Post');
        } else {
            $this->getPosts(1);
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