<?php

class ManagersController
{
    private $managerUsersView           = Constantes::PATH_FOLDER_TEMPLATES_SECURITY.'managerUsersView.php';
    private $managerCommentsView        = Constantes::PATH_FOLDER_TEMPLATES_SECURITY.'managerCommentsView.php';
    private $managerPortfolioView       = Constantes::PATH_FOLDER_TEMPLATES_SECURITY.'managerPortfolioView.php';
    private $managerPostsView           = Constantes::PATH_FOLDER_TEMPLATES_SECURITY.'managerPostsView.php';
    private $managerPatternView         = Constantes::PATH_FOLDER_TEMPLATES_SECURITY. 'managerPatternFacadeView.php';

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
                        $states = [Constantes::USER_PENDING_STATUS_MODO];
                        $usersList = $userManager->selectAllUsers($states);
                        $filArianne = 'Utilisateurs à valider';
                        break;

                    case 'uncheckedTokenUsers':
                        $usersList = $userManager->selectUsersTokenUnchecked();
                        $filArianne = 'Tokens non validés';
                        break;

                    case 'referents':
                        $usersList = $userManager->selectReferents();
                        $filArianne = 'Utilisateurs référents';
                        break;

                    case 'trash':
                        $states = [Constantes::USER_STATUS_DELETED];
                        $usersList = $userManager->selectAllUsers($states);
                        $filArianne = 'Comptes à supprimer';
                        break;

