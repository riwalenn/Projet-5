<section class="page-profil" id="profil">
    <div class="container dashboard">
       <h1 class="titre-dashboard-admin">Portfolio</h1>
        <div class="row d-flex justify-content-around">
            <div class="card-deck">
                <div class="card" id="profil_Dash">
                    <?= View::generateDashboardPictureTag("portfolio", "Portfolio management", "img_portfolio_dashboard") ?>
                    <div class="card-header d-flex justify-content-between">
                        <blockquote class="blockquote mb-0">
                            <footer class="blockquote-footer" style="color: #00c0c7"><i class="fa fa-copy"></i> Portfolio Manager</footer>
                        </blockquote>
                        <?= $errorMessage ?>
                    </div>
                    <div class="card-body articles-caption">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                                    <li class="breadcrumb-item"><a href="index.php?action=backendDashboard">Tableau de bord</a></li>
                                    <li class="breadcrumb-item"><a href="index.php?action=portfolioManager">Portfolio</a></li>
                                </ol>
                            </nav>
                        <table class="table table-striped">
                            <thead class="thead-light">
                            <tr>
                                <th>Image</th>
                                <th>Titre</th>
                                <th>Châpo</th>
                                <th>Contenu</th>
                                <th>Créé en</th>
                                <th>Client</th>
                                <th>Catégories</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($portfolio as $folio) : ?>
                                <form action="index.php?action=portfolioManager&CRUD=U" method="post">
                                    <input type="hidden" name="id" value="<?= $folio->getId() ?>">
                                    <tr>
                                        <td><a data-toggle="modal" href="#formModalEdit<?= $folio->getId() ?>"><?= View::generatePortfolioPicture($folio, Constantes::SMALLIMG) ?></a></td>
                                        <td><input type="text" name="title" value="<?= $folio->getTitle() ?>"></td>
                                        <td><textarea name="kicker" rows="2"><?= $folio->getKicker() ?></textarea> </td>
                                        <td><textarea name="content" rows="4"><?= $folio->getContent() ?></textarea> </td>
                                        <td><input type="number" name="date_conception" value="<?= $folio->getDate_conception() ?>" placeholder="YYYY" min="2009" max="2022"></td>
                                        <td><input type="text" name="client" value="<?= $folio->getClient() ?>"></td>
                                        <td><textarea name="categories" rows="2"><?= $folio->getCategories() ?></textarea> </td>
                                        <td><button class="btn btn-primary adm-users" type="submit">Appliquer les modifications</button></td>
                                    </tr>
                                </form>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a data-toggle="modal" href="#formModaladd">Ajouter un folio <i class="fa fa-plus-square"></i></a>
                        <small class="text-muted">
                            <form action="index.php?action=portfolioManager&CRUD=D" method="post">
                                <div class="d-flex justify-content-sm-start">
                                    <select class="form-control form-control-sm" name="id">
                                        <?php foreach ($portfolio as $folio) : ?>
                                            <option value="<?= $folio->getId() ?>"><?= $folio->getTitle() ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button class="btn" type="submit"><i class="fa fa-trash danger"></i></button>
                                </div>
                            </form>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal modif folio -->
