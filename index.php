<?php
require_once 'config/config.php';
try {
    $controller                 = new ControllerFront();
    $controllerBack             = new ControllerBack();
    $securityController         = new SecurityController();
    $dashboardController        = new DashboardUserController();
    $favorisController          = new FavorisController();
    $postController             = new PostController();
    $installationController     = new InstallationController();
    $managers                   = new ManagersController();

    $action = filter_input(INPUT_GET, 'action');
    if (isset($action)) {
        switch ($action) {
            case 'articlesListe' :
                $postController->afficherListeArticles();
                break;

            case 'addComment' :
                $postController->ajoutCommentaire();
                break;

            case 'recherche' :
                $postController->afficherResultatRecherche();
                break;

            // Affiche le formulaire
            case 'connexion' :
                $securityController->afficherLoginForm();
                break;

            case 'loginUser' :
                $securityController->login();
                break;

            case 'dashboard' :
                $dashboardController->getDashboardUser();
                break;

            case 'backendDashboard':
                $controllerBack->getBackendDashboard();
                break;

            case 'delete':
                $controllerBack->getBackendDashboard();
                break;

            case 'usersManager':
                $managers->getUsersDashboardManager();
                break;

            case 'postsManager':
                $managers->getPostsDashboardManager();
                break;

            case 'commentsManager':
                $managers->getCommentsDashboardManager();
                break;

            case 'portfolioManager':
                $managers->getPortfolioDashboardManager();
                break;

            // Ajoute un article dans les favoris de l'utilisateur
            case 'addFavorite' :
                $favorisController->addFavoritePost();
                break;

            // Supprime un article des favoris de l'utilisateur
            case 'deleteFavorite' :
                $favorisController->deleteFavoritePost();
                break;

            // Modifie les données de l'utilisateur (pseudo, email)
            case 'modifDataUser':
                $managers->UpdateDataByUser();
                break;

            case 'logoutUser' :
                $securityController->logout();
                break;

            // Affiche le formulaire
            case 'nouvelInscrit' :
                $securityController->afficherNewLoginForm();
                break;

            case 'inscription' :
                $securityController->inscription();
                break;

            case 'confirmationInscriptionByEmail' :
                $securityController->confirmationByToken();
                break;

            // Affiche le formulaire
            case 'forgotPassword' :
                $securityController->afficherMailForm();
                break;

            case 'forgotPasswordSendMail' :
                $securityController->envoyerEmailForPassword();
                break;

            // Affiche le formulaire
            case 'confirmationEmailForPassword' :
                $securityController->afficherPasswordForm();
                break;

            case 'modifierPassword' :
                $securityController->changerPassword();
                break;

            case 'installation' :
                $installationController->installBlog();
                break;

            default :
                break;
        }
    } else {
        $controller->afficherIndex();
    }
} catch (PDOException $e) {
    $controller->erreurPDO($e);
} catch (ExceptionOutput $e) {
    $controller->erreurOutput($e);
} catch (InvalidArgumentException $e) {
    $controller->erreur();
} catch (Exception $e) {
    echo 'Exception : ' . $e->getMessage() . '(code :' . $e->getCode() . '), ligne ' . $e->getLine() . ' dans le fichier ' . $e->getFile();
}