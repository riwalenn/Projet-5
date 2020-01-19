<!-- Portfolio Grid -->
<section class="bg-light page-section" id="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading text-uppercase">Articles</h2>
                <h3 class="section-subheading text-muted">Ci-dessous quelques articles qui pourraient vous
                    intéresser.</h3>
                <button class="btn filtres btn-sm " type="button" data-toggle="collapse" data-target="#collapseExample"
                        aria-expanded="false" aria-controls="collapseExample">
                    <i class="fa fa-search"></i> Filtres
                </button>
                <div class="collapse" id="collapseExample">
                    <div class="card card-body shadow-sm p-3 mb-5 bg-white rounded">
                        <form>
                            <div class="formulaire-recherche">
                                <div class="row filtres-form">
                                    <div class="col">
                                        <label>Rechercher un auteur :</label>
                                    </div>
                                    <div class="col">
                                        <label>Rechercher une catégorie :</label>
                                    </div>
                                </div>
                                <div class="row filtres-form">
                                    <div class="col">
                                        <select class="custom-select custom-select-sm">
                                            <option selected>---indifférent---</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select class="custom-select custom-select-sm">
                                            <option selected>---indifférent---</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row filtres-form">
                                    <div class="col">
                                        <label>Rechercher par date de création :</label>
                                    </div>
                                </div>
                                <div class="row filtres-form">
                                    <div class="col">
                                        <input type="date" class="form-control">
                                    </div>
                                    <div class="col">
                                        <input type="date" class="form-control">
                                    </div>
                                </div>
                                <div class="row filtres-form">
                                    <div class="col">
                                        <button class="btn filtres-submit btn-sm " type="button">
                                            Filtrer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (empty($listPosts)) {
            ?>
            <h6 class="alert alert-primary">Nous sommes désolés, la liste est vide ! Merci de revenir plus tard.</h6>
            <?php
        }
        ?>
        <div class="row">
            <?php
            foreach ($listPosts as $post) {
                ?>
                <div class="col-md-4 col-sm-6 portfolio-item">
                    <a class="portfolio-link" data-toggle="modal" href="#portfolioModal<?= $post->getId() ?>">
                        <div class="portfolio-hover">
                            <div class="portfolio-hover-content">
                                <i class="fas fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <img class="img-fluid" src="<?= $post->getImg() ?>" alt="">
                    </a>
                    <div class="portfolio-caption">
                        <footer class="blockquote-footer">catégorie : <?= $post->getCategory() ?></footer>
                        <footer class="blockquote-footer">Créé le <?= $post->getCreated_at() ?></footer>
                        <h4><?= $post->getTitle() ?></h4>
                        <p class="text-muted"><?= $post->getKicker() ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
        <nav aria-label="...">
            <ul class="pagination justify-content-end pagination-sm">
                <li class="page-item active">
                   <a class="page-link" href="index.php?action=articlesListe&page=1">1</a>
                </li>
                <?php
                foreach ($nbPages as $nbPage) {
                    for ($counter = 1; $counter <= $nbPage; $counter++) {
                        if ($nbPage >= 1) :
                            ?>
                            <li class="page-item">
                                <a class="page-link" href="index.php?action=articlesListe&page=<?= $counter + 1 ?>"><?= $counter + 1 ?></a>
                            </li>
                        <?php
                        endif;
                    }
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
    <div class="portfolio-modal modal fade" id="portfolioModal<?= $post->getId() ?>" tabindex="-1" role="dialog"
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
                                    le <?= $post->getCreated_at() ?></cite>
                                <img class="img-fluid d-block mx-auto" src="<?= $post->getImg() ?>" alt="">
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
                                if (empty($post->getComments())) {
                                    ?>
                                    <h6 class="alert alert-info">Pas de commentaires, soyez le premier à en écrire
                                        !</h6>
                                    <?php
                                }
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
