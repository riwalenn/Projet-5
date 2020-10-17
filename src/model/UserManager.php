<?php

class UserManager extends Connexion
{
    /** INSCRIPTION ET CONFIRMATIONS */

    /** étape 1 : création user + token associé */
    public function registration(User $user)
    {
        $bdd = $this->dbConnect();
        $bdd->beginTransaction();

        $statement = $bdd->prepare('INSERT INTO `users` (`pseudo`, `role`, `email`, `password`, `date_inscription`, `date_modification`, `cgu`, `state`) 
                                                VALUES (:pseudo, :role, :email, :password, NOW(), NOW(), :cgu, :state) ');
        $statement->execute(array(
            'pseudo' => htmlspecialchars($user->getPseudo()),
            'role' => $user->getRole(),
            'email' => htmlspecialchars($user->getEmail()),
            'password' => password_hash($user->getPassword(), PASSWORD_DEFAULT),
            'cgu' => $user->getCgu(),
            'state' => $user->getState()
        ));

        $id_user = $bdd->lastInsertId();
        $token = $user->generateToken();
        $interval = 5 * 24 * 60;

        $tokenStatement = $bdd->prepare('INSERT INTO `tokens` (`token`, `id_user`, `expiration_token`) 
                                                    VALUES (:token, :id_user, DATE_ADD(now(), INTERVAL :interval MINUTE))');
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
        $tokenStatement = $bdd->prepare('INSERT INTO `tokens` (`token`, `id_user`, `expiration_token`) 
                                                    VALUES (:token, :id_user, DATE_ADD(now(), INTERVAL :interval MINUTE))');
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
        $statement->execute(array('email' => htmlspecialchars($user->getEmail())));
        return $statement->fetch();
    }

    //récupération du token avec l'email
    public function tokenRecuperation(User $user)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT `token`, `email` FROM `tokens` 
                                                JOIN `users` ON `id_user` = `id` WHERE `email` LIKE :email');
        $statement->execute(array('email' => htmlspecialchars($user->getEmail())));
        return $statement->fetchAll(PDO::FETCH_CLASS, 'User');
    }

    //vérification de l'existence d'un token
    public function countToken(User $user)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT COUNT(token) as nbToken 
                                                FROM tokens 
                                                WHERE id_user = (SELECT id FROM users, tokens WHERE token = :token AND tokens.id_user = users.id)');
        $statement->execute(array('token' => $user->getToken()));
        $result = $statement->fetch();
        return $result['nbToken'];
    }

    /**  étape 2 : confirmation de l'inscription via lien email & suppression token en bdd */
    public function registrationConfirmationByToken(User $user)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('UPDATE `users` SET `state` = 1, `date_modification` = NOW()
                                                WHERE `id` = (SELECT `id_user` FROM `tokens` WHERE `token` = :token AND `expiration_token` > NOW())');
        $statement->execute(array('token' => $user->getToken()));
    }

    //Suppression du token à l'inscription & oubli du password
    public function deleteToken(User $user)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('DELETE FROM tokens WHERE token = :token');
        $statement->execute(array('token' => $user->getToken()));
    }

