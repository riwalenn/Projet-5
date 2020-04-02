<?php


class Favorites_posts
{
    private $id;
    private $id_user;
    private $id_post;
    private $title;

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

    public function getId_user()
    {
        return $this->id_user;
    }

    public function setId_user($id_user)
    {
        $this->id_user = $id_user;
    }

    public function getId_post()
    {
        return $this->id_post;
    }

    public function setId_post($id_post)
    {
        $this->id_post = $id_post;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle()
    {
        $post = new Post();
        $this->title = $post->getTitle();
    }
}