<?php


class Portfolio
{
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

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getKicker()
    {
        return $this->kicker;
    }

    public function setKicker($kicker)
    {
        $this->kicker = $kicker;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getDate_conception()
    {
        return $this->date_conception;
    }

    public function setDate_conception($date_conception)
    {
        $this->date_conception = $date_conception;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setClient($client)
    {
        $this->client = $client;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function setLink($link)
    {
        $this->link = $link;
    }

    public function getCodacy()
    {
        return $this->codacy;
    }

    public function setCodacy($codacy)
    {
        $this->codacy = $codacy;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    public function getCategoriesFormatted()
    {
        $categories = $this->getCategories();
        $categoriesexploded = explode('/', $categories);
        $categoriesFormatted = implode(' - ', $categoriesexploded);
        return $categoriesFormatted;
    }
}