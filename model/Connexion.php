<?php

class Connexion
{
    /*

    Do not modify this file :
    use config.php to change dbname, user and password

    */

    protected function dbConnect()
    {
        $db_config['OPTIONS'] = array(
            //Activation des exceptions PDO
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            //change le fetch mode par défaut sur FETCH_ASSOC
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        );

        $db = new \PDO(SGBD . ':host=' . HOST.';dbname=' . DB_NAME . ';charset=' . CHARSET,
            USER,
            PASSWORD,
            $db_config['OPTIONS']);
        unset($db_config);
        return $db;
    }
}