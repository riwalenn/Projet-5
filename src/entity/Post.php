<?php

class Post
{
    use EntityHydrator;

    private $id;
    private $title;
    private $kicker;
    private $author;
    private $pseudo;
    private $content;
    private $url;
    private $created_at;
    private $modified_at;
    private $id_category;
    private $category;
    private $favorites;
    private $statut_favorite;
    private $state;
    private $comments;

    static public $listeStatut = [
        Constantes::POST_PENDING_STATUS => 'Article en attente',
        Constantes::POST_STATUS_VALIDATED => 'Article validé',
        Constantes::POST_STATUS_ARCHIVED => 'Article archivé',
        Constantes::POST_STATUS_DELETED => 'Article supprimé'
    ];

    public function __construct($donnees = null)
    {
        if (!empty($donnees)) :
            $this->hydrate($donnees);
        endif;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getKicker()
    {
        return $this->kicker;
    }

    public function setKicker($kicker): self
    {
        $this->kicker = $kicker;

        return $this;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function setPseudo($pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
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

    public function setContent($content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getCreated_at()
    {
        $date = new DateTime($this->created_at);
        return date_format($date, 'd-m-Y');
    }

    public function setCreated_at($created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getModified_at()
    {
        $date = new DateTime($this->modified_at);
        return date_format($date, 'd-m-Y H:m:s');
    }

    public function setModified_at($modified_at): self
    {
        $this->modified_at = $modified_at;

        return $this;
    }

    public function getId_Category()
    {
        return $this->id_category;
    }

    public function setId_Category($id_category)
    {
        $this->id_category = $id_category;

        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
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

    public function setState($state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getStateName()
    {
        return self::$listeStatut[$this->getState()];
    }

    public function getStateClass()
    {
        switch ($this->state) {
            case Constantes::POST_PENDING_STATUS:
            case Constantes::POST_STATUS_ARCHIVED:
                return 'user-status-orange';

            case Constantes::POST_STATUS_VALIDATED:
                return 'user-status-green';

            case Constantes::POST_STATUS_DELETED:
            default:
                return 'user-status-red';

        }
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    public function getStatut_favorite()
    {
        return $this->statut_favorite;
    }

    public function setStatut_favorite($statut_favorite)
    {
        $this->statut_favorite = $statut_favorite;

        return $this;
    }
}