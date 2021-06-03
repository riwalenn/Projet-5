<?php

class Comment
{
    use EntityHydrator;

    private $id;
    private $id_post;
    private $pseudo;
    private $created_at;
    private $title;
    private $content;
    private $state;

    public function __construct($donnees = null)
    {
        if (!empty($donnees)) :
            $this->hydrate($donnees);
        endif;
    }

    static public $listeStatut = [
        Constantes::COM_PENDING_STATUS => 'Commentaire en attente',
        Constantes::COM_STATUS_VALIDATED => 'Commentaire validé',
        Constantes::COM_STATUS_ARCHIVED => 'Commentaire archivé',
        Constantes::COM_STATUS_DELETED => 'Commentaire supprimé'
    ];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getId_post(): ?Post
    {
        return $this->id_post;
    }

    public function setId_post(?Post $id_post)
    {
        $this->id_post = $id_post;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getCreated_at()
    {
        $date = new DateTime($this->created_at);
        return date_format($date, 'd-m-Y à H:i:s');
    }

    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    public function getStateClass()
    {
        switch ($this->state) {
            case Constantes::COM_PENDING_STATUS:
            case Constantes::COM_STATUS_DELETED:
                return 'user-status-red';

            case Constantes::COM_STATUS_VALIDATED:
                return 'user-status-green';

            case Constantes::COM_STATUS_ARCHIVED:
                return 'user-status-orange';
        }
    }
}