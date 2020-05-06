<section class="page-profil" id="profil">
    <div class="container dashboard">
        <h1 class="titre-dashboard-admin">Commentaires</h1>
        <div class="row d-flex justify-content-around">
            <div class="card-deck">
                <div class="card" id="profil_Dash">
                    <?= View::generateDashboardPictureTag("comm", "Commentaires management", "img_comms_dashboard") ?>
                    <div class="card-header d-flex justify-content-between">
                        <blockquote class="blockquote mb-0">
                            <footer class="blockquote-footer" style="color: #00c0c7"><i class="fa fa-copy"></i> Commentaires Manager</footer>
                        </blockquote>
                        <?= $errorMessage ?>
                    </div>
                    <div class="card-body articles-caption">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                                <li class="breadcrumb-item"><a href="index.php?action=backendDashboard">Tableau de bord</a></li>
                                <li class="breadcrumb-item"><a href="index.php?action=commentsManager">Commentaires</a></li>
                            </ol>
                        </nav>
                        <table class="table table-striped">
                            <thead class="thead-light">
                            <tr>
                                <th></th>
                                <th>Article</th>
                                <th>Pseudo</th>
                                <th>Titre</th>
                                <th>Contenu</th>
                                <th>Statut</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($commentaires as $commentaire) : ?>
                                <form action="index.php?action=commentsManager&CRUD=US" method="post">
                                    <input type="hidden" name="id" value="<?= $commentaire->getId() ?>">
                                    <tr>
                                        <td><a data-toggle="modal" href="#formModalEdit<?= $commentaire->getId() ?>"><i class="fa fa-edit"></i> Editer</a></td>
                                        <td><?= $commentaire->getId_post() ?></td>
                                        <td><?= $commentaire->getPseudo() ?></td>
                                        <td><?= $commentaire->getTitle() ?></td>
                                        <td><?= $commentaire->getContent() ?></td>
                                        <td>
                                            <select name="state" class="form-control form-control-sm <?= $commentaire->getStateClass() ?>">
                                                <?php
                                                foreach (Comment::$listeStatut as $key => $valueSelect) :
                                                    $selected = '';
                                                    if ($commentaire->getState() == $key) :
                                                        $selected = 'selected';
                                                    endif;
                                                    echo '<option value="' . $key .'" ' . $selected . '>' . $valueSelect .'</option>';
                                                endforeach;
                                                ?>
                                            </select>
                                        </td>
                                        <td><button class="btn btn-primary adm-users" type="submit">Appliquer les modifications</button></td>
                                    </tr>
                                </form>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php foreach ($commentaires as $commentaire) : ?>
    <!-- Modal edit user -->
    <div class="articles-modal modal fade" id="formModalEdit<?= $commentaire->getId() ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                <h5><i class="fa fa-user-cog"></i> Modifier un commentaire</h5>
                                <form id="formDataUser" action="index.php?action=commentsManager&CRUD=U" method="post">
                                    <input type="hidden" name="id" value="<?= $commentaire->getId() ?>">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-caret-right"></i></span>
                                        </div>
                                        <input id="title" value="<?= $commentaire->getTitle() ?>" class="form-control form-control-sm" placeholder="entrez votre titre ici" aria-label="title" type="text" name="title">
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-caret-right"></i></span>
                                        </div>
                                        <textarea name="content" id="content" row="5"><?= $commentaire->getContent() ?></textarea>
                                     </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-caret-right"></i></span>
                                        </div>
                                        <select name="state" class="form-control form-control-sm <?= $commentaire->getStateClass() ?>">
                                            <?php
                                            foreach (Comment::$listeStatut as $key => $value) :
                                                $selected = '';
                                                if ($commentaire->getState() == $key) :
                                                    $selected = 'selected';
                                                endif;
                                                echo '<option value="' . $key .'" ' . $selected . '>' . $value .'</option>';
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    <button class="btn btn-primary my-2 my-sm-0" aria-label="modifier" type="submit" value="edit">Modifier un commentaire</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