<?php foreach ($portfolio as $folio) : ?>
<div class="articles-modal modal fade" id="formModalEdit<?= $folio->getId() ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                            <h5><i class="fa fa-pencil-alt"></i> Modifier un portfolio</h5>
                            <?= View::generatePortfolioPicture($folio, Constantes::FULLIMG) ?>
                            <p class="alert-info">L'image doit être de format 800x600 maximum</p>
                            <form method="post" action="index.php?action=portfolioManager&CRUD=U" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= $folio->getId() ?>">
                                <input type="hidden" name="MAX_FILES_SIZE" value="200000">
                                <div class="input-group mb-3">
                                    <label for="foliojpg"></label>
                                    <input name="foliojpg" id="foliojpg" type="file" />
                                </div>
                                <div class="input-group mb-3">
                                    <label for="foliowebp"></label>
                                    <input name="foliowebp" id="foliowebp" type="file" />
                                </div>
                                <div class="input-group mb-3">
                                    <label for="title"></label>
                                    <input class="form-control form-control-sm" type="text" id="title" name="title" value="<?= $folio->getTitle() ?>" placeholder="Inscrivez le titre ici">
                                </div>
                                <div class="input-group mb-3">
                                    <label for="kicker"></label>
                                    <input class="form-control form-control-sm" type="text" id="kicker" name="kicker" value="<?= $folio->getKicker() ?>" placeholder="Inscrivez le châpo ici">
                                </div>
                                <div class="input-group mb-3">
                                    <label for="content"></label>
                                    <textarea class="form-control form-control-sm" id="content" placeholder="Inscrivez le contenu ici" name="content" rows="5"><?= $folio->getContent() ?></textarea>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="date_conception"></label>
                                    <input class="form-control form-control-sm" type="text" id="date_conception" name="date_conception" value="<?= $folio->getDate_conception() ?>" placeholder="YYYY" min="2009" max="2022">
                                </div>
                                <div class="input-group mb-3">
                                    <label for="client"></label>
                                    <input class="form-control form-control-sm" type="text" id="client" name="client" value="<?= $folio->getClient() ?>" placeholder="Inscrivez le client ici">
                                </div>
                                <div class="input-group mb-3">
                                    <label for="categories"></label>
                                    <input class="form-control form-control-sm" type="text" id="categories" name="categories" value="<?= $folio->getCategories() ?>" placeholder="Inscrivez les catégories ici">
                                </div>
                                <button class="btn btn-primary adm-users" type="submit">Modifier</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<!-- Modal add folio -->
<div class="articles-modal modal fade" id="formModaladd" tabindex="-1" role="dialog" aria-hidden="true">
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
                            <h5><i class="fa fa-pencil-alt"></i> Ajouter un portfolio</h5>
                            <form method="post" action="index.php?action=portfolioManager&CRUD=C" enctype="multipart/form-data">
                                <div class="input-group mb-3">
                                    <label for="title"></label>
                                    <input class="form-control form-control-sm" type="text" id="title" name="title" placeholder="Inscrivez le titre ici">
                                </div>
                                <div class="input-group mb-3">
                                    <label for="kicker"></label>
                                    <input class="form-control form-control-sm" type="text" id="kicker" name="kicker" placeholder="Inscrivez le châpo ici">
                                </div>
                                <div class="input-group mb-3">
                                    <label for="content"></label>
                                    <textarea class="form-control form-control-sm" id="content" placeholder="Inscrivez le contenu ici" name="content" rows="5"></textarea>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="date_conception"></label>
                                    <input class="form-control form-control-sm" type="text" id="date_conception" name="date_conception" placeholder="YYYY" min="2009" max="2022">
                                </div>
                                <div class="input-group mb-3">
                                    <label for="client"></label>
                                    <input class="form-control form-control-sm" type="text" id="client" name="client" placeholder="Inscrivez le client ici">
                                </div>
                                <div class="input-group mb-3">
                                    <label for="categories"></label>
                                    <input class="form-control form-control-sm" type="text" id="categories" name="categories" placeholder="Inscrivez les catégories ici">
                                </div>
                                <p class="alert-info">Les images doivent être de format 800x600 maximum</p>
                                <input type="hidden" name="MAX_FILES_SIZE" value="200000">
                                <div class="input-group mb-3">
                                    <label for="foliojpg"></label>
                                    <input name="foliojpg" id="foliojpg" type="file" />
                                </div>
                                <div class="input-group mb-3">
                                    <label for="foliowebp"></label>
                                    <input name="foliowebp" id="foliowebp" type="file" />
                                </div>
                                <button class="btn btn-primary adm-users" type="submit">Ajouter</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>