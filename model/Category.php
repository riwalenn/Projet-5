<?php

class Category extends Post
{
    private $id;
    private $category;

    const ALLNAV = '.webp';
    const SAFARI = '.png';

    public function __construct($donnees = null)
    {
        if (!empty($donnees)) {
            $this->hydrate($donnees);
        }
    }

    public function hydrate($donnees)
    {
        foreach ($donnees as $cle => $valeur) {
            $method = 'set' . ucfirst($cle);
            if (method_exists($this, $method)) {
                $this->$method($valeur);
            }
        }
    }

    // ----- Getters -----
    public function getId()
    {
        return $this->id;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getImgCategoryWP()
    {
        return 'ressources/img/categories/' . $this->getId() . self::ALLNAV;
    }

    public function getImgCategoryS()
    {
        return 'ressources/img/categories/' . $this->getId() . self::SAFARI;
    }

    // ----- Setters -----
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }
}