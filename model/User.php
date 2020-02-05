<?php

class User extends Post
{
    private $id;
    private $pseudo;
    private $role;
    private $email;
    private $password;
    private $state;

    const ADMINISTRATEUR = 1;
    const USER = 2;
    const ADMIN = "Riwalenn";

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
        if ($this->pseudo == "Administrateur") {
            return self::ADMIN;
        }
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
        if (in_array($role, [self::ADMINISTRATEUR, self::USER])) {
            $this->role = $role;
        }
        $this->role = self::USER;

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
        if (in_array($state, [self::EN_ATTENTE, self::VALIDE, self::SUPPRESSION])) {
            $this->state = $state;
        }
        $this->state = self::EN_ATTENTE;
    }

    static function helpPassword()
    {
        $html = "<div class='ui fluid hidden password-popup'>";
        $html .= "<div class='header'>";
        $html .= "<h3 class='popover-header'>Attention !</h3>";
        $html .= "</div>";
        $html .= "<div class='popover-body'>";
        $html .= "Voici quelques conseils pour vous aider à mieux sécuriser votre vie dématérialisée." . "<br>\n" .
            "- Utilisez un mot de passe <u>unique</u> pour chaque service. En particulier, l’utilisation d’un même" .
            "mot de passe entre sa messagerie professionnelle et sa messagerie personnelle est impérativement à proscrire ;" . "<br>\n" .
            "- Choisissez un mot de passe <u>qui n’a pas de lien avec vous</u> (mot de passe composé d’un nom de société," .
            "d’une date de naissance, etc.) ;" . "<br>\n" .
            "- Ne demandez <u>jamais</u> à un tiers de générer pour vous un mot de passe ;" . "<br>\n" .
            "- Modifiez systématiquement et au plus tôt les mots de passe par défaut lorsque les systèmes en contiennent ;" . "<br>\n" .
            "- <u>Renouvelez vos mots de passe avec une fréquence raisonnable</u>. Tous les 90 jours est un bon compromis" .
            "pour les systèmes contenant des données sensibles ;" . "<br>\n" .
            "- <u>Ne stockez pas</u> les mots de passe dans un fichier sur un poste informatique particulièrement exposé au risque" .
            "(exemple : en ligne sur Internet), encore moins sur un papier facilement accessible ;" . "<br>\n" .
            "- Ne vous envoyez pas vos propres mots de passe <u>sur votre messagerie personnelle</u> ;" . "<br>\n" .
            "- Configurez les logiciels, y compris votre navigateur web, <u>pour qu’ils ne se « souviennent » pas" .
            " des mots de passe choisis.</u>";
        $html .= "</div>";
        $html .= "</div>";

        return $html;
    }
}