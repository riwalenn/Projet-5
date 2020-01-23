<?php


class PortfolioManager extends Connexion
{
    public function getPortfolio()
    {
        $bdd = $this->dbConnect();
        $portfolio = $bdd->prepare('SELECT * FROM `portfolio` ORDER BY id DESC');
        $portfolio->execute();
        return $portfolio->fetchAll(PDO::FETCH_CLASS, 'Portfolio');
    }
}