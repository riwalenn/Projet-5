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
                                        <td><a data-toggle="modal" href="#formModalEdit<?= $folio->getId() ?>"><?= View::generatePortfolioPicture($folio, 'small') ?></a></td>
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
                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal modif Post -->
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
                            <h5><i class="fa fa-pencil-alt"></i> Modifier l'image d'un portfolio</h5>
                            <?= View::generatePortfolioPicture($folio, 'full') ?>
                            <p class="alert-info">L'image doit être de format 800x600 maximum</p>
                            <form method="post" action="index.php?action=portfolioManager&CRUD=UP" enctype="multipart/form-data">

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
