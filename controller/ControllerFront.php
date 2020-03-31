<?php

class ControllerFront
{
    // --------- Index ---------
    public function afficherIndex()
    {
        $portfolioManager = new PortfolioManager();
        $portfolio = $portfolioManager->getPortfolio();

        $view = new View('Riwalenn Bas - développeuse d\'applications PHP/Symfony');
        $view->render('view/indexView.php', ['portfolio' => $portfolio]);
    }

    // --------- Connexion ---------

    public function afficherLoginForm()
    {
        $view = new View('Connexion');
        $view->render('view/loginView.php');
    }

    public function login()
    {
        $email = $_REQUEST['email'];
        $userManager = new UserManager();
        $listPosts = new PostManager();
        $user = $userManager->getUserByEmail($email);

        //si l'objet user n'est pas vide
        if (!empty($user)) :
            $lastPosts = $listPosts->getLastsPosts();
            $comparePassword = password_verify($_REQUEST['password'], $user->getPassword());

            //si les mots de passe correspondent
            if ($comparePassword == true) :
                $_SESSION['id'] = $user->getId();
                $_SESSION['role'] = $user->getRole();

            switch (true)
            {
                /** Role : Administrateur && Statut : actif */
                case ($user->getRole() == 1 && $user->getState() == 2) :
                    $view = new View('Tableau de bord');
                    $view->render('view/dashboardAdminView.php', ['user' => $user]);
                    break;

                /** Role : Administrateur && Statut : inactif */
                case ($user->getRole() == 1 && $user->getState() != 2) :
                    $message = 'Vous n\'avez pas les autorisations pour accéder à cette page.';
                    throw new ExceptionOutput($message);
                    break;

                /** Role : Utilisateur && Statut : en attente de validation */
                case ($user->getRole() == 2 && $user->getState() == 0) :
                    $message = 'Vous n\'avez pas validé votre inscription, un email vous a été envoyé avec un lien vous permettant de le faire ! (vérifiez vos spams) ';
                    throw new ExceptionOutput($message);
                    break;

                /** Role : Utilisateur && Statut : en attente de validation d'un modérateur */
                case ($user->getRole() == 2 && $user->getState() == 1) :
                    $message = 'Vous n\'avez pas encore été validé par un modérateur, merci de patienter cela devrait se faire d\'ici 24 heures.';
                    throw new ExceptionOutput($message);
                    break;

                /** Role : Utilisateur && Statut : actif */
                case ($user->getRole() == 2 && $user->getState() == 2) :
                    $commentManager = new CommentManager();
                    $categoryManager = new CategoryManager();
                    foreach ($lastPosts as $post) :
                        $commentManager->fillCommentInPost($post);
                        $categoryManager->fillCategoryInPost($post);
                    endforeach;

                    $view = new View('Tableau de bord');
                    $view->render('view/dashboardView.php', ['lastPosts' => $lastPosts, 'user' => $user]);
                    break;

                /** Role : Utilisateur && Statut : supprimé */
                case ($user->getRole() == 2 && $user->getState() == 3) :
                    $message = 'Votre compte n\'existe plus/pas.';
                    throw new ExceptionOutput($message);
                    break;

                /** Statut : inconnu */
                case ($user->getState() > 3) :
                    $message = 'Vos informations de connexion ne correspondent pas.';
                    throw new ExceptionOutput($message);
                    break;

                /** Role : inconnu */
                case ($user->getRole() < 1 || $user->getRole() > 2) :
                    $message = 'Vos informations de connexion ne correspondent pas.';
                    throw new ExceptionOutput($message);
                    break;

                case 'default':
                    $this->afficherIndex();
                    break;
            }

            /** si les mots de passe ne correspondent pas */
            else:
                $message = 'Le mot de passe ne correspond pas avec celui utilisé à l\'inscription';

                $view = new View('Connexion');
                $view->render('view/loginView.php', ['message' => $message]);
            endif;

        /** si l'objet user est vide */
        else:
            $message = 'Vos informations de connexion ne correspondent pas.';

            $view = new View('Connexion');
            $view->render('view/loginView.php', ['message' => $message]);
        endif;
    }

    public function getDashboardUser()
    {
        $userManager = new UserManager();
        $user = $userManager->getUserBySessionId();
        $listPosts = new PostManager();
        $lastPosts = $listPosts->getLastsPosts();
        $commentManager = new CommentManager();
        $categoryManager = new CategoryManager();
        foreach ($lastPosts as $post) :
            $commentManager->fillCommentInPost($post);
            $categoryManager->fillCategoryInPost($post);
        endforeach;

        $view = new View('Tableau de bord');
        $view->render('view/dashboardView.php', ['lastPosts' => $lastPosts, 'user' => $user]);
    }

    public function getBackendDashboard()
    {
        $userManager = new UserManager();
        $user = $userManager->getUserBySessionId();

        $view = new View('Tableau de bord');
        $view->render('view/dashboardAdminView.php', ['user' => $user]);
    }

    public function logout()
    {
        unset($_SESSION['id']);
        unset($_SESSION['role']);
        session_destroy();

        $this->afficherIndex();
    }

    // --------- Inscription ---------

