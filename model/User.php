<?php

class User extends Post
{
    private $id;
    private $pseudo;
    private $role;
    private $email;
    private $password;
    private $state;

    const ADMIN = 1;
    const USER = 2;

    const EN_ATTENTE = 0;
    const VALIDE = 1;
    const SUPPRESSION = 2;

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

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
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

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    public function setRole($role)
    {
        if (in_array($role, [self::ADMIN, self::USER])){
            $this->role = $role;
        } else {
            $this->role = self::USER;
        }
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function setState($state)
    {
        if (in_array($state, [self::EN_ATTENTE, self::VALIDE, self::SUPPRESSION])){
            $this->state = $state;
        } else {
            $this->state = self::EN_ATTENTE;
        }
    }
}