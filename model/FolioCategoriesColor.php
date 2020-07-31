<?php


class FolioCategoriesColor extends Portfolio
{
    private $id;
    private $category;
    private $color;
    private $id_folio;
    private $id_folio_cat;

    public function __construct($donnees = null)
    {
        if (!empty($donnees)) :
            $this->hydrate($donnees);
        endif;
    }

    public function hydrate($donnees)
    {
        foreach ($donnees as $cle => $valeur) {
            $method = 'set' . ucfirst($cle);
            if (method_exists($this, $method)) :
                $this->$method($valeur);
            endif;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color)
    {
        $this->color = $color;
    }

    public function getId_folio()
    {
        return $this->id_folio;
    }

    public function setId_folio($id_folio)
    {
        $this->id_folio = $id_folio;
    }

    public function getId_folio_cat()
    {
        return $this->id_folio_cat;
    }

    public function setId_folio_cat($id_folio_cat)
    {
        $this->id_folio_cat = $id_folio_cat;
    }
}