    public function afficherNewLoginForm()
    {
        $userMessages = new User();
        $messagePassword = $userMessages->helpPassword();
        $messagePseudo = $userMessages->helpPseudo();

        $view = new View('Inscription');
        $view->render('view/registrationView.php', ['messagePassword' => $messagePassword, 'messagePseudo' => $messagePseudo]);
    }

    public function inscription()
    {
        $user = new User($_REQUEST);
        $user->setRole(2);
        $user->setState(0);
        $userManager = new UserManager();
        $userManager->registration($user);
        $list = $userManager->tokenRecuperation($user);
        $user->sendToken($list);
        $this->afficherIndex();
    }

    public function confirmationByToken()
    {
        $token = $_REQUEST['token'];
        $userManager = new UserManager();
        $user = new User($_REQUEST);
        $user->setToken($token);
        $userManager->registrationConfirmationByToken($user);
        $userManager->deleteToken($user);

        $this->afficherIndex();
    }

    // --------- Oubli password ---------

    public function afficherMailForm()
    {
        $view = new View('Formulaire');
        $view->render('view/mailFormView.php');
    }

    public function envoyerEmailForPassword()
    {
        $user = new User($_REQUEST);
        $userManager = new UserManager();
        $list = $userManager->idUserRecuperation($user); //Récupération id_user par l'email
        $id_user = $list['id'];
        $userManager->tokenCreation($id_user); //Création du token
        $tokenList = $userManager->tokenRecuperation($user); //Récupération du token
        $user->sendTokenForPassword($tokenList); //Envoi du token par email

        $this->afficherIndex();
    }

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
            $view->render('view/passwordFormView.php', ['messagePassword' => $messagePassword, 'token' => $token, 'messageError' => $messageError]);

        else:
            $view = new View('Formulaire');
            $view->render('view/passwordFormView.php', ['messagePassword' => $messagePassword, 'token' => $token]);
        endif;

    }

    public function changerPassword()
    {
        $user = new User($_REQUEST);
        $userManager = new UserManager();
        $userManager->passwordModification($user);
        $userManager->deleteToken($user);

        $confirmationMessage = "Votre mot de passe a bien été modifié." ?? "";
        $view = new View('Connexion');
        $view->render('view/loginView.php', ['confirmationMessage' => $confirmationMessage]);
    }

    // --------- Recherche ---------

    public function afficherResultatRecherche()
    {
        $pageCourante = $_REQUEST['page'] ?? 1;
        $submitRecherche = $_REQUEST['submit'] ?? "";
        $postManager = new PostManager();
        $listPosts = $postManager->getSearch($submitRecherche, $pageCourante);

        $commentManager = new CommentManager();
        foreach ($listPosts as $post) {
            $commentManager->fillCommentInPost($post);
        }

        $nbPages = $postManager->countPagesSearchResult($submitRecherche);

        $categoryManager = new CategoryManager();
        foreach ($listPosts as $post) {
            $categoryManager->fillCategoryInPost($post);
        }

        $view = new View('Liste des articles');
        $view->render('view/articlesView.php', ['listPosts' => $listPosts, 'nbPages' => $nbPages, 'pageCourante' => $pageCourante, 'submitRecherche' => $submitRecherche]);
    }

    // --------- Articles ---------

    public function afficherListeArticles()
    {
        $pageCourante = $_REQUEST['page'] ?? 1;
        $postManager = new PostManager();
        $listPosts = $postManager->getPosts($pageCourante);

        $commentManager = new CommentManager();
        $categoryManager = new CategoryManager();
        foreach ($listPosts as $post) {
            $commentManager->fillCommentInPost($post);
            $categoryManager->fillCategoryInPost($post);
        }

        $nbPages = $postManager->countPages();

        $view = new View('Liste des articles');
        $view->render('view/articlesView.php', ['listPosts' => $listPosts, 'nbPages' => $nbPages, 'pageCourante' => $pageCourante]);
    }

    // --------- Erreurs ---------

    public function erreurPDO($pdoException)
    {
        $erreurMessage = $pdoException->getMessage();
        $erreurCode = $pdoException->getCode();
        $erreurLine = $pdoException->getLine();
        $erreurFile = $pdoException->getFile();

        $view = new View('Erreur PDO');
        $view->render('view/errorView.php', ['erreurMessage' => $erreurMessage, 'erreurCode' => $erreurCode, 'erreurLine' => $erreurLine, 'erreurFile' => $erreurFile]);
    }

    public function erreurOutput($outputException)
    {
        $erreurMessage = $outputException->getMessage();
        $erreurCode = $outputException->getCode();
        $erreurLine = $outputException->getLine();
        $erreurFile = $outputException->getFile();

        $view = new View('Erreur');
        $view->render('view/errorView.php', ['erreurMessage' => $erreurMessage, 'erreurCode' => $erreurCode, 'erreurLine' => $erreurLine, 'erreurFile' => $erreurFile]);
    }

    public function erreur()
    {
        $erreurManager = new Exception();
        $erreurMessage = $erreurManager->getMessage();
        $erreurCode = $erreurManager->getCode();
        $erreurLine = $erreurManager->getLine();
        $erreurFile = $erreurManager->getFile();

        $view = new View('Exception');
        $view->render('view/errorView.php', ['erreurMessage' => $erreurMessage, 'erreurCode' => $erreurCode, 'erreurLine' => $erreurLine, 'erreurFile' => $erreurFile]);
    }
}