<?php


class SecurityController
{

    private $formLoginView              = Constantes::PATH_FOLDER_TEMPLATES_SECURITY.'formLoginView.php';
    private $formRegistrationView       = Constantes::PATH_FOLDER_TEMPLATES_SECURITY.'formRegistrationView.php';
    private $formPasswordView           = Constantes::PATH_FOLDER_TEMPLATES_SECURITY.'formPasswordView.php';
    private $formMailView               = Constantes::PATH_FOLDER_TEMPLATES_FRONT.'formMailView.php';

    /**
     * --------- CONNEXION && DASHBOARD ---------
     */
    //Affichage page du formulaire de login
    public function afficherLoginForm()
    {
        $view = new View('Connexion');
        $view->render($this->formLoginView);
    }

    //Fonction de connexion
    public function login()
    {
        $email = filter_input(INPUT_POST, 'email');
        $controller     = new ControllerFront();
        $userManager    = new UserManager();
        $listPosts      = new PostManager();
        $controllerBack = new ControllerBack();
        $dashboardUser  = new DashboardUserController();
        $user = $userManager->getUserByEmail($email);

        //si l'objet user n'est pas vide
        if (!empty($user)) :
            $lastPosts = $listPosts->getPosts(1, 1);
            $comparePassword = password_verify(filter_input(INPUT_POST, 'password'), $user->getPassword());

            //si les mots de passe correspondent
            if ($comparePassword == true) :
                $_SESSION['id'] = $user->getId();
                $_SESSION['role'] = $user->getRole();

                switch (true) {
                    /** Role : Administrateur && Statut : actif */
                    case ($user->getRole() == Constantes::ROLE_ADMIN && $user->getState() == Constantes::USER_STATUS_VALIDATED) :
                        $controllerBack->getBackendDashboard();
                        $userManager->newConnexionDate();
                        break;

                    /** Role : Administrateur && Statut : inactif */
                    case ($user->getRole() == Constantes::ROLE_ADMIN && $user->getState() != Constantes::USER_STATUS_VALIDATED) :
                        $message = 'Vous n\'avez pas les autorisations pour accéder à cette page.';
                        throw new ExceptionOutput($message);
                        break;

                    /** Role : Utilisateur && Statut : en attente de validation */
                    case ($user->getRole() == Constantes::ROLE_USER && $user->getState() == Constantes::USER_PENDING_STATUS) :
                        $message = 'Vous n\'avez pas validé votre inscription, un email vous a été envoyé avec un lien vous permettant de le faire ! (vérifiez vos spams) ';
                        throw new ExceptionOutput($message);
                        break;

                    /** Role : Utilisateur && Statut : en attente de validation d'un modérateur */
                    case ($user->getRole() == Constantes::ROLE_USER && $user->getState() == Constantes::USER_PENDING_STATUS_MODO) :
                        $message = 'Vous n\'avez pas encore été validé par un modérateur, merci de patienter cela devrait se faire d\'ici 24 heures.';
                        throw new ExceptionOutput($message);
                        break;

                    /** Role : Utilisateur && Statut : actif */
                    case ($user->getRole() == Constantes::ROLE_USER && $user->getState() == Constantes::USER_STATUS_VALIDATED) :
                        $dashboardUser->getDashboardUser();
                        $userManager->newConnexionDate();
                        break;

                    /** Role : Utilisateur && Statut : supprimé */
                    case ($user->getRole() == Constantes::ROLE_USER && $user->getState() == Constantes::USER_STATUS_DELETED) :
                        $message = 'Votre compte n\'existe plus/pas.';
                        throw new ExceptionOutput($message);
                        break;

                    /** Statut : inconnu */
                    case ($user->getState() > Constantes::USER_STATUS_DELETED) :
                        $message = 'Vos informations de connexion ne correspondent pas.';
                        throw new ExceptionOutput($message);
                        break;

                    /** Role : inconnu */
                    case ($user->getRole() < Constantes::ROLE_ADMIN || $user->getRole() > Constantes::ROLE_USER) :
                        $message = 'Vos informations de connexion ne correspondent pas.';
                        throw new ExceptionOutput($message);
                        break;

                    case 'default':
                        $controller->afficherIndex();
                        break;
                }

            /** si les mots de passe ne correspondent pas */
            else:
                $message = 'Le mot de passe ne correspond pas avec celui utilisé à l\'inscription';

                $view = new View('Connexion');
                $view->render($this->formLoginView, ['message' => $message]);
            endif;

        /** si l'objet user est vide */
        else:
            $message = 'Vos informations de connexion ne correspondent pas.';

            $view = new View('Connexion');
            $view->render($this->formLoginView, ['message' => $message]);
        endif;
    }

