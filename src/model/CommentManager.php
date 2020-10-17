<?php

class CommentManager extends Connexion
{
    public function getAllComments()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT comments.id, comments.id_post, users.pseudo, comments.created_at, comments.title, comments.content, comments.state 
                                                FROM `comments` INNER JOIN users
                                                ON comments.id_user = users.id
                                                ORDER BY comments.state ASC');
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, 'Comment');
    }

    public function getListByPost($idPost)
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
        $post->setComments($this->getListByPost($post->getId()));
    }

    public function addComment(Comment $comment)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('INSERT INTO `comments` (`id_post`, `id_user`, `created_at`, `title`, `content`, `state`) VALUES (:id_post, :pseudo, NOW(), :title, :content, :state)');
        $statement->execute(array(
            'id_post' => $comment->getId_post(),
            'pseudo' => htmlspecialchars($comment->getPseudo()),
            'title' => htmlspecialchars($comment->getTitle()),
            'content' => htmlspecialchars($comment->getContent()),
            'state' => $comment->getState()
        ));

    }

    public function updateCommentState(Comment $comment)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('UPDATE `comments` SET `state` = :state WHERE `comments`.`id` = :id');
        $statement->execute(array(
            'id' => $comment->getId(),
            'state' => $comment->getState()
        ));
    }

    public function deleteComments()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('DELETE FROM `comments` WHERE `state` = 3');
        $statement->execute();
    }

    public function updateComment(Comment $comment)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('UPDATE `comments` SET title = :title, content = :content, state = :state WHERE id = :id');
        $statement->execute(array(
            'id' => $comment->getId(),
            'title' => $comment->getTitle(),
            'content' => $comment->getContent(),
            'state' => $comment->getState()
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

    public function countCommentsToDelete()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT COUNT(id) as nbComments FROM `comments` WHERE state = 3');
        $statement->execute();
        $resultat = $statement->fetch();
        return $resultat['nbComments'];
    }
}