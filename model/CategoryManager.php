<?php

class CategoryManager extends Connexion
{
    public function categoryCount()
    {
        $bdd = $this->dbConnect();
        $countCategories = $bdd->prepare('SELECT COUNT(id_category) as nb_postbycat, categories.category FROM `posts` INNER JOIN categories ON posts.id_category = categories.id GROUP BY id_category');
        $countCategories->execute();
        return $countCategories->fetch();
    }
}