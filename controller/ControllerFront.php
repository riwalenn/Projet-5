<?php

class ControllerFront
{
    /**
     * --------- INDEX ---------
     */

    public function afficherIndex()
    {
        $portfolioManager = new PortfolioManager();
        $portfolio = $portfolioManager->getPortfolio();
        $portfolioCategoriesManager = new FolioCategoriesManager();

        foreach ($portfolio as $folio) :
            $portfolioCategoriesManager->fillCategoryInPortfolio($folio);
        endforeach;

        $view = new View('Riwalenn Bas - développeuse d\'applications PHP/Symfony');
        $view->render('view/indexView.php', ['portfolio' => $portfolio]);
    }

    /**
     * --------- CONNEXION && DASHBOARD ---------
     */

    //Affichage page du formulaire de login
    public function afficherLoginForm()
    {
        $view = new View('Connexion');
        $view->render('view/formLoginView.php');
    }

    //Fonction de connexion
    public function login()
    {
        $email = filter_input(INPUT_POST, 'email');
        $userManager = new UserManager();
        $listPosts = new PostManager();
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
                        $this->getBackendDashboard();
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
                        $this->getDashboardUser();
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
                        $this->afficherIndex();
                        break;
                }

            /** si les mots de passe ne correspondent pas */
            else:
                $message = 'Le mot de passe ne correspond pas avec celui utilisé à l\'inscription';

                $view = new View('Connexion');
                $view->render('view/formLoginView.php', ['message' => $message]);
            endif;

        /** si l'objet user est vide */
        else:
            $message = 'Vos informations de connexion ne correspondent pas.';

