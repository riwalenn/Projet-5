<!-- articles Grid -->
<section class="bg-light page-section" id="articles">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading text-uppercase">Articles</h2>
                <h3 class="section-subheading text-muted">Ci-dessous quelques articles qui pourraient vous
                    intéresser.</h3>
                <!-- Recherche : filtres -->
                <button class="btn filtres btn-sm dropdown-toggle" type="button" data-toggle="collapse"
                        data-target="#collapseExample"
                        aria-expanded="false" aria-controls="collapseExample">
                    <i class="fa fa-search"></i> Filtres
                </button>
                <div class="collapse" id="collapseExample">
                    <div class="card bg-light mb-3 rounded" style="max-width: 18rem;">
                        <form id="search-form">
                            <div class="card-body text-center">
                                <div class="row filtres-form">
                                    <label>par auteur :</label>
                                    <select class="form-control form-control-sm">
                                        <option selected>---indifférent---</option>
                                        <?php foreach ($users as $user) { ?>
                                            <option><?= $user->getPseudo() ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="row filtres-form">
                                    <label>par catégorie :</label>
                                    <select class="form-control form-control-sm">
                                        <option selected>---indifférent---</option>
                                        <?php foreach ($categories as $category) { ?>
                                            <option><?= $category->getCategory() ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="row filtres-form">
                                    <label>par terme(s) :</label>
                                    <input type="text" class="form-control form-control-sm">
                                </div>
                                <div class="row filtres-form">
                                    <label>par dates :</label>
                                    <input type="date" class="form-control form-control-sm"><input type="date"
                                                                                                   class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="card-footer text-muted">
                                <button class="btn filtres-submit btn-sm " type="button" id="clear">Effacer
                                </button>
                                <button class="btn filtres-submit btn-sm " type="button">
                                    Rechercher
                                </button>
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
            //print_r($listPosts);
            foreach ($listPosts as $post) {
                ?>
                <div class="col-md-4 col-sm-6 articles-item">
                    <a class="articles-link" data-toggle="modal" href="#articlesModal<?= $post->getId() ?>">
                        <div class="articles-hover">
                            <div class="articles-hover-content">
                                <i class="fas fa-plus fa-3x"></i>
                            </div>
                        </div>
                        <picture>
                            <?php foreach ($post->getCategories() as $category) {
                                ?>
                                <source srcset="<?= $category->getImgCategoryS() ?>" media="all">
                                <img class="img-fluid" src="<?= $category->getImgCategoryWP() ?>" alt="">
                            <?php } ?>
                        </picture>
                    </a>
                    <div class="articles-caption">
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
                <li class="page-item">
                    <a class="page-link" href="index.php?action=articlesListe&page=1">1</a>
                </li>
                <?php
                foreach ($nbPages as $nbPage) {
                    for ($counter = 1; $counter <= $nbPage; $counter++) {
                        if ($nbPage >= 1) :
                            ?>
                            <li class="page-item">
                                <a class="page-link"
                                   href="index.php?action=articlesListe&page=<?= $counter + 1 ?>"><?= $counter + 1 ?></a>
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
                                <picture>
                                    <?php foreach ($post->getCategories() as $category) {
                                        ?>
                                        <source srcset="<?= $category->getImgCategoryWP() ?>" media="all">
                                        <img class="img-fluid d-block mx-auto" src="<?= $category->getImgCategoryS() ?>"
                                             alt="">
                                    <?php } ?>
                                </picture>
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