    //Fonction de déconnection
    public function logout()
    {
        $controller = new ControllerFront();

        unset($_SESSION['id']);
        unset($_SESSION['role']);
        session_destroy();

        $controller->afficherIndex();
    }

    /**
     * --------- INSCRIPTION ---------
     */

    //Affichage de la page de formulaire d'une nouvelle inscription
    public function afficherNewLoginForm()
    {
        $userMessages = new User();
        $messagePassword = $userMessages->helpPassword();
        $messagePseudo = $userMessages->helpPseudo();

        $view = new View('Inscription');
        $view->render($this->formRegistrationView, ['messagePassword' => $messagePassword, 'messagePseudo' => $messagePseudo]);
    }

    //Fonction d'inscription
    public function inscription()
    {
        $controller = new ControllerFront();

        $user = new User($_REQUEST);
        $user->setRole(Constantes::ROLE_USER);
        $user->setState(Constantes::USER_PENDING_STATUS);
        $userManager = new UserManager();
        $userManager->registration($user);
        $list = $userManager->tokenRecuperation($user);
        $user->sendToken($list);
        $controller->afficherIndex();
    }

    //Fonction de confirmation de l'inscription via token
    public function confirmationByToken()
    {
        $token = $_REQUEST['token'];
        $userManager = new UserManager();
        $user = new User($_REQUEST);
        $user->setToken($token);
        $userManager->registrationConfirmationByToken($user);
        $userManager->deleteToken($user);

        $this->afficherLoginForm();
    }

    /**
     * --------- OUBLI PASSWORD ---------
     */

    //Affichage de la page de formulaire d'oubli de mot de passe
    public function afficherMailForm()
    {
        $view = new View('Formulaire');
        $view->render($this->formMailView);
    }

    //Fonction d'envoi de mail pour l'oubli du mot de passe
    public function envoyerEmailForPassword()
    {
        $controller = new ControllerFront();

        $user = new User($_REQUEST);
        $userManager = new UserManager();
        $list = $userManager->idUserRecuperation($user); //Récupération id_user par l'email
        $id_user = $list['id'];
        $userManager->tokenCreation($id_user); //Création du token
        $tokenList = $userManager->tokenRecuperation($user); //Récupération du token
        $user->sendTokenForPassword($tokenList); //Envoi du token par email

        $controller->afficherIndex();
    }

    //Affichage du formulaire pour modifier le mot de passe
    public function afficherPasswordForm()
    {
        $token = $_REQUEST['tokenForPassword'];
        $user = new User($_REQUEST);
        $user->setToken($token);
        $userManager = new UserManager();
        $tokenCount = $userManager->countToken($user); //Vérifie qu'il y a bien un token

        $messagePassword = $user->helpPassword();

        if ($tokenCount != 1) :
            $messageError = "Le token n'existe plus !";

            $view = new View('Formulaire');
            $view->render($this->formPasswordView , ['messagePassword' => $messagePassword, 'token' => $token, 'messageError' => $messageError]);

        else:
            $view = new View('Formulaire');
            $view->render($this->formPasswordView , ['messagePassword' => $messagePassword, 'token' => $token]);
        endif;

    }

    //Fonction de modification du mot de passe
    public function changerPassword()
    {
        $user = new User($_REQUEST);
        $userManager = new UserManager();
        $userManager->passwordModification($user);
        $userManager->deleteToken($user);

        $confirmationMessage = "Votre mot de passe a bien été modifié." ?? "";
        $view = new View('Connexion');
        $view->render($this->formLoginView, ['confirmationMessage' => $confirmationMessage]);
    }
}