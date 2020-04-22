<?php

class CommentManager extends Connexion
{
    public function listByPost($idPost)
    {
        $bdd = $this->dbConnect();
        $listComments = $bdd->prepare('SELECT comments.id, comments.id_post, users.pseudo, comments.created_at, comments.title, comments.content 
                                                    FROM `comments` 
                                                        LEFT JOIN posts ON posts.id = comments.id_post 
                                                        INNER JOIN users ON users.id = comments.id_user 
                                                    WHERE comments.state = 1 AND posts.id = :idPost 
                                                    ORDER BY comments.created_at DESC');
        $listComments->execute(array('idPost' => $idPost));
        return $listComments->fetchAll(PDO::FETCH_CLASS, 'Comment');
    }

    public function fillCommentInPost(Post $post)
    {
        $post->setComments($this->listByPost($post->getId()));
    }

    public function addComment(Comment $comment)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('INSERT INTO `comments` (`id_post`, `id_user`, `created_at`, `title`, `content`, `state`) VALUES (:id_post, :pseudo, NOW(), :title, :content, :state)');
        $statement->execute(array(
            'id_post' => intval($comment->getId_post()),
            'pseudo' => intval($comment->getPseudo()),
            'title' => htmlspecialchars($comment->getTitle()),
            'content' => htmlspecialchars($comment->getContent()),
            'state' => intval($comment->getState())
        ));

    }

    public function countCommentsUncheked()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT COUNT(id) as nbComments FROM `comments` WHERE state = 0');
        $statement->execute();
        $resultat = $statement->fetch();
        return $resultat['nbComments'];
    }
}