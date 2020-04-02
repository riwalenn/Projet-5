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
    private $favorites;
    private $statut_favorite;
    private $state;
    private $comments;

    const EN_ATTENTE = 0;
    const VALIDE = 1;
    const ARCHIVE = 2;
    const SUPPRESSION = 3;
    const ADMIN = "Riwalenn";

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

    public function getPseudo()
    {
        if ($this->pseudo == "Administrateur") :
            return self::ADMIN;
        endif;
        return $this->pseudo;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    public function getContent()
    {
        if (!empty($this->getUrl())) :
            $url = ' <a href="' . $this->getUrl() . '" target="_blank">[voir l\'article]</a>';
        else:
            $url = '';
        endif;
        return $this->content . $url;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getCreated_at()
    {
        $date = new DateTime($this->created_at);
        return date_format($date, 'd-m-Y');
    }

    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getModified_at()
    {
        $date = new DateTime($this->modified_at);
        return date_format($date, 'd-m-Y H:m:s');
    }

    public function setModified_at($modified_at)
    {
        $this->modified_at = $modified_at;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    public function getFavorites()
    {
        return $this->favorites;
    }

    public function setFavorites(Favorites_posts $favorites)
    {
        $this->favorites = $favorites;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        if (in_array($state, [self::EN_ATTENTE, self::VALIDE, self::ARCHIVE, self::SUPPRESSION])) :
            $this->state = $state;
        endif;
        $this->state = self::EN_ATTENTE;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    public function getStatut_favorite()
    {
        return $this->statut_favorite;
    }

    public function setStatut_favorite($statut_favorite)
    {
        $this->statut_favorite = $statut_favorite;
    }
}