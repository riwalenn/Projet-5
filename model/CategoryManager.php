<?php

class CategoryManager extends Connexion
{
   public function categoriesUsed()
   {
       $bdd = $this->dbConnect();
       $categories = $bdd->prepare('SELECT DISTINCT categories.category FROM `posts` LEFT JOIN categories ON posts.id_category = categories.id');
       $categories->execute();
       return $categories->fetchAll(PDO::FETCH_CLASS, 'Category');
   }
}