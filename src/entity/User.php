<?php

class User extends Post
{
    private $id;
    private $pseudo;
    private $role;
    private $email;
    private $password;
    private $date_inscription;
    private $date_modification;
    private $cgu;
    private $state;
    private $id_token;
    private $token;
    private $id_user;
    private $expiration_token;

    static public $listeStatut = [
        Constantes::USER_PENDING_STATUS => 'Compte non validé',
        Constantes::USER_PENDING_STATUS_MODO => 'token validé',
        Constantes::USER_STATUS_VALIDATED => 'compte validé',
        Constantes::USER_STATUS_DELETED => 'compte supprimé'
    ];

    static public $listeRole = [
        Constantes::ROLE_ADMIN => 'Administrateur',
        Constantes::ROLE_USER => 'Utilisateur'
    ];

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

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function setPseudo($pseudo)
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
            endif;
        endif;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getRoleName()
    {
        return self::$listeRole[$this->getRole()];
    }

    public function getRoleClass()
    {
        if ($this->role == 1) :
            return 'role-dash-table';
        elseif ($this->role == 2) :
            return '';
        endif;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        if (preg_match('#^[a-z0-9._-]{3,55}+@+[a-z0-9]{2,}\.[a-z]{2,5}$#', $email)) :
            $this->email = $email;
        else:
            $message = "Le format de votre email ne correspond pas ! (minimum 3 caractères, maximum 55 - 2 caractères minimum après l'arobase et 2 à 5 caractères pour l'extension";
            throw new ExceptionOutput($message);
        endif;
    }

