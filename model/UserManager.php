<?php

class UserManager extends Connexion
{
    /** INSCRIPTION ET CONFIRMATIONS */

    /** étape 1 : création user + token associé */
    public function registration(User $user)
    {
        $bdd = $this->dbConnect();
        $bdd->beginTransaction();

        $statement = $bdd->prepare('INSERT INTO `users` (`pseudo`, `role`, `email`, `password`, `date_inscription`, `date_modification`, `cgu`, `state`) VALUES (:pseudo, :role, :email, :password, NOW(), NOW(), :cgu, :state) ');
        $statement->execute(array(
            'pseudo' => htmlspecialchars($user->getPseudo()),
            'role' => $user->getRole(),
            'email' => $user->getEmail(),
            'password' => password_hash($user->getPassword(), PASSWORD_DEFAULT),
            'cgu' => $user->getCgu(),
            'state' => $user->getState()
        ));

        $id_user = $bdd->lastInsertId();
        $token = $user->generateToken();
        $interval = 5 * 24 * 60;

        $tokenStatement = $bdd->prepare('INSERT INTO `tokens` (`token`, `id_user`, `expiration_token`) VALUES (:token, :id_user, DATE_ADD(now(), INTERVAL :interval MINUTE))');
        $tokenStatement->execute(array(
            'token' => $token,
            'interval' => $interval,
            'id_user' => $id_user
        ));
        $bdd->commit();
    }

    //création token et inscription en bdd
    public function tokenCreation($id_user)
    {
        $user = new User();
        $bdd = $this->dbConnect();
        $token = $user->generateToken();
        $interval = 5 * 24 * 60;
        $tokenStatement = $bdd->prepare('INSERT INTO `tokens` (`token`, `id_user`, `expiration_token`) VALUES (:token, :id_user, DATE_ADD(now(), INTERVAL :interval MINUTE))');
        $tokenStatement->execute(array(
            'token' => $token,
            'interval' => $interval,
            'id_user' => $id_user
        ));
        return $tokenStatement;
    }

    //récupération id_user avec l'email
    public function idUserRecuperation(User $user)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT `id` FROM `users` WHERE `email` LIKE :email');
        $statement->execute(array(
            'email' => $user->getEmail()
        ));
        return $statement->fetch();
    }

    //récupération du token avec l'email
    public function tokenRecuperation(User $user)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT `token`, `email` FROM `tokens` JOIN `users` ON `id_user` = `id` WHERE `email` LIKE :email');
        $statement->execute(array(
            'email' => $user->getEmail()
        ));

        return $statement->fetchAll(PDO::FETCH_CLASS, 'User');
    }

    //vérification de l'existence d'un token
    public function countToken(User $user)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT COUNT(token) as nbToken FROM tokens WHERE id_user = (SELECT id FROM users, tokens WHERE token = :token AND tokens.id_user = users.id)');
        $statement->execute(array('token' => $user->getToken()));
        $result = $statement->fetch();
        return $result['nbToken'];
    }

    //étape 2 : confirmation de l'inscription via lien email & suppression token en bdd
    public function registrationConfirmationByToken(User $user)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('UPDATE `users` SET `state` = 1, `date_modification` = NOW() WHERE `id` = (SELECT `id_user` FROM `tokens` WHERE `token` = :token AND `expiration_token` > NOW())');
        $statement->execute(array('token' =>$user->getToken()));
    }

    //étape 3 : confirmation de l'inscription par l'administrateur
    public function registrationConfirmationByAdmin(User $user)
    {
        $bdd = $this->dbConnect();
            $statement = $bdd->prepare('UPDATE `users` SET `state` = :state, `date_modification` = NOW()');
            $statement->execute(array(
                'state' => $user->getState()
            ));

    }

    //Modification du mot de passe s'il a été oublié
    public function passwordModification(User $user)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('UPDATE `users` SET `password` = :password, `date_modification` = NOW() WHERE `id` = (SELECT `id_user` FROM `tokens` WHERE `token` = :token)');
        $statement->execute(array(
            'password' => password_hash($user->getPassword(), PASSWORD_DEFAULT),
            'token' => $user->getToken()
        ));
    }

    /** CONNEXION - DECONNEXION */
    //Connexion
    /**
     * @param $email
     * @return User
     */
    public function getUserByEmail($email)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT * FROM `users` WHERE `email` LIKE :email');
        $statement->execute(array(
            'email' => $email
        ));
        $statement->setFetchMode(PDO::FETCH_CLASS, 'User');
        return $statement->fetch();
    }

    /**
     * @param $_SESSION['id']
     * @return User
     */
    public function getUserBySessionId()
    {
        $bdd =$this->dbConnect();
        $statement = $bdd->prepare('SELECT * FROM `users` WHERE `id` = :id');
        $statement->execute(array(
            'id' => $_SESSION['id']
        ));
        $statement->setFetchMode(PDO::FETCH_CLASS, 'User');
        return $statement->fetch();
    }

    /** SUPPRESSIONS UTILISATEURS ET TOKENS */

    //Suppression du token à l'inscription & oubli du password
    public function deleteToken(User $user)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('DELETE FROM tokens WHERE token = :token');
        $statement->execute(array('token' =>$user->getToken()));
    }

    //purge des utilisateurs n'ayant pas validé leur inscription
    public function deleteExpiredTokenAndUser()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('DELETE FROM `users` WHERE `id` = (SELECT `id_user` FROM `tokens` WHERE `expiration_token` < NOW()) AND state = 0');
        $statement->execute();
    }

    //purge des utilisateurs ne s'étant pas connectés depuis 3 mois
    public function deleteExpirateduser()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('DELETE FROM users WHERE DATEDIFF(NOW(), date_modification) > 90 AND role != 1 AND email LIKE \'no-reply@riwalennbas.com\'');
        $statement->execute();
    }
}