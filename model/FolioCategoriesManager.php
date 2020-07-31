<?php

class FolioCategoriesManager extends Connexion
{
    //récupérer les catégories du portfolio
    public function getCategoriesFolio($idFolio)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT category, color 
                                                FROM folio_categories_color 
                                                    LEFT JOIN folio_categories ON folio_categories_color.id = folio_categories.id_folio_cat 
                                                    LEFT JOIN portfolio ON folio_categories.id_folio = portfolio.id 
                                                WHERE portfolio.id = :idFolio
                                                ORDER BY folio_categories.id_folio_cat ASC');
        $statement->execute(array('idFolio' => $idFolio));
        return $statement->fetchAll(PDO::FETCH_CLASS, 'FolioCategoriesColor');
    }

    public function fillCategoryInPortfolio(Portfolio $portfolio)
    {
        $portfolio->setCategories($this->getCategoriesFolio($portfolio->getId()));
    }
}