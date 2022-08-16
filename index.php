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
            case 'articles-liste' :
                $postController->afficherListeArticles();
                break;

            case 'add-comment' :
                $postController->ajoutCommentaire();
                break;

            case 'recherche' :
                $postController->afficherResultatRecherche();
                break;

            // Affiche le formulaire
            case 'connexion' :
                $securityController->afficherLoginForm();
                break;

            case 'login-user' :
                $securityController->login();
                break;

            case 'dashboard' :
                $dashboardController->getDashboardUser();
                break;

            case 'delete':
            case 'backend-dashboard':
                $controllerBack->getBackendDashboard();
                break;

            case 'users-manager':
                $managers->getUsersDashboardManager();
                break;

            case 'posts-manager':
                $managers->getPostsDashboardManager();
                break;

            case 'comments-manager':
                $managers->getCommentsDashboardManager();
                break;

            case 'portfolio-manager':
                $managers->getPortfolioDashboardManager();
                break;

            // Ajoute un article dans les favoris de l'utilisateur
            case 'add-favorite' :
                $favorisController->addFavoritePost();
                break;

            // Supprime un article des favoris de l'utilisateur
            case 'delete-favorite' :
                $favorisController->deleteFavoritePost();
                break;

            // Modifie les données de l'utilisateur (pseudo, email)
            case 'modif-data-user':
                $managers->UpdateDataByUser();
                break;

            case 'logout-user' :
                $securityController->logout();
                break;

            // Affiche le formulaire
            case 'nouvel-inscrit' :
                $securityController->afficherNewLoginForm();
                break;

            case 'inscription' :
                $securityController->inscription();
                break;

            case 'confirmation-inscription-by-email' :
                $securityController->confirmationByToken();
                break;

            // Affiche le formulaire
            case 'forgot-password' :
                $securityController->afficherMailForm();
                break;

            case 'forgot-password-send-mail' :
                $securityController->envoyerEmailForPassword();
                break;

            // Affiche le formulaire
            case 'i-forgot-my-password' :
                $securityController->afficherPasswordForm();
                break;

            case 'modifier-password' :
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