                    case 'all':
                    default:
                        $states = [Constantes::USER_PENDING_STATUS, Constantes::USER_PENDING_STATUS_MODO, Constantes::USER_STATUS_VALIDATED];
                        $usersList = $userManager->selectAllUsers($states);
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
                $user->setCgu(Constantes::CGU_VALIDATED);
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
                if ($user->getState() == Constantes::USER_STATUS_DELETED) {
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

    //Affiche le panel de test du pattern de façade
    public function getPatternFacadeTestManager()
    {
        $filArianne = 'Design Pattern de façade';
        $patternManager = new PatternManager();
        $datas = $patternManager->get2021DataFinances();
        foreach ($datas as $data) :
            $page = new Page($data->getLabel(), [$data->getValue(), $data->getValuePercent()]);
            $document[] = $page->render(new ViewTemplateFactory());
        endforeach;

        $view = new  View('Pattern de Façade');
        $view->render($this->managerPatternView, ['filArianne' => $filArianne, 'datas' => $datas, 'document' => $document]);
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
        $arrayFiles = [$_FILES];
        $errorMessage = '';
        switch ($crud) {
            //Create
            case 'C':
                foreach ($arrayFiles as $file) {
                    if (isset($file['foliojpg']) && $file['foliowebp']) {
                        if ($file['foliojpg']['error'] == 0 && $file['foliowebp']['error'] == 0) :
                            if ($file['foliojpg']['size'] <= 200000 && $file['foliowebp']['size'] <= 200000) :
                                $portfolioManager = new PortfolioManager();
                                $lastInsertId = $portfolioManager->createPortfolio($portfolio);

                                $uploaddir = 'public/img/portfolio/';
                                $infosfichierjpg = pathinfo($file['foliojpg']['name']);
                                $infosfichierwebp = pathinfo($file['foliowebp']['name']);
                                $extensionUpdloadjpg = $infosfichierjpg['extension'];
                                $extensionUpdloadwebp = $infosfichierwebp['extension'];
                                $extensionsAuthorized = array('jpg', 'webp');
                                $uploadfilejpg = $uploaddir . basename($lastInsertId) . '.' . $extensionUpdloadjpg;
                                $uploadfilewebp = $uploaddir . basename($lastInsertId) . '.' . $extensionUpdloadwebp;

                                if (in_array($extensionUpdloadjpg, $extensionsAuthorized)) :
                                    move_uploaded_file($file['foliojpg']['tmp_name'], $uploadfilejpg);
                                else :
                                    $errorMessage = "L'extension ne correspond pas.";
                                endif;

                                if (in_array($extensionUpdloadwebp, $extensionsAuthorized)) :
                                    move_uploaded_file($file['foliowebp']['tmp_name'], $uploadfilewebp);
                                else :
                                    $errorMessage = "Erreur : L'extension ne correspond pas.";
                                endif;

                            else :
                                $errorMessage = "Erreur : Le fichier est trop volumineux.";
                            endif;
                        endif;
                    }
                }

                $errorMessage = 'Le Portfolio a été créé avec succès.';
                break;

            //Update
            case 'U':
                foreach ($arrayFiles as $file) {
                    if (isset($file['foliojpg']) || $file['foliowebp']) {
                        if ($file['foliojpg']['error'] == 0 || $file['foliowebp']['error'] == 0) :
                            if ($file['foliojpg']['size'] <= 200000 || $file['foliowebp']['size'] <= 200000) :
                                $portfolioManager = new PortfolioManager();
                                $id = $portfolio->getId();

                                $uploaddir = 'public/img/portfolio/';
                                $infosfichierjpg = pathinfo($file['foliojpg']['name']);
                                $infosfichierwebp = pathinfo($file['foliowebp']['name']);
                                $extensionUpdloadjpg = $infosfichierjpg['extension'];
                                $extensionUpdloadwebp = $infosfichierwebp['extension'];
                                $extensionsAuthorized = array('jpg', 'webp');
                                $uploadfilejpg = $uploaddir . basename($id) . '.' . $extensionUpdloadjpg;
                                $uploadfilewebp = $uploaddir . basename($id) . '.' . $extensionUpdloadwebp;

                                if (in_array($extensionUpdloadjpg, $extensionsAuthorized)) :
                                    move_uploaded_file($file['foliojpg']['tmp_name'], $uploadfilejpg);
                                else :
                                    return $errorMessage = "Erreur : L'extension ne correspond pas.";
                                endif;

                                if (in_array($extensionUpdloadwebp, $extensionsAuthorized)) :
                                    move_uploaded_file($file['foliowebp']['tmp_name'], $uploadfilewebp);
                                else :
                                    $errorMessage = "Erreur : L'extension ne correspond pas.";
                                endif;
                            else :
                                $errorMessage = "Erreur : Le fichier est trop volumineux.";
                            endif;
                        endif;
                    }
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
                        $status = [Constantes::POST_PENDING_STATUS, Constantes::POST_STATUS_VALIDATED, Constantes::POST_STATUS_ARCHIVED];
                        $postsList = $postManager->getAllPosts($pageCourante, $status, $nbPosts);
                        $nbPages = $postManager->countPagesByAllStates($nbPosts);
                        $filArianne = 'Tous les articles';
                        break;

                    case 'uncheckedPosts':
                        $status = [Constantes::POST_PENDING_STATUS];
                        $postsList = $postManager->getAllPosts($pageCourante, $status, $nbPosts);
                        $nbPages = $postManager->countPagesByState($nbPosts, Constantes::POST_PENDING_STATUS);
                        $filArianne = 'Articles à valider';
                        break;

                    case 'checkedPosts':
                        $status = [Constantes::POST_STATUS_VALIDATED];
                        $postsList = $postManager->getAllPosts($pageCourante, $status, $nbPosts);
                        $nbPages = $postManager->countPagesByState($nbPosts, Constantes::POST_STATUS_VALIDATED);
                        $filArianne = 'Articles validés';
                        break;

                    case 'archived':
                        $status = [Constantes::POST_STATUS_ARCHIVED];
                        $postsList = $postManager->getAllPosts($pageCourante, $status, $nbPosts);
                        $nbPages = $postManager->countPagesByState($nbPosts, Constantes::POST_STATUS_ARCHIVED);
                        $filArianne = 'Articles archivés';
                        break;

                    case 'trash':
                        $status = [Constantes::POST_STATUS_DELETED];
                        $postsList = $postManager->getAllPosts($pageCourante, $status, $nbPosts);
                        $nbPages = $postManager->countPagesByState($nbPosts, Constantes::POST_STATUS_DELETED);
                        $filArianne = 'Articles à supprimer';
                        break;

                    default:
                        //$postsList = $postManager->getPostsByState($pageCourante, Constantes::POST_STATUS_VALIDATED, $nbPosts);
                        $status = [Constantes::POST_STATUS_VALIDATED];
                        $postsList = $postManager->getAllPosts($pageCourante, $status, $nbPosts);
                        $nbPages = $postManager->countPagesByState($nbPosts, Constantes::POST_STATUS_VALIDATED);
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