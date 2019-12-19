<?php

class Post
{
    private $id;
    private $title;
    private $kicker;
    private $pseudo;
    private $content;
    private $url;
    private $created_at;
    private $modified_at;
    private $category;
    private $state;
    private $img;

    const EN_ATTENTE = 0;
    const VALIDE = 1;
    const ARCHIVE = 2;
    const SUPPRESSION = 3;
    const ADMIN = "Riwalenn";

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

    public function getPseudo()
    {
        if ($this->pseudo == "Administrateur") {
            return self::ADMIN;
        } else {
            return $this->pseudo;
        }
    }

    public function getContent()
    {
        return $this->content. ' <a href="'.$this->getUrl().'" target="_blank">[voir l\'article]</a>';
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getCreated_at()
    {
        $date = new DateTime($this->created_at);
        return date_format($date, 'd-m-Y');
    }

    public function getModified_at()
    {
        return $this->modified_at;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getImg()
    {
        return 'ressources/img/categories/'.$this->img;
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

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;
    }

    public function setModified_at($modified_at)
    {
        $this->modified_at = $modified_at;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function setState($state)
    {
        if (in_array($state, [self::EN_ATTENTE, self::VALIDE, self::ARCHIVE, self::SUPPRESSION])) {
            $this->state = $state;
        } else {
           $this->state = self::EN_ATTENTE;
        }
    }

    public function setImg($img)
    {
        $this->img = $img;
    }
}