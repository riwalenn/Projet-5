<!-- Portfolio Grid -->
<section class="bg-light page-section" id="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading text-uppercase">Articles</h2>
                <h3 class="section-subheading text-muted">Ci-dessous quelques articles qui pourraient vous
                    intéresser.</h3>
                <button class="btn filtres btn-sm " type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fa fa-search"></i> Filtres
                </button>
                <div class="collapse" id="collapseExample">
                    <div class="card card-body shadow-sm p-3 mb-5 bg-white rounded">
                        Filtres à faire : catégories / périodes / auteurs
                        <form>
                            <div class="formulaire-recherche">
                                <div class="row filtres-form">
                                    <div class="col">
                                        <label>Rechercher un auteur :</label>
                                        <select class="custom-select custom-select-sm">
                                            <option selected>---indifférent---</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label>Rechercher une catégorie :</label>
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
            foreach ($listPosts as $posts) {
                ?>
                <div class="col-md-4 col-sm-6 portfolio-item">
                    <a class="portfolio-link" data-toggle="modal" href="#portfolioModal<?= $posts->getId() ?>">
                        <div class="portfolio-hover">
                            <div class="portfolio-hover-content">
                                <i class="fas fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <img class="img-fluid" src="<?= $posts->getImg() ?>" alt="">
                    </a>
                    <div class="portfolio-caption">
                        <footer class="blockquote-footer">catégorie : <?= $posts->getCategory() ?></footer>
                        <footer class="blockquote-footer">Créé le <?= $posts->getCreated_at() ?></footer>
                        <h4><?= $posts->getTitle() ?></h4>
                        <p class="text-muted"><?= $posts->getKicker() ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>


<!-- Modal -->
<?php foreach ($listPosts as $posts) {
    ?>
    <div class="portfolio-modal modal fade" id="portfolioModal<?= $posts->getId() ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                <h2 class="text-uppercase"><?= $posts->getTitle() ?></h2>
                                <p class="item-intro text-muted"><?= $posts->getKicker() ?></p>
                                <cite title="Auteur" class="item-intro text-muted">Créé par <?= $posts->getPseudo() ?> -
                                    le <?= $posts->getCreated_at() ?></cite>
                                <img class="img-fluid d-block mx-auto" src="<?= $posts->getImg() ?>" alt="">
                                <p><?= $posts->getContent() ?></p>
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
                                if (empty($listComments)) {
                                    ?>
                                    <h6 class="alert alert-primary">Nous sommes désolés, la liste est vide ! Merci de revenir plus tard.</h6>
                                    <?php
                                }
                                foreach ($listComments as $comments) {
                                    ?>
                                    <h2 class="text-uppercase"><?= $comments->getTitle() ?></h2>
                                    <cite title="Auteur" class="item-intro text-muted">Créé par <?= $comments->getPseudo() ?> -
                                        le <?= $comments->getCreated_at() ?></cite>
                                    <p><?= $comments->getContent() ?></p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>