            $view = new View('Connexion');
            $view->render('view/formLoginView.php', ['message' => $message]);
        endif;
    }

    //Affichage le tableau de bord de l'utilisateur
    public function getDashboardUser($errorMessage = NULL)
    {
        $userManager = new UserManager();
        $listPosts = new PostManager();
        $commentManager = new CommentManager();
        $categoryManager = new CategoryManager();

        $user = $userManager->getUserBySessionId();
        if ($user->getRole() == Constantes::ROLE_USER && $user->getState() == Constantes::USER_STATUS_VALIDATED) :
            $favoritesPosts = $listPosts->getFavoritePostByIdUser($user);
            foreach ($favoritesPosts as $post) :
                $commentManager->fillCommentInPost($post);
                $categoryManager->fillCategoryInPost($post);
            endforeach;

            $lastPosts = $listPosts->getPosts(1, 1);
            foreach ($lastPosts as $post) :
                $commentManager->fillCommentInPost($post);
                $categoryManager->fillCategoryInPost($post);
                $listPosts->fillFavoriteInPost($user, $post);
            endforeach;

            $view = new View('Tableau de bord');
            $view->render('view/dashboardView.php', ['favoritesPosts' => $favoritesPosts, 'errorMessage' => $errorMessage, 'lastPosts' => $lastPosts, 'user' => $user]);
        else:
            $message = "Vous n'avez pas les autorisations pour accéder à cette page.";
            throw new ExceptionOutput($message);
        endif;
    }

    //Modification des données utilisateurs
    public function UpdateDataByUser()
    {
        if (!empty($_SESSION['id'] == filter_input(INPUT_POST, 'id'))) :
            $user = new User($_REQUEST);
            $userManager = new UserManager();
            $userBdd = $userManager->getUserBySessionId();
            $comparePassword = password_verify(filter_input(INPUT_POST, 'password'), $userBdd->getPassword());

            if ($comparePassword == true) :
                $userManager->updateUserByUser($user);
                $this->getDashboardUser();
            else:
                $message = 'Votre mot de passe ne correspond pas';
                throw new ExceptionOutput($message);
            endif;
        else:
            $message = 'Votre identification de session ne correspond pas !';
            throw new ExceptionOutput($message);
        endif;
    }

    //Fonction de déconnection
    public function logout()
    {
        unset($_SESSION['id']);
        unset($_SESSION['role']);
        session_destroy();

        $this->afficherIndex();
    }

    /**
     * --------- FAVORIS DE L'UTILISATEUR ---------
     */

    //Ajout d'un post favoris, limité à 10
    public function addFavoritePost()
    {
        if (!empty($_SESSION['id']) && (filter_input(INPUT_POST, 'id_post'))) :
            $user = new User($_SESSION);
            $postFavoris = new Favorites_posts($_REQUEST);
            $postManager = new PostManager();
            $nbFavorites = $postManager->countFavoritesPostUser($user);
            $result = $postManager->searchFavorite($user, $postFavoris);
            $errorMessage = '';
            if ($nbFavorites < 11) :
                if ($result == true) {
                    $errorMessage = 'Info : Vous avez déjà ajouté ce favoris.';
                } else {
                    $postManager->addFavoritePostByIdUser($user, $postFavoris);
                    $errorMessage = 'Le favoris a été ajouté avec succès.';
                }
            else:
                $errorMessage = 'Info : Vous avez atteint le nombre maximal de favoris.';
            endif;
            $this->getDashboardUser($errorMessage);
        else:
            $message = 'Erreur : Votre identification de session ne correspond pas !';
            throw new ExceptionOutput($message);
        endif;
    }

    //Suppression d'un favoris
    public function deleteFavoritePost()
    {
        $errorMessage = '';
        if (!empty($_SESSION['id']) && (filter_input(INPUT_POST, 'id_post'))) :
            $user = new User($_SESSION);
            $favorites = new Favorites_posts($_REQUEST);
            $postManager = new PostManager();
            $postManager->deleteFavoritePostByIdUser($user, $favorites);
            $errorMessage = 'Le favoris a bien été supprimé.';
            $this->getDashboardUser($errorMessage);
        else:
            $message = 'Votre identification de session ne correspond pas !';
            throw new ExceptionOutput($message);
        endif;
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
        $view->render('view/formRegistrationView.php', ['messagePassword' => $messagePassword, 'messagePseudo' => $messagePseudo]);
    }

    //Fonction d'inscription
    public function inscription()
    {
        $user = new User($_REQUEST);
        $user->setRole(Constantes::ROLE_USER);
        $user->setState(Constantes::USER_PENDING_STATUS);
        $userManager = new UserManager();
        $userManager->registration($user);
        $list = $userManager->tokenRecuperation($user);
        $user->sendToken($list);
        $this->afficherIndex();
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
        $view->render('view/formMailView.php');
    }

    //Fonction d'envoi de mail pour l'oubli du mot de passe
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
            $view->render('view/formPasswordView.php', ['messagePassword' => $messagePassword, 'token' => $token, 'messageError' => $messageError]);

        else:
            $view = new View('Formulaire');
            $view->render('view/formPasswordView.php', ['messagePassword' => $messagePassword, 'token' => $token]);
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
        $view->render('view/formLoginView.php', ['confirmationMessage' => $confirmationMessage]);
    }

    /**
     * --------- ARTICLES & RECHERCHE ---------
     */

    //Affichage de la page des résultats de recherche des articles
    public function afficherResultatRecherche($errorMessage = NULL)
    {
        $errorMessage = '';
        if (empty(filter_input(INPUT_GET, 'submit'))) {
            $this->afficherListeArticles();
        }
        $pageCourante = filter_input(INPUT_GET, 'page') ?? 1;
        $submitRecherche = filter_input(INPUT_GET, 'submit') ?? "";
        $postManager = new PostManager();
        $listPosts = $postManager->getSearch($submitRecherche, $pageCourante);

        $commentManager = new CommentManager();
        foreach ($listPosts as $post) {
            $commentManager->fillCommentInPost($post);
        }

        $nbPages = $postManager->countPagesSearchResult($submitRecherche);
        $userManager = new UserManager();

        $categoryManager = new CategoryManager();
        foreach ($listPosts as $post) {
            $categoryManager->fillCategoryInPost($post);
            if (!empty($_SESSION['id'])) :
                $user = $userManager->getUserBySessionId();
                $postManager->fillFavoriteInPost($user, $post);
            endif;
        }

        $view = new View('Liste des articles');
        $view->render('view/articlesView.php', ['listPosts' => $listPosts, 'errorMessage' => $errorMessage, 'nbPages' => $nbPages, 'pageCourante' => $pageCourante, 'submitRecherche' => $submitRecherche]);
    }

    //Affichage de la page des articles
    public function afficherListeArticles($errorMessage = NULL)
    {
        $errorMessage = '';
        $pageCourante = filter_input(INPUT_GET, 'page') ?? 1;
        $statut = 1; //Afficher les articles validés
        $postManager = new PostManager();
        $listPosts = $postManager->getPosts($pageCourante, $statut);

        $commentManager = new CommentManager();
        $categoryManager = new CategoryManager();
        $userManager = new UserManager();
        foreach ($listPosts as $post) {
            $commentManager->fillCommentInPost($post);
            $categoryManager->fillCategoryInPost($post);
            if (!empty($_SESSION['id'])) :
                $user = $userManager->getUserBySessionId();
                $postManager->fillFavoriteInPost($user, $post);
            endif;
        }

        $nbPages = $postManager->countPagesByState(3, 1);

        $view = new View('Liste des articles');
        $view->render('view/articlesView.php', ['listPosts' => $listPosts, 'errorMessage' => $errorMessage, 'nbPages' => $nbPages, 'pageCourante' => $pageCourante]);
    }

    // Ajout d'un commentaire pour un utilisateur connecté
    public function ajoutCommentaire()
    {
        $comment = new Comment($_REQUEST);
        $comment->setPseudo($_SESSION['id']);
        $comment->setState(Constantes::COM_PENDING_STATUS);

        $commentManager = new CommentManager();
        $commentManager->addComment($comment);

        $this->afficherListeArticles();
    }

    /**
     * --------- BACKEND ADMIN ---------
     */

    //Affiche le backend Admin
    public function getBackendDashboard()
    {
        $userManager = new UserManager();
        $postManager = new PostManager();
        $commentManager = new CommentManager();
        $categoryManager = new CategoryManager();
        $portfolioManager = new PortfolioManager();
        $portfolio = $portfolioManager->getPortfolio();

        $user = $userManager->getUserBySessionId();
        if ($user->getRole() == Constantes::ROLE_ADMIN && $user->getState() == Constantes::USER_STATUS_VALIDATED) :
            $value = filter_input(INPUT_GET, 'value');
            if (isset($value)) {
                switch ($value) {
                    case 'tokenExpired':
                        $userManager->deleteUsersExpiredToken();
                        break;

                    case 'connexionExpired':
                        $userManager->deleteUsersExpiredConnection();
                        break;

                    case 'postsToDelete':
                        $postManager->deletePosts();
                        break;
                }
            }
            //Compteurs utilisateurs
            $nbUsersTotal = $userManager->countAllUsers();
            $nbUsersReferent = $userManager->countReferents();
            $nbUsersWaitingList = $userManager->countUsersUncheckedByModo();
            $nbUsersConnexionExpired = $userManager->countUsersExpiredConnection();
            $nbUsersTokenExpired = $userManager->countUsersExpiredToken();
            $nbUsersTokenNotValidate = $userManager->countUsersTokenUnchecked();
            $nbUsersToDelete = $userManager->countUsersToDelete();


            //Compteurs articles
            $nbPostTotal = $postManager->countAllPosts();
            $nbPostsUnchecked = $postManager->countPostsUnckecked();
            $nbPostsArchived = $postManager->countPostsArchived();
            $nbPostsToDelete = $postManager->countPostsToDelete();
            $nbPostsByCategory = $postManager->countPostsByCategory();

            //Compteur commentaires
            $nbCommentsUnchecked = $commentManager->countCommentsUncheked();
            $nbCommentsToDelete = $commentManager->countCommentsToDelete();

            $categories = $categoryManager->selectAllCategories();

            $view = new View('Tableau de bord');
            $view->render('view/dashboardAdminView.php', ['portfolio' => $portfolio, 'user' => $user, 'nbPostsUnchecked' => $nbPostsUnchecked, 'nbPostsArchived' => $nbPostsArchived, 'nbPostsToDelete' => $nbPostsToDelete, 'nbUsersTotal' => $nbUsersTotal, 'nbUsersReferent' => $nbUsersReferent, 'nbUsersWaitingList' => $nbUsersWaitingList, 'nbUsersTokenExpired' => $nbUsersTokenExpired, 'nbUsersConnexionExpired' => $nbUsersConnexionExpired, 'nbUsersTokenNotValidate' => $nbUsersTokenNotValidate, 'nbUsersToDelete' => $nbUsersToDelete, 'nbPostTotal' => $nbPostTotal, 'nbPostsByCategory' => $nbPostsByCategory, 'nbCommentsUnchecked' => $nbCommentsUnchecked, 'nbCommentsToDelete' => $nbCommentsToDelete, 'categories' => $categories]);
        else:
            $message = "Vous n'avez pas les autorisations pour accéder à cette page !";
            throw new ExceptionOutput($message);
        endif;
    }

    //Affiche le pannel de management utilisateurs
    public function getUsersDashboardManager($errorMessage = NULL)
    {
        $userManager = new UserManager();
        $user = $userManager->getUserBySessionId();
        $errorMessage = '';

        if ($user->getRole() == Constantes::ROLE_ADMIN && $user->getState() == Constantes::USER_STATUS_VALIDATED) {
            $crud = filter_input(INPUT_GET, 'CRUD');
            if (isset($crud)) {
                $errorMessage = $this->crudUserManager($crud);
            }

            $dtz = new DateTimeZone("Europe/Madrid");
            $now = new DateTime(date("Y-m-d H:i:s"), $dtz);

            $usersList = [];
            $allValues = [
                "all" => "Tous les utilisateurs",
                "uncheckedUsers" => "Utilisateurs à valider",
                "uncheckedTokenUsers" => "Tokens non validés",
                "referents" => "Utilisateurs référents",
                "trash" => "Comptes à supprimer"
            ];
            $filArianne = '';
            $value = filter_input(INPUT_GET, 'value');
            if (isset($value)) {
                switch ($value) {
                    case 'uncheckedUsers':
                        $usersList = $userManager->selectUsersUncheckedByModo();
                        $filArianne = 'Utilisateurs à valider';
                        break;

                    case 'uncheckedTokenUsers':
                        $usersList = $userManager->selectUsersTokenUnchecked();
                        $filArianne = 'Tokens non validés';
                        break;

                    case 'all':
                        $usersList = $userManager->selectAllUsers();
                        $filArianne = 'Tous les utilisateurs';
                        break;

                    case 'referents':
                        $usersList = $userManager->selectReferents();
                        $filArianne = 'Utilisateurs référents';
                        break;

                    case 'trash':
                        $usersList = $userManager->selectUsersInTrash();
                        $filArianne = 'Comptes à supprimer';
                        break;

                    default:
                        $usersList = $userManager->selectAllUsers();
                        $filArianne = 'Tous les utilisateurs';
                        break;
                }

                $view = new View('Liste des utilisateurs');
                $view->render('view/managerUsersView.php', ['usersList' => $usersList, 'allValues' => $allValues, 'errorMessage' => $errorMessage, 'value' => $value, 'now' => $now, 'filArianne' => $filArianne]);
            }
        } else {
            $message = "Vous n'avez pas les autorisations pour accéder à cette page !";
            throw new ExceptionOutput($message);
        }
    }

    //Create, Read, Update, Delete
    public function crudUserManager($crud)
    {
        $userManager = new UserManager();
        $user = new User($_REQUEST);
        $errorMessage = '';
        switch ($crud) {
            //Create
            case 'C':
                $user->setCgu(1);
                $userManager->registration($user);
                $errorMessage = 'L\'utilisateur a été créé avec succès.';
                break;

            //Update
            case 'U':
                $userManager->updateUser($user);
                $errorMessage = 'L\'utilisateur a été édité avec succès.';
                break;

            //Delete
            case 'D':
                $date_user = new DateTime($user->getDate_modification());
                $now = new DateTime();
                $interval = $date_user->diff($now);
                if ($user->getState() == 3) {
                    if ($interval->format('%R%a days') > 7) {
                        $userManager->updateIdUserInComments($user);
                        $userManager->deleteUser($user);
                        $errorMessage = 'L\'utilisateur a été supprimé avec succès.';
                    } else {
                        $errorMessage = 'Erreur : L\'utilisateur s\'est connecté récemment.';
                    }
                } else {
                    $errorMessage = 'Erreur : L\'utilisateur n\'a pas le status "supprimé"';
                }
                break;
        }

        return $errorMessage;
    }

    //Affiche le panel de management des commentaires
    public function getCommentsDashboardManager($errorMessage = NULL)
    {
        $userManager = new UserManager();
        $user = $userManager->getUserBySessionId();
        $commentairesManager = new CommentManager();
        $crud = filter_input(INPUT_GET, 'CRUD');

        if ($user->getRole() == Constantes::ROLE_ADMIN && $user->getState() == Constantes::USER_STATUS_VALIDATED) {
            if (isset($crud)) {
                $errorMessage = $this->crudCommentsManager($crud);
            }

            $commentaires = $commentairesManager->getAllComments();

            $view = new View('Commentaires');
            $view->render('view/managerCommentsView.php', ['user' => $user, 'commentaires' => $commentaires, 'errorMessage' => $errorMessage]);
        }
    }

    public function crudCommentsManager($crud)
    {
        $commentairesManager = new CommentManager();
        $commentaires = new Comment($_REQUEST);
        $errorMessage = '';
        switch ($crud) {
            //Update
            case 'US':
                $commentairesManager->updateCommentState($commentaires);
                $errorMessage = 'Le statut a été modifié avec succès.';
                break;

            case 'U':
                $commentairesManager->updateComment($commentaires);
                $errorMessage = 'Le commentaire a été modifié avec succès.';
                break;

            //Delete
            case 'D':
                $commentairesManager->deleteComments();
                $errorMessage = 'Les commentaires ont été supprimés.';
                break;
        }
        return $errorMessage;
    }

    //Affiche le pannel de management du portfolio
    public function getPortfolioDashboardManager($errorMessage = NULL)
    {
        $userManager = new UserManager();
        $portfolioManager = new PortfolioManager();
        $user = $userManager->getUserBySessionId();
        $errorMessage = '';

        if ($user->getRole() == Constantes::ROLE_ADMIN && $user->getState() == Constantes::USER_STATUS_VALIDATED) {
            $crud = filter_input(INPUT_GET, 'CRUD');
            if (isset($crud)) {
                $errorMessage = $this->crudPortfolioManager($crud);
            }

            $portfolio = $portfolioManager->getPortfolio();

            $view = new View('Portfolio');
            $view->render('view/managerPortfolioView.php', ['user' => $user, 'portfolio' => $portfolio, 'errorMessage' => $errorMessage]);
        }
    }

    public function crudPortfolioManager($crud)
    {
        $portfolioManager = new PortfolioManager();
        $portfolio = new Portfolio($_REQUEST);
        $errorMessage = '';
        switch ($crud) {
            //Create
            case 'C':
                if (isset($_FILES['foliojpg']) && $_FILES['foliowebp']) {
                    if ($_FILES['foliojpg']['error'] == 0 && $_FILES['foliowebp']['error'] == 0) :
                        if ($_FILES['foliojpg']['size'] <= 200000 && $_FILES['foliowebp']['size'] <= 200000) :
                            $portfolioManager = new PortfolioManager();
                            $lastInsertId = $portfolioManager->createPortfolio($portfolio);

                            $uploaddir = 'ressources/img/portfolio/';
                            $infosfichierjpg = pathinfo($_FILES['foliojpg']['name']);
                            $infosfichierwebp = pathinfo($_FILES['foliowebp']['name']);
                            $extensionUpdloadjpg = $infosfichierjpg['extension'];
                            $extensionUpdloadwebp = $infosfichierwebp['extension'];
                            $extensionsAuthorized = array('jpg', 'webp');
                            $uploadfilejpg = $uploaddir . basename($lastInsertId) . '.' . $extensionUpdloadjpg;
                            $uploadfilewebp = $uploaddir . basename($lastInsertId) . '.' . $extensionUpdloadwebp;

                            if (in_array($extensionUpdloadjpg, $extensionsAuthorized)) :
                                move_uploaded_file($_FILES['foliojpg']['tmp_name'], $uploadfilejpg);
                            else :
                                $errorMessage = "L'extension ne correspond pas.";
                            endif;

                            if (in_array($extensionUpdloadwebp, $extensionsAuthorized)) :
                                move_uploaded_file($_FILES['foliowebp']['tmp_name'], $uploadfilewebp);
                            else :
                                $errorMessage = "Erreur : L'extension ne correspond pas.";
                            endif;

                        else :
                            $errorMessage = "Erreur : Le fichier est trop volumineux.";
                        endif;
                    endif;
                }
                $errorMessage = 'Le Portfolio a été créé avec succès.';
                break;

            //Update
            case 'U':
                if (isset($_FILES['foliojpg']) || $_FILES['foliowebp']) {
                    if ($_FILES['foliojpg']['error'] == 0 || $_FILES['foliowebp']['error'] == 0) :
                        if ($_FILES['foliojpg']['size'] <= 200000 || $_FILES['foliowebp']['size'] <= 200000) :
                            $portfolioManager = new PortfolioManager();
                            $id = $portfolio->getId();

                            $uploaddir = 'ressources/img/portfolio/';
                            $infosfichierjpg = pathinfo($_FILES['foliojpg']['name']);
                            $infosfichierwebp = pathinfo($_FILES['foliowebp']['name']);
                            $extensionUpdloadjpg = $infosfichierjpg['extension'];
                            $extensionUpdloadwebp = $infosfichierwebp['extension'];
                            $extensionsAuthorized = array('jpg', 'webp');
                            $uploadfilejpg = $uploaddir . basename($id) . '.' . $extensionUpdloadjpg;
                            $uploadfilewebp = $uploaddir . basename($id) . '.' . $extensionUpdloadwebp;

                            if (in_array($extensionUpdloadjpg, $extensionsAuthorized)) :
                                move_uploaded_file($_FILES['foliojpg']['tmp_name'], $uploadfilejpg);
                            else :
                                return $errorMessage = "Erreur : L'extension ne correspond pas.";
                            endif;

                            if (in_array($extensionUpdloadwebp, $extensionsAuthorized)) :
                                move_uploaded_file($_FILES['foliowebp']['tmp_name'], $uploadfilewebp);
                            else :
                                $errorMessage = "Erreur : L'extension ne correspond pas.";
                            endif;
                        else :
                            $errorMessage = "Erreur : Le fichier est trop volumineux.";
                        endif;
                    endif;
                }
                $portfolioManager->updatePortfolio($portfolio);
                $errorMessage = 'Le Portfolio a été modifié avec succès.';
                break;

            //Update
            case 'SU':
                $portfolioManager->updatePortfolio($portfolio);
                $errorMessage = 'Le Portfolio a été modifié avec succès.';
                break;

            //Delete
            case 'D':
                $id = $portfolio->getId();
                $jpegToDelete = "ressources/img/portfolio/" . $id . '.jpg';
                $webpToDelete = "ressources/img/portfolio/" . $id . '.webp';
                unlink($jpegToDelete);
                unlink($webpToDelete);
                $portfolioManager->deletePortfolio($portfolio);
                $errorMessage = 'Le Portfolio a été supprimé avec succès.';
                break;
        }
        return $errorMessage;
    }

    //Affiche le pannel de management des articles
    public function getPostsDashboardManager($errorMessage = NULL)
    {
        $userManager = new UserManager();
        $user = $userManager->getUserBySessionId();
        $errorMessage = '';

        if ($user->getRole() == Constantes::ROLE_ADMIN && $user->getState() == Constantes::USER_STATUS_VALIDATED) {
            $crud = filter_input(INPUT_GET, 'CRUD');
            if (isset($crud)) {
                $errorMessage = $this->crudPostManager($crud);
            }

            $postManager = new PostManager();
            $categoryManager = new CategoryManager();
            $categories = $categoryManager->selectAllCategories();
            $pageCourante = filter_input(INPUT_GET, 'page') ?? 1;
            $allValues = [
                "all" => "Tous les articles",
                "uncheckedPosts" => "Articles à valider",
                "checkedPosts" => "Articles validés",
                "archived" => "Articles archivés",
                "trash" => "Articles à supprimer"
            ];
            $nbPosts = 10;
            $value = filter_input(INPUT_GET, 'value');
            if (isset($value)) {
                $categoryManager = new CategoryManager();
                switch ($value) {
                    case 'all':
                        $postsList = $postManager->getAllPosts($pageCourante, $nbPosts);
                        $nbPages = $postManager->countPagesByAllStates($nbPosts);
                        $filArianne = 'Tous les articles';
                        break;

                    case 'uncheckedPosts':
                        $postsList = $postManager->getPostsByState($pageCourante, 0, $nbPosts);
                        $nbPages = $postManager->countPagesByState($nbPosts, 0);
                        $filArianne = 'Articles à valider';
                        break;

                    case 'checkedPosts':
                        $postsList = $postManager->getPostsByState($pageCourante, 1, $nbPosts);
                        $nbPages = $postManager->countPagesByState($nbPosts, 1);
                        $filArianne = 'Articles validés';
                        break;

                    case 'archived':
                        $postsList = $postManager->getPostsByState($pageCourante, 2, $nbPosts);
                        $nbPages = $postManager->countPagesByState($nbPosts, 2);
                        $filArianne = 'Articles archivés';
                        break;

                    case 'trash':
                        $postsList = $postManager->getPostsByState($pageCourante, 3, $nbPosts);
                        $nbPages = $postManager->countPagesByState($nbPosts, 3);
                        $filArianne = 'Articles à supprimer';
                        break;

                    default:
                        $postsList = $postManager->getPostsByState($pageCourante, 1, $nbPosts);
                        $nbPages = $postManager->countPagesByState($nbPosts, 1);
                        $filArianne = 'Tous les articles';
                        break;
                }
            }
            foreach ($postsList as $post) {
                $categoryManager->fillCategoryInPost($post);
            }
            $view = new View('Liste des articles');
            $view->render('view/managerPostsView.php', ['errorMessage' => $errorMessage, 'allValues' => $allValues, 'categories' => $categories, 'pageCourante' => $pageCourante, 'nbPages' => $nbPages, 'value' => $value, 'filArianne' => $filArianne, 'postsList' => $postsList]);
        } else {
            $message = "Vous n'avez pas les autorisations pour accéder à cette page !";
            throw new ExceptionOutput($message);
        }
    }

    public function crudPostManager($crud)
    {
        $postManager = new PostManager();
        $post = new Post($_REQUEST);
        $userManager = new UserManager();
        $user = $userManager->getUserBySessionId();
        $errorMessage = '';
        switch ($crud) {
            case 'U':
                $postManager->updatePost($post);
                $errorMessage = 'L\'article a été édité avec succès.';
                break;

            case 'FU':
                $postManager->fullUpdatePost($post);
                $errorMessage = 'L\'article a été édité avec succès.';
                break;

            case 'C':
                $post->setAuthor($user->getId());
                $postManager->createPost($post);
                $errorMessage = 'L\'article a été créé avec succès.';
                break;

            case 'D':
                if ($post->getState() == Constantes::POST_STATUS_DELETED) :
                    $postManager->deletePost($post);
                    $errorMessage = 'L\'article a été supprimé avec succès.';
                else:
                    $errorMessage = 'Erreur : L\'utilisateur n\'a pas le status "supprimé"';
                endif;
                break;
        }
        return $errorMessage;
    }

    public function installBlog()
    {
        //faire une vérification de la database avec show tables => si c'est vide créé les tables
        $installationManager = new Installation();
        $show = $installationManager->showTables();
        if (count($show) == 0) :
            $installationManager->installCategoriesTable();
            $installationManager->installCommentsTable();
            $installationManager->installFavoritesTable();
            $installationManager->installPortfolioTable();
            $installationManager->installPostsTable();
            $installationManager->installTokensTable();
            $installationManager->installUsersTable();
            $installationManager->addConstraints();
            $installationManager->installData();
            echo 'L\'installation c\'est bien passée';
        elseif (count($show) > 0):
            echo 'Les tables existent déjà !';
        endif;

        $this->afficherIndex();
    }

    /**
     * --------- ERREURS ---------
     */

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