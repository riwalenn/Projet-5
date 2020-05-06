<?php


class PortfolioManager extends Connexion
{
    public function getPortfolio()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT * FROM `portfolio` ORDER BY id DESC');
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, 'Portfolio');
    }

    public function getLastInsertId()
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT MAX(id) as lastId FROM `portfolio`');
        $statement->execute();
        $result = $statement->fetch();
        return $result['lastId'];
    }

    public function createPortfolio(Portfolio $portfolio)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('INSERT INTO `portfolio` (`title`, `kicker`, `content`, `date_conception`, `client`, `categories`)
                                                VALUES (:title, :kicker, :content, :date_conception, :client, :categories)');
        $statement->execute(array(
            'title' => htmlspecialchars($portfolio->getTitle()),
            'kicker' => htmlspecialchars($portfolio->getKicker()),
            'content' => htmlspecialchars($portfolio->getContent()),
            'date_conception' => strip_tags($portfolio->getDate_conception()),
            'client' => htmlspecialchars($portfolio->getClient()),
            'categories' => htmlspecialchars($portfolio->getCategories())
        ));
    }

    public function updatePortfolio(Portfolio $portfolio)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('UPDATE `portfolio` 
                                                SET `title` = :title, `kicker` = :kicker, `content` = :content, `date_conception` = :date_conception, `client` = :client, `categories` = :categories
                                                WHERE `id` = :id');
        $statement->execute(array(
            'id' => intval($portfolio->getId()),
            'title' => htmlspecialchars($portfolio->getTitle()),
            'kicker' => htmlspecialchars($portfolio->getKicker()),
            'content' => htmlspecialchars($portfolio->getContent()),
            'date_conception' => strip_tags($portfolio->getDate_conception()),
            'client' => htmlspecialchars($portfolio->getClient()),
            'categories' => htmlspecialchars($portfolio->getCategories())
        ));
    }

    public function deletePortfolio(Portfolio $portfolio)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('DELETE FROM `portfolio` WHERE `id` = :id');
        $statement->execute(array('id' => intval($portfolio->getId())));
    }
}