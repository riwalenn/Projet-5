<?php

class Comment
{
    private $id;
    private $id_post;
    private $id_user;
    private $title;
    private $content;
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

    public function getId_post()
    {
        return $this->id_post;
    }

    public function getId_author()
    {
        return $this->id_user;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
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

    public function setId_post($id_post)
    {
        $this->id_post = $id_post;
    }

    public function setId_user($id_user)
    {
        $this->id_user = $id_user;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setState($state)
    {
        if (in_array($state, [self::EN_ATTENTE, self::VALIDE, self::ARCHIVE, self::SUPPRESSION])) {
            $this->state = $state;
        }
    }
}