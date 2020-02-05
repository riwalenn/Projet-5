<?php


class UserManager extends Connexion
{
    public function usersUsed()
    {
        $bdd = $this->dbConnect();
        $users = $bdd->prepare('SELECT DISTINCT `users.pseudo` FROM `posts` LEFT JOIN `users` ON `posts.author` = `users.id`');
        $users->execute();
        return $users->fetchAll(PDO::FETCH_CLASS, 'User');
    }

    public function registration()
    {
        $bdd = $this->dbConnect();
        $user = $bdd->prepare('INSERT INTO `users` (`pseudo`, `email`, `password`) VALUES (?, ?, ?) ');
        $user->execute();
    }

    public function registration_confirmedByUser($token)
    {
        $bdd = $this->dbConnect();
        if (isset($token)) {
            $user = $bdd->prepare('UPDATE `users` SET `state` = 1 WHERE `id` = (SELECT `user_id` FROM `tokens` WHERE `token` = ? AND `expiration_token` > NOW())');
            $user->execute();
        }
    }

    public function registration_confirmedByAdmin($state)
    {
        $bdd = $this->dbConnect();
        if (isset($state)) {
            $user = $bdd->prepare('UPDATE `users` SET `state` = ?');
            $user->execute();
        }
    }
}