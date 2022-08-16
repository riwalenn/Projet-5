<?php


class PatternManager extends Connexion
{
    public function get2021DataFinances()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT * FROM `e2c_donnees_financieres` WHERE date = "2021" AND etat = 1 ORDER BY id ASC');
        $statement->execute(array());

        return $statement->fetchAll(PDO::FETCH_CLASS, 'DataFinance');
    }
}