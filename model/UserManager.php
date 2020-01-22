<?php


class UserManager extends Connexion
{
    public function usersUsed()
    {
        $bdd = $this->dbConnect();
        $users = $bdd->prepare('SELECT DISTINCT users.pseudo FROM `posts` LEFT JOIN users ON posts.author = users.id');
        $users->execute();
        return $users->fetchAll(PDO::FETCH_CLASS, 'User');
    }
}