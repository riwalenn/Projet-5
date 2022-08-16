<?php


class FavorisController extends DashboardUserController
{
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
}