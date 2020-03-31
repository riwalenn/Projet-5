<?php
if ((isset($_SESSION['id']))) : ?>
    <section class="page-profil" id="profil">
        <div class="container">
            <div class="row d-flex justify-content-around">
                <div class="col-md-4 col-sm-6 card" id="profil_Dash">
                    <img src="../ressources/img/dashboard/profil.jpg" class="img_dashboard"/>
                    <div class="articles-caption">
                        <h4>Profil</h4>
                        <footer class="blockquote-footer"><b>Date d'inscription :</b> <?= $user->getDate_inscription() ?></footer>
                        <footer class="blockquote-footer"><b>Dernière connexion :</b> <?= $user->getDate_modification() ?></footer>
                        <h5>Bonjour <b><?= $user->getPseudo() ?></b></h5>
                        <i class="fas fa-ninja"></i>
                        <p class="text-muted"><b>Votre email :</b> <?= $user->getEmail() ?></p>
                        <p class="text-muted"><a href="index.php?action=logoutUser"><i class="fas fa-sign-out-alt"></i> Deconnexion</a></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 card" id="articles_Dash">
                    <img src="../ressources/img/dashboard/articles.jpg" class="img_dashboard"/>
                    <div class="articles-caption">
                        <h4>3 derniers articles parus</h4>
                        <?php foreach ($lastPosts as $post) : ?>
                            <h5><b><a class="articles-link" data-toggle="modal" href="#articlesModal<?= $post->getId() ?>"><?= $post->getTitle() ?></a></b></h5>
                            <p class="text-muted"><?= $post->getKicker() ?></p>
                        <?php endforeach; ?>
                        <a href="index.php?action=articlesListe&page=1">Voir les autres articles.</a>
                    </div>
                </div>
            </div>
    </section>
    <!-- Modal -->
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
                                    <h2 class="text-uppercase"><?= $post->getTitle() ?> <i class="far fa-star"></i><i class="fas fa-star" style="color: #fed136"></i></h2>
                                    <p class="item-intro text-muted"><?= $post->getKicker() ?></p>
                                    <cite title="Auteur" class="item-intro text-muted">Créé par <?= $post->getPseudo() ?> -
                                        le <?= $post->getCreated_at() ?> / Modifié le <?= $post->getModified_at() ?></cite>
                                    <?= View::generatePictureTag($post) ?>
                                    <p><?= $post->getContent() ?></p>
                                    <button class="btn btn-primary" data-dismiss="modal" type="button">
                                        <i class="fas fa-times"></i>
                                        Close Article
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 mx-auto">
                                <div class="modal-body">
                                    <h4>Commentaires</h4>
                                    <hr>
                                    <?php
                                    if (empty($post->getComments())) :
                                        ?>
                                        <h6 class="alert alert-info">Pas de commentaires, soyez le premier à en écrire
                                            !</h6>
                                    <?php
                                    endif;
                                    foreach ($post->getComments() as $comment) {
                                        ?>
                                        <h5 class="text-uppercase"><?= $comment->getTitle() ?></h5>
                                        <cite title="Auteur" class="item-intro text-muted">Créé
                                            par <?= $comment->getPseudo() ?> -
                                            le <?= $comment->getCreated_at() ?></cite>
                                        <p><?= $comment->getContent() ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php endif; ?>
