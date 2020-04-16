<?php
if ((isset($_SESSION['id']))) : ?>
    <section class="page-profil" id="profil">
        <div class="container">
            <div class="row d-flex justify-content-around">
                <div class="card-deck">
                    <div class="card" id="profil_Dash">
                        <img src="../ressources/img/dashboard/profil.jpg" class="img_dashboard"/>
                        <div class="card-header">
                            <blockquote class="blockquote mb-0">
                                <footer class="blockquote-footer">Dernière connexion : <?= $user->getDate_modification() ?></footer>
                            </blockquote>
                        </div>
                        <div class="card-body articles-caption">
                            <h4>Profil</h4>
                            <h5>Bonjour <b><?= $user->getPseudo() ?></b></h5>
                            <i class="fas fa-ninja"></i>
                            <p class="text-muted"><b>Votre email :</b> <?= $user->getEmail() ?></p>
                            <p class="text-muted"><b>Date d'inscription :</b> <?= $user->getDate_inscription() ?></p>
                            <p class="text-muted"><a href="index.php?action=logoutUser"><i class="fas fa-sign-out-alt"></i> Deconnexion</a></p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted"><a class="articles-link" data-toggle="modal" href="#formModal" ><i class="fas fa-pen"></i> Modifier mes informations</a></small>
                        </div>
                    </div>
                </div>
                <div class="card-deck">
                    <div class="card" id="profil_Dash">
                        <img src="../ressources/img/dashboard/favorite.jpg" class="img_dashboard"/>
                        <div class="card-header">
                            <blockquote class="blockquote mb-0">
                                <footer class="blockquote-footer">10 Favoris (triés par ordre de date décroissant)</footer>
                            </blockquote>
                        </div>
                        <div class="card-body articles-caption">
                            <h4>Ma bibliothèque</h4>
                            <small><?= $errorMessage ?></small>
                            <table width="100%">
                                <thead><tr><th></th><th></th> </tr></thead>
                                <tbody>
                                <?php foreach ($favoritesPosts as $post) : ?>
                                    <form action="index.php?action=deleteFavorite" method="post" onsubmit="return ConfirmMessage()">
                                        <input type="hidden" name="id_post" value="<?= $post->getId() ?>">
                                        <tr>
                                            <td><p class="favorites-posts-links"><a class="articles-link" data-toggle="modal" href="#articlesModal<?= $post->getId() ?>"><i class="fas fa-star" style="color: #fed136"></i> <?= $post->getTitle() ?></a></p></td>
                                            <td><button class="btn btn-link" aria-label="supprimer" type="submit" value="deletion"><i class="far fa-trash-alt" style="color: red;"></i></button></td>
                                        </tr>
                                    </form>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted"><a class="articles-link" data-toggle="modal" href="index.php?action=articlesListe&page=1" ><i class="fas fa-eye"></i> Voir la liste des articles disponibles</a></small>
                        </div>
                    </div>
                </div>
                <div class="card-deck">
                    <div class="card" id="profil_Dash">
                        <img src="../ressources/img/dashboard/articles.jpg" class="img_dashboard"/>
                        <div class="card-header">
                            <blockquote class="blockquote mb-0">
                                <footer class="blockquote-footer">Articles (triés par ordre de date décroissant)</footer>
                            </blockquote>
                        </div>
                        <div class="card-body articles-caption">
                            <h4>3 dernières parutions</h4>
                            <?php foreach ($lastPosts as $post) : ?>
                                <h5><b><a class="articles-link" data-toggle="modal" href="#articlesModal<?= $post->getId() ?>"><?= $post->getTitle() ?></a></b></h5>
                                <footer class="blockquote-footer">Modifié le : <?= $post->getModified_at() ?></footer>
                                <?php  if ($post->getStatut_favorite() == 1) : ?>
                                    <footer class="blockquote-footer">
                                        Cet article fait parti de vos favoris <i class="fas fa-star" style="color: #fed136"></i><br>
                                    </footer>
                                <?php elseif ($post->getStatut_favorite() != 1) : ?>
                                    <form action="index.php?action=addFavorite" method="post">
                                        <input type="hidden" name="id_post" value="<?= $post->getid() ?>">
                                        <footer class="blockquote-footer">
                                            Ajouter l'article à vos favoris :  <button class="btn btn-light" data-dismiss="modal" type="submit"><i class="fa fa-plus-square" style="color:#11dbba; "></i></button><br>
                                            <?= $errorMessage ?>
                                        </footer>
                                    </form>
                                <?php endif; ?>
                                <p class="text-muted"><?= substr($post->getKicker(), 0, 50) . "..." ?></p>
                            <?php endforeach; ?>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted"><a class="articles-link" data-toggle="modal" href="index.php?action=articlesListe&page=1" ><i class="fas fa-eye"></i> Voir la liste des articles disponibles</a></small>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!-- Modal modifs user -->
    <div class="articles-modal modal fade" id="formModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl"></div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <div class="modal-body">
                                <h5>Modification de mes données</h5>
                                <form id="formDataUser" action="index.php?action=modifDataUser" method="post" onsubmit="return verifForm(this)">
                                    <input type="hidden" value="<?= $_SESSION['id'] ?>" name="id" id="id">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-user-ninja"></i></span>
                                        </div>
                                        <input type="text" id="pseudo" class="form-control form-control-sm" placeholder="entrez votre pseudonyme ici" name="pseudo" aria-label="Pseudonyme" aria-describedby="basic-addon1" onkeyup="verifPseudo(this)" value="<?= $user->getPseudo() ?>" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-pen" data-toggle="tooltip" data-placement="right"></i></span>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-at"></i></span>
                                        </div>
                                        <input id="email" class="form-control form-control-sm" placeholder="entrez votre email ici" aria-label="email" type="email" name="email" value="<?= $user->getEmail() ?>" onkeyup="verifEmail(this)" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-pen" data-toggle="tooltip" data-placement="right"></i></span>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                                        </div>
                                        <input id="password" class="form-control form-control-sm classeMdp" placeholder="merci d'entrer votre mot de passe pour valider vos informations" aria-label="password" type="password" name="password" maxlength="64" minlength="10" onkeyup="verifPassword(this)" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-pen" data-toggle="tooltip" data-placement="right" title="Cliquez ici pour avoir plus d'infos !"></i></span>
                                        </div>
                                    </div>
                                    <p>Si vous avez oublié votre mot de passe ou que vous souhaitez le changer<br> merci d'utiliser le <a href="index.php?action=forgotPassword">formulaire dédié</a>.<br> Le champ ci-dessus n'étant utilisé que pour valider vos informations.</p>
                                    <button class="btn btn-primary my-2 my-sm-0" aria-label="connexion" type="submit" value="Modification">Modifier mes données</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal 3 derniers posts -->
    <?php
    foreach ($lastPosts as $post) {
        ?>
        <div class="articles-modal modal fade" id="articlesModal<?= $post->getId() ?>" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-dismiss="modal">
                        <div class="lr">
                            <div class="rl"></div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 mx-auto">
                                <div class="modal-body">
                                    <!-- Project Details Go Here -->
                                    <h2 class="text-uppercase"><?= $post->getTitle() ?></h2>
                                    <p class="item-intro text-muted"><?= $post->getKicker() ?></p>
                                    <cite title="Auteur" class="item-intro text-muted">Créé par <?= $post->getPseudo() ?> -
                                        le <?= $post->getCreated_at() ?> / Modifié le <?= $post->getModified_at() ?></cite>
                                    <?= View::generatePictureTag($post) ?>
                                    <p><?= $post->getContent() ?></p>
                                    <button class="btn btn-primary" data-dismiss="modal" type="button">
                                        <i class="fas fa-times"></i>
                                        Fermer l'article
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 mx-auto">
                                <div class="modal-body">
                                    <?php
                                    if (empty($post->getComments())) :
                                        ?>
                                        <h6 class="alert alert-info">Pas de commentaires, soyez le premier à en écrire !</h6>
                                        <?php
                                        if (!empty($_SESSION['id']) && $_SESSION['role']) :
                                            ?>
                                            <hr>
                                            <hr>
                                            <h5>Ecrire un commentaire</h5>
                                            <div class="comment-form">
                                                <form action="index.php?action=addComment" method="post">
                                                    <input type="hidden" name="id_post" value="<?= $post->getId() ?>">
                                                    <div><label>Titre du commentaire :</label></div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1"><i class="far fa-file-alt"></i></span>
                                                        </div>
                                                        <input class="form-control form-control-sm" placeholder="entrez titre de commentaire ici" aria-label="title" type="text" name="title" required>
                                                    </div>
                                                    <div><label>Commentaire :</label></div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-comments"></i></span>
                                                        </div>
                                                        <input class="form-control form-control-sm" placeholder="entrez votre commentaire ici" aria-label="commentaire" type="text" name="content" required>
                                                    </div>
                                                    <button class="btn btn-primary my-2 my-sm-0" aria-label="envoyer" type="submit" value="commentaire">envoyer mon commentaire</button>
                                                </form>
                                            </div>
                                        <?php
                                        endif;
                                    elseif (!empty($post->getComments())) :
                                        if (!empty($_SESSION['id']) && $_SESSION['role']) :
                                            ?>
                                            <hr>
                                            <hr>
                                            <h5>Ecrire un commentaire</h5>
                                            <div class="comment-form">
                                                <form action="index.php?action=addComment" method="post">
                                                    <input type="hidden" name="id_post" value="<?= $post->getId() ?>">
                                                    <div><label>Titre du commentaire :</label></div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1"><i class="far fa-file-alt"></i></span>
                                                        </div>
                                                        <input class="form-control form-control-sm" placeholder="entrez titre de commentaire ici" aria-label="title" type="text" name="title" required>
                                                    </div>
                                                    <div><label>Commentaire :</label></div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-comments"></i></span>
                                                        </div>
                                                        <input class="form-control form-control-sm" placeholder="entrez votre commentaire ici" aria-label="commentaire" type="text" name="content" required>
                                                    </div>
                                                    <button class="btn btn-primary my-2 my-sm-0" aria-label="envoyer" type="submit" value="commentaire">envoyer mon commentaire</button>
                                                </form>
                                            </div>
                                        <?php
                                        endif;
                                        ?>
                                        <hr>
                                        <hr>
                                        <h4>Commentaires</h4>
                                        <?php
                                        foreach ($post->getComments() as $comment) {
                                            ?>
                                            <p><?= $comment->getCreated_at() ?> - <b><?= $comment->getTitle() ?> : </b><?= $comment->getContent() ?> <cite title="Auteur" class="item-intro text-muted">// par <?= $comment->getPseudo() ?></cite></p>
                                        <?php }
                                    endif;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <!-- Modal posts favoris -->
    <?php
    foreach ($favoritesPosts as $post)  {
        ?>
        <div class="articles-modal modal fade" id="articlesModal<?= $post->getId() ?>" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-dismiss="modal">
                        <div class="lr">
                            <div class="rl"></div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 mx-auto">
                                <div class="modal-body">
                                    <!-- Project Details Go Here -->
                                    <h2 class="text-uppercase"><?= $post->getTitle() ?></h2>
                                    <p class="item-intro text-muted"><?= $post->getKicker() ?></p>
                                    <cite title="Auteur" class="item-intro text-muted">Créé par <?= $post->getPseudo() ?> -
                                        le <?= $post->getCreated_at() ?> / Modifié le <?= $post->getModified_at() ?></cite>
                                    <?= View::generatePictureTag($post) ?>
                                    <p><?= $post->getContent() ?></p>
                                    <button class="btn btn-primary" data-dismiss="modal" type="button">
                                        <i class="fas fa-times"></i>
                                        Fermer l'article
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 mx-auto">
                                <div class="modal-body">
                                    <?php
                                    if (empty($post->getComments())) :
                                        ?>
                                        <h6 class="alert alert-info">Pas de commentaires, soyez le premier à en écrire !</h6>
                                        <?php
                                        if (!empty($_SESSION['id']) && $_SESSION['role']) :
                                            ?>
                                            <hr>
                                            <hr>
                                            <h5>Ecrire un commentaire</h5>
                                            <div class="comment-form">
                                                <form action="index.php?action=addComment" method="post">
                                                    <input type="hidden" name="id_post" value="<?= $post->getId() ?>">
                                                    <div><label>Titre du commentaire :</label></div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1"><i class="far fa-file-alt"></i></span>
                                                        </div>
                                                        <input class="form-control form-control-sm" placeholder="entrez titre de commentaire ici" aria-label="title" type="text" name="title" required>
                                                    </div>
                                                    <div><label>Commentaire :</label></div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-comments"></i></span>
                                                        </div>
                                                        <input class="form-control form-control-sm" placeholder="entrez votre commentaire ici" aria-label="commentaire" type="text" name="content" required>
                                                    </div>
                                                    <button class="btn btn-primary my-2 my-sm-0" aria-label="envoyer" type="submit" value="commentaire">envoyer mon commentaire</button>
                                                </form>
                                            </div>
                                        <?php
                                        endif;
                                    elseif (!empty($post->getComments())) :
                                        if (!empty($_SESSION['id']) && $_SESSION['role']) :
                                            ?>
                                            <hr>
                                            <hr>
                                            <h5>Ecrire un commentaire</h5>
                                            <div class="comment-form">
                                                <form action="index.php?action=addComment" method="post">
                                                    <input type="hidden" name="id_post" value="<?= $post->getId() ?>">
                                                    <div><label>Titre du commentaire :</label></div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1"><i class="far fa-file-alt"></i></span>
                                                        </div>
                                                        <input class="form-control form-control-sm" placeholder="entrez titre de commentaire ici" aria-label="title" type="text" name="title" required>
                                                    </div>
                                                    <div><label>Commentaire :</label></div>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-comments"></i></span>
                                                        </div>
                                                        <input class="form-control form-control-sm" placeholder="entrez votre commentaire ici" aria-label="commentaire" type="text" name="content" required>
                                                    </div>
                                                    <button class="btn btn-primary my-2 my-sm-0" aria-label="envoyer" type="submit" value="commentaire">envoyer mon commentaire</button>
                                                </form>
                                            </div>
                                        <?php
                                        endif;
                                        ?>
                                        <hr>
                                        <hr>
                                        <h4>Commentaires</h4>
                                        <?php
                                        foreach ($post->getComments() as $comment) {
                                            ?>
                                            <p><?= $comment->getCreated_at() ?> - <b><?= $comment->getTitle() ?> : </b><?= $comment->getContent() ?> <cite title="Auteur" class="item-intro text-muted">// par <?= $comment->getPseudo() ?></cite></p>
                                        <?php }
                                    endif;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php endif; ?>