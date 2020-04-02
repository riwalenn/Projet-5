<!-- articles Grid -->
<section class="bg-light page-section" id="articles">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading text-uppercase">Articles</h2>
                <h3 class="section-subheading text-muted">Ci-dessous quelques articles qui pourraient vous
                    intéresser.</h3>
            </div>
        </div>
    </div>
    <div class="container">
        <form>
            <div class="row justify-content-center">
                <div class="input-group input-group-sm mb-3">
                    <input type="hidden" name="action" value="recherche">
                    <input type="text" class="form-control" placeholder="Rechercher..." aria-label="Recherche" name="submit">
                    <div class="input-group-append">
                        <button class="input-group-text" id="basic-addon" type="submit"><i class="fa fa-search fa-inverse"></i></button>
                    </div>
                </div>
                <?php
                if (empty($listPosts)) :
                    ?>
                    <h6 class="alert alert-primary">Nous sommes désolés, la liste est vide ! Merci de revenir plus tard.</h6>
                <?php
                endif;
                ?>
            </div>
        </form>
    </div>
    <div class="container">
        <div class="row">
            <?php
            foreach ($listPosts as $post) {
                ?>
                <div class="col-md-4 col-sm-6 articles-item">
                    <a class="articles-link" data-toggle="modal" href="#articlesModal<?= $post->getId() ?>">
                        <div class="articles-hover">
                            <div class="articles-hover-content">
                                <i class="fas fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <?= View::generatePictureTag($post) ?>
                    </a>
                    <div class="articles-caption">
                        <footer class="blockquote-footer">catégorie : <?= $post->getCategory()->getCategory() ?></footer>
                        <footer class="blockquote-footer">Créé le <?= $post->getCreated_at() ?></footer>
                        <?php if ((isset($_SESSION['id']))) : ?>
                            <?php  if ($post->getStatut_favorite() == 1) : ?>
                                <footer class="blockquote-footer">
                                    Cet article fait parti de vos favoris <i class="fas fa-star" style="color: #fed136"></i><br>
                                </footer>
                            <?php elseif ($post->getStatut_favorite() != 1) : ?>
                                <form action="index.php?action=addFavorite" method="post">
                                    <input type="hidden" name="id_post" value="<?= $post->getid() ?>">
                                    <footer class="blockquote-footer">
                                        Ajouter l'article à vos favoris :  <button class="btn btn-light" data-dismiss="modal" type="submit"><i class="fa fa-plus-square" style="color:#11dbba; "></i></button><br>
                                    </footer>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>

                        <h4><?= $post->getTitle() ?></h4>
                        <p class="text-muted"><?= $post->getKicker() ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
        <nav aria-label="...">
            <ul class="pagination justify-content-end pagination-sm">
                <?php
                for ($i = 0; $i < $nbPages; $i++) {
                    $j = $i + 1;
                    if ($j == $pageCourante) :
                        echo '<li class="page-item active">';
                    else :
                        echo '<li class="page-item">';
                    endif;
                    if (!empty($submitRecherche)) :
                        echo '<a class="page-link" href="index.php?action=recherche&submit='. $submitRecherche .'&page=' . $j . '">' . $j . '</a>';
                    else :
                        echo '<a class="page-link" href="index.php?action=articlesListe&page=' . $j . '">' . $j . '</a>';
                    endif;


                    echo '</li>';
                }
                ?>
            </ul>
        </nav>
    </div>
</section>

<!-- Modal -->
<?php
foreach ($listPosts as $post) {
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
                                    le <?= $post->getCreated_at() ?> / Modifié le <?= $post->getModified_at() ?><br></cite>
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
                                <h4>Commentaires</h4>
                                <hr>
                                <?php
                                if (empty($post->getComments())) :
                                    ?>
                                    <h6 class="alert alert-info">Pas de commentaires, soyez le premier à en écrire !</h6>
                                <?php
                                elseif (!empty($post->getComments())) :
                                    foreach ($post->getComments() as $comment) {
                                        ?>
                                        <h5 class="text-uppercase"><?= $comment->getTitle() ?></h5>
                                        <cite title="Auteur" class="item-intro text-muted">Créé
                                            par <?= $comment->getPseudo() ?> -
                                            le <?= $comment->getCreated_at() ?></cite>
                                        <p><?= $comment->getContent() ?></p>
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