    /** étape 3 : confirmation de l'inscription par l'administrateur */
    public function registrationConfirmationByAdmin(User $user)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('UPDATE `users` SET `state` = :state, `date_modification` = NOW()');
        $statement->execute(array('state' => intval($user->getState())));
    }

    //Modification du mot de passe s'il a été oublié
    public function passwordModification(User $user)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('UPDATE `users` SET `password` = :password, `date_modification` = NOW() 
                                                WHERE `id` = (SELECT `id_user` FROM `tokens` WHERE `token` = :token)');
        $statement->execute(array(
            'password' => password_hash($user->getPassword(), PASSWORD_DEFAULT),
            'token' => $user->getToken()
        ));
    }

    //modification des données par l'utilisateur via dashboard
    public function updateUserByUser(User $user)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('UPDATE `users` SET `pseudo` = :pseudo, `email` = :email, `date_modification` = NOW() 
                                                WHERE `id` = :id');
        $statement->execute(array(
            'id' => $user->getId(),
            'pseudo' => htmlspecialchars($user->getPseudo()),
            'email' => htmlspecialchars($user->getEmail()),
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
        $statement->execute(array('email' => htmlspecialchars($email)));
        $statement->setFetchMode(PDO::FETCH_CLASS, 'User');
        return $statement->fetch();
    }

    //modification de "date_modification" pour connaitre la dernière date de connexion
    //"date_modification" sert à plusieurs choses => connexion, modifications sur le compte
    public function newConnexionDate()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('UPDATE `users` SET `date_modification` = NOW() WHERE id = :id');
        $statement->execute(array('id' => $_SESSION['id']));
    }

    /**
     * @param $_SESSION ['id']
     * @return User
     */
    public function getUserBySessionId()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT `id`, `password`, `email`, `pseudo`, `role`, `date_inscription`, `date_modification`, `state` 
                                                FROM `users` 
                                                WHERE `id` = :id');
        $statement->execute(array('id' => $_SESSION['id']));
        $statement->setFetchMode(PDO::FETCH_CLASS, 'User');
        return $statement->fetch();
    }

    /** DASHBOARD ADMIN */

    //Nombre d'utilisateurs en attente de validation via token (token toujours valide)
    public function countUsersTokenUnchecked()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT COUNT(id) as nbUsers 
                                                FROM `tokens` RIGHT JOIN users 
                                                    ON tokens.id_user = users.id 
                                                WHERE expiration_token > NOW() 
                                                  AND state = 0');
        $statement->execute();
        $resultat = $statement->fetch();
        return $resultat['nbUsers'];
    }

    //Liste des utilisateurs en attente de validation de leurs tokens (token toujours valide)
    public function selectUsersTokenUnchecked()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT users.* , tokens.expiration_token
                                                FROM `tokens` RIGHT JOIN users 
                                                    ON tokens.id_user = users.id 
                                                WHERE expiration_token > NOW() 
                                                  AND state = 0');
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, 'User');
    }

    //Nombre d'utilisateurs en attente de validation via modérateur
    public function countUsersUncheckedByModo()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT COUNT(id) as nbUsers FROM `users` WHERE `state` = 1');
        $statement->execute();
        $resultat = $statement->fetch();
        return $resultat['nbUsers'];
    }

    //liste des utilisateurs en attente de validation
    public function selectUsersUncheckedByModo()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT * FROM `users` WHERE `state` = 1');
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, 'User');
    }

    //Nombre d'utilisateurs n'ayant pas validés leurs token (token expiré)
    public function countUsersExpiredToken()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT COUNT(id_token) as nbUsers 
                                                FROM `tokens` LEFT JOIN users 
                                                    ON tokens.id_user = users.id 
                                                WHERE expiration_token < NOW() 
                                                  AND state = 0');
        $statement->execute();
        $resultat = $statement->fetch();
        return $resultat['nbUsers'];
    }

    //Liste des utilisateurs n'ayant pas validés leurs token (token expiré)
    public function selectUsersExpiredToken()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT * FROM `tokens` RIGHT JOIN users ON tokens.id_user = users.id WHERE expiration_token < NOW() AND state = 0');
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, 'User');
    }

    //purge des utilisateurs n'ayant pas validé leur inscription (token expiré)
    public function deleteUsersExpiredToken()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('DELETE users FROM `users` 
                                                    INNER JOIN tokens ON users.id = tokens.id_user 
                                                WHERE tokens.expiration_token < NOW() 
                                                  AND users.state = 0');
        $statement->execute();
    }

    //Nombre d'utilisateurs ne s'étant pas connectés depuis 3 mois
    public function countUsersExpiredConnection()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT COUNT(id) as nbUsers FROM `users` 
                                                WHERE state = 2 
                                                  AND DATEDIFF(NOW(), date_modification) > 90 
                                                  AND email NOT IN (\'riwalenn@gmail.com\', \'no-reply@riwalennbas.com\')');
        $statement->execute();
        $resultat = $statement->fetch();
        return $resultat['nbUsers'];
    }

    //sélectionne les utilisateurs non connectés depuis plus de 3 mois
    public function selectUsersExpiredConnection()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT * 
                                                FROM `users` 
                                                WHERE DATEDIFF(NOW(), date_modification) > 90 
                                                  AND state = 2 
                                                  AND email NOT IN (\'riwalenn@gmail.com\', \'no-reply@riwalennbas.com\') 
                                                ORDER BY state ASC, date_inscription DESC');
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, 'User');
    }


    //purge des utilisateurs ne s'étant pas connectés depuis 3 mois
    public function deleteUsersExpiredConnection()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('DELETE FROM users 
                                                WHERE DATEDIFF(NOW(), date_modification) > 90 
                                                  AND role != 1 
                                                  AND email NOT LIKE \'no-reply@riwalennbas.com\' 
                                                  AND state = 2');
        $statement->execute();
    }

    //Compte le nombre total d'utilisateurs
    public function countAllUsers()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT COUNT(id) as nbUsers FROM `users` 
                                                WHERE role != 1 AND email NOT IN (\'riwalenn@gmail.com\', \'no-reply@riwalennbas.com\')');
        $statement->execute();
        $resultat = $statement->fetch();
        return $resultat['nbUsers'];
    }

    //sélectionne tous les utilisateurs avec leur token si existant
    public function selectAllUsers()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT users.*, tokens.token, tokens.expiration_token 
                                                FROM `users` LEFT JOIN tokens 
                                                    ON users.id = tokens.id_user 
                                                WHERE role != 1 AND email NOT IN (\'riwalenn@gmail.com\', \'no-reply@riwalennbas.com\') AND state != 3
                                                ORDER BY state ASC, date_inscription DESC');
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, 'User');
    }

    //Selectionne les admins ou référents du site
    public function selectReferents()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT users.*, tokens.token, tokens.expiration_token 
                                                FROM `users` LEFT JOIN tokens 
                                                    ON users.id = tokens.id_user 
                                                WHERE role = 1 OR email IN (\'riwalenn@gmail.com\', \'no-reply@riwalennbas.com\')
                                                ORDER BY state ASC, date_inscription DESC');
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, 'User');
    }

    //Compte le nombre de référents
    public function countReferents()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT COUNT(id) as nbUsers FROM `users` WHERE role = 1 OR email IN (\'riwalenn@gmail.com\', \'no-reply@riwalennbas.com\')');
        $statement->execute();
        $resultat = $statement->fetch();
        return $resultat['nbUsers'];
    }

    //sélectionne les utilisateurs avec le statut à supprimer
    public function selectUsersInTrash()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT users.*, tokens.token, tokens.expiration_token 
                                                FROM `users` LEFT JOIN tokens 
                                                    ON users.id = tokens.id_user 
                                                WHERE role != 1 AND email NOT IN (\'riwalenn@gmail.com\', \'no-reply@riwalennbas.com\') AND state = 3
                                                ORDER BY state ASC, date_inscription DESC');
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, 'User');
    }

    //Modifie l'utilisateur
    public function updateUser(User $user)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('UPDATE `users` SET `pseudo` = :pseudo, `role` = :role, `email` = :email, `state` = :state, `date_modification` = NOW() 
                                                WHERE `id` = :id');
        $statement->execute(array(
            'id' => $user->getId(),
            'pseudo' => htmlspecialchars($user->getPseudo()),
            'role' => $user->getRole(),
            'email' => htmlspecialchars($user->getEmail()),
            'state' => $user->getState()
        ));
    }

    //Modifie l'id du compte à supprimer dans la table commentaires
    public function updateIdUserInComments(User $user)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('UPDATE `comments`
                                                INNER JOIN users ON users.id = comments.id_user
                                                SET `id_user`= 2  
                                                WHERE users.id = :id');
        $statement->execute(array('id' => $user->getId()));
    }

    //Supprime l'utilisateur
    public function deleteUser(User $user)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('DELETE FROM users WHERE id = :id');
        $statement->execute(array('id' => $user->getId()));
    }

    //Compte les utilisateurs à supprimer
    public function countUsersToDelete()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT COUNT(id) as nbUsers FROM `users` 
                                                WHERE role != 1 AND email NOT IN (\'riwalenn@gmail.com\', \'no-reply@riwalennbas.com\') AND DATEDIFF(NOW(), date_modification) > 7 AND state = 3');
        $statement->execute();
        $resultat = $statement->fetch();
        return $resultat['nbUsers'];
    }
}