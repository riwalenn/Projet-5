<?php


class Portfolio
{
    private $id;
    private $title;
    private $kicker;
    private $content;
    private $date_conception;
    private $client;
    private $categories;

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

    public function getTitle()
    {
        return $this->title;
    }

    public function getKicker()
    {
        return $this->kicker;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getDateConception()
    {
        return $this->date_conception;
    }

    public function getClient()
    {
        return $this->client;
    }
    public function getCategories()
    {
        return $this->categories;
    }

    public function getCategoriesFormatted()
    {
        $categories = self::getCategories();
        $categoriesexploded = explode( '/', $categories );
        $categoriesFormatted = implode(' - <i class="fas fa-check-square"></i> ', $categoriesexploded);
        return $categoriesFormatted;
    }

    // ----- Setters -----
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setKicker($kicker)
    {
        $this->kicker = $kicker;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setDateConception($date_conception)
    {
        $this->date_conception = $date_conception;
    }

    public function setClient($client)
    {
        $this->client = $client;
    }

    public function setCategories($categories)
    {
        $this->categories = $categories;
    }
}