<?php


class FolioCategoriesColor
{
    use EntityHydrator;

    private ?int $id;
    private ?string $category;
    private ?string $color;

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
}