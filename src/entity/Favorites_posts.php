<?php

class Favorites_posts
{
    use EntityHydrator;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;
    }

    public function getId_user(): ?User
    {
        return $this->id_user;
    }

    public function setId_user(?User $id_user): self
    {
        $this->id_user = $id_user;
    }

    public function getId_post(): ?Post
    {
        return $this->id_post;
    }

    public function setId_post(?Post $id_post): self
    {
        $this->id_post = $id_post;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(): self
    {
        $post = new Post();
        $this->title = $post->getTitle();
    }
}