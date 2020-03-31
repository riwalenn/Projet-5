<?php

class CategoryManager extends Connexion
{
    public function categoryByPost($idPost)
    {
        $bdd = $this->dbConnect();
        $statement = $bdd->prepare('SELECT DISTINCT categories.id, categories.category FROM `categories` LEFT JOIN posts ON posts.id_category = categories.id WHERE posts.id = :id');
        $statement->execute(array('id' => $idPost));
        $statement->setFetchMode(PDO::FETCH_CLASS, 'Category');
        return $statement->fetch();
    }

    public function fillCategoryInPost(Post $post)
    {
        $category = $this->categoryByPost($post->getId());
        $post->setCategory($category);
    }
}