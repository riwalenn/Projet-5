<?php

class Post
{
    private $id;
    private $title;
    private $kicker;
    private $author;
    private $content;
    private $created_at;
    private $modified_at;
    private $id_category;
    private $state;

    const EN_ATTENTE = 0;
    const VALIDE = 1;
    const ARCHIVE = 2;
    const SUPPRESSION = 3;

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

    public function getAuthor()
    {
        return $this->author;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getCreated_at()
    {
        return $this->created_at;
    }

    public function getModified_at()
    {
        return $this->modified_at;
    }

    public function getId_category()
    {
        return $this->id_category;
    }

    public function getState()
    {
        return $this->state;
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

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;
    }

    public function setModified_at($modified_at)
    {
        $this->modified_at = $modified_at;
    }

    public function setId_category($id_category)
    {
        $this->id_category = $id_category;
    }

    public function setState($state)
    {
        if (in_array($state, [self::EN_ATTENTE, self::VALIDE, self::ARCHIVE, self::SUPPRESSION])) {
            $this->state = $state;
        }
    }
}