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
        foreach ($listPosts as $post) {
            $commentManager->fillCommentInPost($post);
        }

        $nbPages = $postManager->countPages();

        $categoryManager = new CategoryManager();
        foreach ($listPosts as $post) {
            $categoryManager->fillCategoryInPost($post);
        }

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

        $view = new View('Erreur Output');
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