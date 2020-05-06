<?php

class Comment extends Post
{
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

    public function hydrate($donnees)
    {
        foreach ($donnees as $cle => $valeur) {
            $method = 'set' . ucfirst($cle);
            if (method_exists($this, $method)) :
                $this->$method($valeur);
            endif;
        }
    }

    static public $listeStatut = [
      Constantes::COM_PENDING_STATUS => 'Commentaire en attente',
      Constantes::COM_STATUS_VALIDATED => 'Commentaire validé',
      Constantes::COM_STATUS_ARCHIVED => 'Commentaire archivé',
      Constantes::COM_STATUS_DELETED => 'Commentaire supprimé'
    ];

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId_post()
    {
        return $this->id_post;
    }

    public function setId_post($id_post)
    {
        $this->id_post = $id_post;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    public function getCreated_at()
    {
        $date = new DateTime($this->created_at);
        return date_format($date, 'd-m-Y à H:i:s');
    }

    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getStateClass()
    {
        switch ($this->state)
        {
            case Constantes::COM_PENDING_STATUS:
                return 'user-status-red';
                break;

            case Constantes::COM_STATUS_VALIDATED:
                return 'user-status-green';
                break;

            case Constantes::COM_STATUS_ARCHIVED:
                return 'user-status-orange';
                break;

            case Constantes::COM_STATUS_DELETED:
                return 'user-status-red';
                break;

            default:
                return 'user-status-red';
                break;

        }
    }
}