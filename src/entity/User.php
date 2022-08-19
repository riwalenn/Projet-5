<?php

class User
{
    use EntityHydrator;

    private ?int $id;
    private ?string $pseudo;
    private ?int $role;
    private ?string $email;
    private ?string $password;
    private $date_inscription;
    private $date_modification;
    private ?int $cgu;
    private ?int $state;
    private ?string $id_token;
    private ?string $token;
    private ?int $id_user;
    private $expiration_token;

    static public array $listeStatut = [
        Constantes::USER_PENDING_STATUS => 'Compte non validé',
        Constantes::USER_PENDING_STATUS_MODO => 'token validé',
        Constantes::USER_STATUS_VALIDATED => 'compte validé',
        Constantes::USER_STATUS_DELETED => 'compte supprimé'
    ];

    static public array $listeRole = [
        Constantes::ROLE_ADMIN => 'Administrateur',
        Constantes::ROLE_AUTHOR => 'Auteur',
        Constantes::ROLE_USER => 'Utilisateur'
    ];

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

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo($pseudo): self
    {
        if (strlen($pseudo) <= 3) :
            $message = "Votre pseudo doit contenir au minimum 4 caractères : " . $pseudo;
            throw new ExceptionOutput($message);
        else:
            if (preg_match('^[\W]^', $pseudo)) :
                $message = "Votre pseudo ne doit pas contenir de caractères spéciaux : " . $pseudo;
                throw new ExceptionOutput($message);
            else:
                $this->pseudo = $pseudo;

                return $this;
            endif;
        endif;
    }

    public function getRole(): ?int
    {
        return $this->role;
    }

    public function setRole($role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getRoleName(): ?string
    {
        return self::$listeRole[$this->getRole()];
    }

    public function getRoleClass(): ?string
    {
        if ($this->role == Constantes::ROLE_ADMIN) :
            return 'role-dash-table';
        elseif ($this->role == Constantes::ROLE_USER) :
            return '';
        endif;

        return '';
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail($email): self
    {
        if (preg_match('#^[a-z0-9._-]{3,55}+@+[a-z0-9]{2,}\.[a-z]{2,5}$#', $email)) :
            $this->email = $email;

            return $this;
        else:
            $message = "Le format de votre email ne correspond pas ! (minimum 3 caractères, maximum 55 - 2 caractères minimum après l'arobase et 2 à 5 caractères pour l'extension";
            throw new ExceptionOutput($message);
        endif;
    }

    public function getEmailClass(): ?string
    {
        if ($this->email === 'no-reply@riwalennbas.com') :
            return 'email-dash-table';
        else:
            return '';
        endif;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword($password): self
    {
        if (preg_match('/^\S*(?=\S{10,64})(?=\S+[a-z])(?=\S+[A-Z])(?=\S+[\d])(?=\S+[\W])\S+$/', $password)):
            $this->password = $password;

            return $this;
        else :
            $message = "Votre mot de passe doit contenir entre 10 et 64 caractères, avoir des majuscules, des chiffres ainsi que des caractères spéciaux";
            throw new ExceptionOutput($message);
        endif;
    }

    public function getDate_inscription_fr()
    {
        $date = new DateTime($this->date_inscription);
        return date_format($date, 'd-m-Y');
    }

    public function getDate_inscription()
    {
        return $this->date_inscription;
    }

    public function setDate_inscription($date_inscription): self
    {
        $this->date_inscription = $date_inscription;

        return $this;
    }

    public function getDate_modification_fr()
    {
        $date = new DateTime($this->date_modification);
        return date_format($date, 'd-m-Y à H:m');
    }

    public function getDate_modification()
    {
        return $this->date_modification;
    }

    public function setDate_modification($date_modification): self
    {
        $this->date_modification = $date_modification;

        return $this;
    }

    public function getCgu(): ?int
    {
        return $this->cgu;
    }

    public function getCguClass(): ?string
    {
        if ($this->cgu == Constantes::CGU_VALIDATED) :
            return '<i class="fa fa-check-square cgu-green"></i>';
        else:
            return $this->cgu;
        endif;
    }

    /**
     * @throws ExceptionOutput
     */
    public function setCgu($cgu): self
    {
        if ($cgu == Constantes::CGU_VALIDATED) :
            $this->cgu = $cgu;

            return $this;
        else:
            $message = "Vous devez valider les conditions générales d'utilisation pour vous enregistrer";
            throw new ExceptionOutput($message);
        endif;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState($state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getStateName(): ?string
    {
        return self::$listeStatut[$this->getState()];
    }

    public function getStateClass(): ?string
    {
        $helper = new UserHelper();
        return $helper->getStateClass($this->state);
    }

    public function getId_token(): ?string
    {
        return $this->id_token;
    }

    public function setId_token($id_token)
    {
        $this->id = $id_token;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken($token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getId_user(): ?int
    {
        return $this->id_user;
    }

    public function setId_user($id_user)
    {
        $this->id_user = $id_user;
    }

    public function getExpiration_token()
    {
        if ($this->expiration_token == NULL) :
            return $this->expiration_token;
        else:
            $date = new DateTime($this->expiration_token);
            return date_format($date, 'd-m-Y à H:m');
        endif;
    }

    public function setExpiration_token($expiration_token)
    {
        $this->expiration_token = $expiration_token;
    }
}