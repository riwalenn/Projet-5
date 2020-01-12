<?php

class CommentManager extends Connexion
{
    public function ListByPost($idComment)
    {
        $bdd = $this->dbConnect();
        $listComments = $bdd->prepare('SELECT comments.id_post, users.pseudo, comments.created_at, comments.title, comments.content FROM `comments`INNER JOIN posts ON posts.id = comments.id_post INNER JOIN users ON users.id = comments.id_user WHERE comments.state = 1 AND posts.id = ?');
        $listComments->execute(array($idComment));
        $tabList = $listComments->fetch();
        $comments = new Comment($tabList);
        return $comments;
    }
}