<?php


class Portfolio
{
    use EntityHydrator;

    private $id;
    private $title;
    private $kicker;
    private $content;
    private $date_conception;
    private $client;
    private $link;
    private $codacy;
    private $categories;

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

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getKicker(): ?string
    {
        return $this->kicker;
    }

    public function setKicker($kicker): self
    {
        $this->kicker = $kicker;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent($content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDate_conception()
    {
        return $this->date_conception;
    }

    public function setDate_conception($date_conception): self
    {
        $this->date_conception = $date_conception;

        return $this;
    }

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient($client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink($link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getCodacy(): ?string
    {
        return $this->codacy;
    }

    public function setCodacy($codacy): self
    {
        $this->codacy = $codacy;

        return $this;
    }

    public function getCategories(): ?array
    {
        return $this->categories;
    }

    public function setCategories($categories)
    {
        $this->categories = $categories;

        return $this;
    }

    public function getCategoriesFormatted()
    {
        $categories = $this->getCategories();
        $categoriesexploded = explode('/', (string)$categories);
        $categoriesFormatted = implode(' - ', $categoriesexploded);
        return $categoriesFormatted;
    }
}