    public function getEmailClass()
    {
        if ($this->email === 'no-reply@riwalennbas.com') :
            return 'email-dash-table';
        else:
            return '';
        endif;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        if (preg_match('/^\S*(?=\S{10,64})(?=\S+[a-z])(?=\S+[A-Z])(?=\S+[\d])(?=\S+[\W])\S+$/', $password)):
            $this->password = $password;
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

    public function setDate_inscription($date_inscription)
    {
        $this->date_inscription = $date_inscription;
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

    public function setDate_modification($date_modification)
    {
        $this->date_modification = $date_modification;
    }

    public function getCgu()
    {
        return $this->cgu;
    }

    public function getCguClass()
    {
        if ($this->cgu == 1) :
            return '<i class="fa fa-check-square cgu-green"></i>';
        else:
            return $this->cgu;
        endif;
    }

    public function setCgu($cgu)
    {
        if ($cgu == 1) :
            $this->cgu = $cgu;
        else:
            $message = "Vous devez valider les conditions générales d'utilisation pour vous enregistrer";
            throw new ExceptionOutput($message);
        endif;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getStateName()
    {
        return self::$listeStatut[$this->getState()];
    }

    public function getStateClass()
    {
        switch ($this->state) {
            case Constantes::USER_PENDING_STATUS:
                return 'user-status-red';
                break;

            case Constantes::USER_PENDING_STATUS_MODO:
                return 'user-status-orange';
                break;

            case Constantes::USER_STATUS_VALIDATED:
                return 'user-status-green';
                break;

            case Constantes::USER_STATUS_DELETED:
                return 'user-status-red';
                break;

            default:
                return 'user-status-red';
                break;

        }
    }

    public function getId_token()
    {
        return $this->id_token;
    }

    public function setId_token($id_token)
    {
        $this->id = $id_token;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getId_user()
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


    public function generateToken($length = 32)
    {
        $token = random_bytes($length);
        return bin2hex($token);
    }

    public function sendTokenForPassword($list)
    {
        foreach ($list as $value) :
            if (empty($list)) :
                echo "Le token ou l'email sont manquants !";
                return false;
            endif;
            $email = strip_tags(htmlspecialchars($value->email));
            $token = strip_tags(htmlspecialchars($value->token));
            $sujet = "Modification de mon mot de passe sur le blog de Riwalenn Bas";
            $message = "Pour modifier votre mot de passe, veuillez cliquer sur le lien ci-dessous :\n\n" . Constantes::HTTP_RIWALENN . "/index.php?action=confirmationEmailForPassword&tokenForPassword=$token";
            //$message = "Pour modifier votre mot de passe, veuillez cliquer sur le lien ci-dessous :\n\nhttps://projet5.riwalennbas.com/index.php?action=confirmationEmailForPassword&tokenForPassword=$token";

            $to = $email;
            $email_subject = "$sujet";
            $email_body = "$message";
            $headers = "From: noreply@riwalennbas.com\n";
            $headers .= "Reply-To: $email";
            mail($to, $email_subject, $email_body, $headers);
        endforeach;
        return true;
    }

    public function sendToken($list)
    {
        foreach ($list as $value) :
            if (empty($list)) :
                echo "Le token ou l'email sont manquants !";
                return false;
            endif;
            $email = strip_tags(htmlspecialchars($value->email));
            $token = strip_tags(htmlspecialchars($value->token));
            $sujet = "Confirmation de votre inscription sur le blog de Riwalenn Bas";
            $message = "Pour confirmer votre inscription, veuillez cliquer sur le lien ci-dessous :\n\n" . Constantes::HTTP_RIWALENN . "/index.php?action=confirmationInscriptionByEmail&token=$token";
            //$message = "Pour confirmer votre inscription, veuillez cliquer sur le lien ci-dessous :\n\nhttps://projet5.riwalennbas.com/index.php?action=confirmationInscriptionByEmail&token=$token";

            $to = $email;
            $email_subject = "$sujet";
            $email_body = "$message";
            $headers = "From: noreply@riwalennbas.com\n";
            $headers .= "Reply-To: $email";
            mail($to, $email_subject, $email_body, $headers);
        endforeach;
        return true;
    }

    // --- Statics functions

    static function helpPseudo()
    {
        $html = "Votre pseudo doit contenir au minimum 4 caractères, les caractères spéciaux sont interdits.";

        return $html;
    }

    static function helpPassword()
    {
        $html = "Voici quelques conseils pour vous aider à mieux sécuriser votre vie dématérialisée." . "<br>\n" .
            "- Utilisez un mot de passe <u>unique</u> pour chaque service. En particulier, l’utilisation d’un même " . "<br>\n" .
            "mot de passe entre sa messagerie professionnelle et sa messagerie personnelle est impérativement à proscrire ;" . "<br>\n" .
            "- Choisissez un mot de passe <u>qui n’a pas de lien avec vous</u> (mot de passe composé d’un nom de société," . "<br>\n" .
            "d’une date de naissance, etc.) ;" . "<br>\n" .
            "- Ne demandez <u>jamais</u> à un tiers de générer pour vous un mot de passe ;" . "<br>\n" .
            "- Modifiez systématiquement et au plus tôt les mots de passe par défaut lorsque les systèmes en contiennent ;" . "<br>\n" .
            "- <u>Renouvelez vos mots de passe avec une fréquence raisonnable</u>. Tous les 90 jours est un bon compromis" . "<br>\n" .
            "pour les systèmes contenant des données sensibles ;" . "<br>\n" .
            "- <u>Ne stockez pas</u> les mots de passe dans un fichier sur un poste informatique particulièrement exposé au risque" . "<br>\n" .
            "(exemple : en ligne sur Internet), encore moins sur un papier facilement accessible ;" . "<br>\n" .
            "- Ne vous envoyez pas vos propres mots de passe <u>sur votre messagerie personnelle</u> ;" . "<br>\n" .
            "- Configurez les logiciels, y compris votre navigateur web, <u>pour qu’ils ne se « souviennent » pas" . "<br>\n" .
            " des mots de passe choisis.</u>" . "<br>\n" .
            "<b>Votre mot de passe doit obligatoirement contenir :</b> " . "<br>\n" .
            "- des majuscules et minuscules," . "<br>\n" .
            "- des caractères spéciaux indiqués ci-après : @-_&*!%:;#~^" . "<br>\n" .
            "- les caractères tels que é,ç,+,à,è,`,(,),[,],{,},°,|,\,',\",/,?,\ et la , ne sont pas autorisés," . "<br>\n" .
            "- des chiffres," . "<br>\n" .
            "- il doit comporter au minimum 10 caractères et 64 au maximum.";

        return $html;
    }
}