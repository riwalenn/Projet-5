<?php


class ManagersController
{
    private $managerUsersView           = Constantes::PATH_FOLDER_TEMPLATES_SECURITY.'managerUsersView.php';
    private $managerCommentsView        = Constantes::PATH_FOLDER_TEMPLATES_SECURITY.'managerCommentsView.php';
    private $managerPortfolioView       = Constantes::PATH_FOLDER_TEMPLATES_SECURITY.'managerPortfolioView.php';
    private $managerPostsView           = Constantes::PATH_FOLDER_TEMPLATES_SECURITY.'managerPostsView.php';

    //Affiche le pannel de management utilisateurs
    public function getUsersDashboardManager($errorMessage = NULL)
    {
        $userManager = new UserManager();
        $user = $userManager->getUserBySessionId();
        $arrayManager = new GetArray();
        $errorMessage = '';

        if ($user->getRole() == Constantes::ROLE_ADMIN && $user->getState() == Constantes::USER_STATUS_VALIDATED) {
            $crud = filter_input(INPUT_GET, 'CRUD');
            if (isset($crud)) {
                $errorMessage = $this->crudUserManager($crud);
            }

            $dtz = new DateTimeZone("Europe/Madrid");
            $now = new DateTime(date("Y-m-d H:i:s"), $dtz);

            $usersList = [];
            $allValues = $arrayManager->userManagerList();
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
                $view->render($this->managerUsersView, ['usersList' => $usersList, 'allValues' => $allValues, 'errorMessage' => $errorMessage, 'value' => $value, 'now' => $now, 'filArianne' => $filArianne]);
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

    //Modification des données utilisateurs
    public function UpdateDataByUser()
    {
        $dashboardUser = new DashboardUserController();
        if (!empty($_SESSION['id'] == filter_input(INPUT_POST, 'id'))) :
            $user = new User($_REQUEST);
            $userManager = new UserManager();
            $userBdd = $userManager->getUserBySessionId();
            $comparePassword = password_verify(filter_input(INPUT_POST, 'password'), $userBdd->getPassword());

            if ($comparePassword == true) :
                $userManager->updateUserByUser($user);
                $dashboardUser->getDashboardUser();
            else:
                $message = 'Votre mot de passe ne correspond pas';
                throw new ExceptionOutput($message);
            endif;
        else:
            $message = 'Votre identification de session ne correspond pas !';
            throw new ExceptionOutput($message);
        endif;
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
            $view->render($this->managerCommentsView, ['user' => $user, 'commentaires' => $commentaires, 'errorMessage' => $errorMessage]);
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
        $arrayManager = new GetArray();
        $errorMessage = '';

        if ($user->getRole() == Constantes::ROLE_ADMIN && $user->getState() == Constantes::USER_STATUS_VALIDATED) {
            $crud = filter_input(INPUT_GET, 'CRUD');
            if (isset($crud)) {
                $errorMessage = $this->crudPortfolioManager($crud);
            }

            $portfolio = $portfolioManager->getPortfolio();
            $categoriesColor = $arrayManager->categoriesFolioManagerList();

            $view = new View('Portfolio');
            $view->render($this->managerPortfolioView , ['user' => $user, 'portfolio' => $portfolio, 'categoriesColor' => $categoriesColor, 'errorMessage' => $errorMessage]);
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

                            $uploaddir = 'public/img/portfolio/';
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

                            $uploaddir = 'public/img/portfolio/';
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
                $jpegToDelete = "public/img/portfolio/" . $id . '.jpg';
                $webpToDelete = "public/img/portfolio/" . $id . '.webp';
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
        $arrayManager = new GetArray();
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
            $allValues = $arrayManager->postManagerList();
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
            $view->render($this->managerPostsView, ['errorMessage' => $errorMessage, 'allValues' => $allValues, 'categories' => $categories, 'pageCourante' => $pageCourante, 'nbPages' => $nbPages, 'value' => $value, 'filArianne' => $filArianne, 'postsList' => $postsList]);
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
}