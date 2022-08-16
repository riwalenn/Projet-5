<?php

class Post
{
    use EntityHydrator;

    private int $id;
    private string $title;
    private string $kicker;
    private User $author;
    private string $pseudo;
    private string $content;
    private string $url;
    private $created_at;
    private $modified_at;
    private int $id_category;
    private Category $category;
    private Favorites_posts $favorites;
    private int $statut_favorite;
    private int $state;
    private Comment $comments;

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

    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getKicker(): string
    {
        return $this->kicker;
    }

    public function setKicker($kicker): self
    {
        $this->kicker = $kicker;

        return $this;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor($author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    public function setPseudo($pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getContent(): string
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

    public function getUrl(): string
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

    public function getId_Category(): int
    {
        return $this->id_category;
    }

    public function setId_Category($id_category)
    {
        $this->id_category = $id_category;

        return $this;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    public function getFavorites(): Favorites_posts
    {
        return $this->favorites;
    }

    public function setFavorites(Favorites_posts $favorites)
    {
        $this->favorites = $favorites;
    }

    public function getState(): int
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
        $helper = new PostHelper();
        return $helper->getStateClass($this->state);
    }

    public function getComments(): Comment
    {
        return $this->comments;
    }

    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    public function getStatut_favorite(): int
    {
        return $this->statut_favorite;
    }

    public function setStatut_favorite($statut_favorite)
    {
        $this->statut_favorite = $statut_favorite;

        return $this;
    }
}