<?php


class FolioCategoriesColor
{
    use EntityHydrator;

    private ?int $id;
    private ?string $category;
    private ?string $color;
    private ?Portfolio $id_folio;
    private ?int $id_folio_cat;

    public function __construct($donnees = null)
    {
        if (!empty($donnees)) :
            $this->hydrate($donnees);
        endif;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor($color)
    {
        $this->color = $color;
    }

    public function getId_folio(): ?Portfolio
    {
        return $this->id_folio;
    }

    public function setId_folio($id_folio)
    {
        $this->id_folio = $id_folio;
    }

    public function getId_folio_cat(): ?int
    {
        return $this->id_folio_cat;
    }

    public function setId_folio_cat($id_folio_cat)
    {
        $this->id_folio_cat = $id_folio_cat;
    }
}