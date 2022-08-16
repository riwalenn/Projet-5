<?php


class FolioCategoriesColorManager extends Connexion
{
    public function getFolioCategoriesColors()
    {
        $bdd = $this->dbConnect();
        $query = $bdd->prepare('SELECT * FROM `folio_categories_color`');
        $query->execute(array());

        return $query->fetchAll();
    }
}