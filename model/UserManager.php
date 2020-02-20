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

    public function registration(User $user)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('INSERT INTO `users` (`pseudo`, `role`, `email`, `password`, `date_inscription`, `cgu`, `state`) VALUES (:pseudo, :role, :email, :password, NOW(), :cgu, :state) ');
        $liste = $statement->execute(array(
            'pseudo' => $user->getPseudo(),
            'role' => $user->getRole(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'cgu' => $user->getCgu(),
            'state' => $user->getState()
        ));
        return $liste;
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