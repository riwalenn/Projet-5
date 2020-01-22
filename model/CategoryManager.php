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

    public function categoryByPost($idPost)
    {
        $bdd = $this->dbConnect();
        $categories = $bdd->prepare('SELECT DISTINCT categories.id, categories.category FROM `categories` LEFT JOIN posts ON posts.id_category = categories.id WHERE posts.id_category = ?');
        $categories->execute(array($idPost));
        return $categories->fetchAll(PDO::FETCH_CLASS, 'Category');
    }

    public function fillCategoryInPost(Post $post)
    {
        $post->setCategories($this->categoryByPost($post->getId()));
    }
}