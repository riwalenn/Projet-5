<section class="page-profil" id="profil">
    <div class="container dashboard">
        <h1 class="titre-dashboard-admin">Liste des utilisateurs</h1>
        <div class="row d-flex justify-content-around">
            <div class="card-deck">
                <div class="card" id="profil_Dash">
                    <?= View::generateDashboardPictureTag("users", "Users management", "img_users_dashboard") ?>
                    <div class="card-header d-flex justify-content-between">
                        <blockquote class="blockquote mb-0">
                            <footer class="blockquote-footer" style="color: #00c0c7"><i class="fa fa-user"></i> Users Manager</footer>
                        </blockquote>
                        <?= $errorMessage ?>
                    </div>
                    <div class="card-body articles-caption">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                                <li class="breadcrumb-item"><a href="index.php?action=backendDashboard">Tableau de bord</a></li>
                                <li class="breadcrumb-item">
                                    <a class="dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?= $filArianne ?>
                                    </a>
                                    <?= View::generateDropdown($allValues, "usersManager") ?>
                                </li>
                            </ol>
                        </nav>
                        <table class="table table-striped">
                            <thead class="thead-light">
                            <tr>
                                <th></th>
                                <th>Id</th>
                                <th>Pseudo</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Connecté le</th>
                                <th>Inscrit le</th>
                                <th>C.G.U</th>
                                <th>Statut</th>
                                <th>date expiration token</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($usersList as $user) : ?>
                            <?php if ($user->getState() != 3) : ?>
                                <form action="index.php?action=usersManager&value=<?= $value ?>&CRUD=U" method="post">
                                    <input type="hidden" name="pseudo" value="<?= $user->getPseudo() ?>">
                                    <input type="hidden" name="email" value="<?= $user->getEmail() ?>">
                            <?php else: ?>
                                <form action="index.php?action=usersManager&value=<?= $value ?>&CRUD=D" method="post">
                                    <input type="hidden" name="date_modification" value="<?= $user->getDate_modification() ?>">
                            <?php endif; ?>
                                    <input type="hidden" name="id" value="<?= $user->getId() ?>">
                                    <tr>
                                        <td>
                                            <?php if ($user->getState() != 3) : ?>
                                                <a data-toggle="modal" href="#formModalEdit<?= $user->getId() ?>"><i class="fa fa-edit"></i> Editer</a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $user->getId() ?></td>
                                        <td><?= $user->getPseudo() ?></td>
                                        <td>
                                            <label>
                                                <select name="role" class="form-control form-control-sm">
                                                    <?php
                                                    foreach (User::$listeRole as $key => $val) {
                                                        $selected = '';
                                                        if ($user->getRole() == $key) :
                                                            $selected = 'selected';
                                                        endif;
                                                        echo '<option value="' . $key . '" ' . $selected . '>' . $val . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </label>
                                        </td>
                                        <td><?= $user->getEmail() ?></td>
                                        <td><?= $user->getDate_modification_fr() ?></td>
                                        <td><?= $user->getDate_inscription_fr() ?></td>
                                        <td><?= $user->getCguClass() ?></td>
                                        <td>
                                            <label>
                                                <select name="state" class="form-control form-control-sm <?= $user->getStateClass() ?>">
                                                    <?php
                                                    foreach (User::$listeStatut as $key => $val) {
                                                        $selected = '';
                                                        if ($user->getState() == $key) :
                                                            $selected = 'selected';
                                                        endif;
                                                        echo '<option value="' . $key . '" ' . $selected . '>' . $val . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </label>
                                        </td>
                                        <td><?= $user->getExpiration_token() ?></td>
                                        <?php if ($user->getState() != 3) : ?>
                                            <td><button class="btn btn-primary adm-users" type="submit">Appliquer les modifications</button></td>
                                        <?php else: ?>
                                            <td><button class="btn btn-danger adm-users" type="submit">Supprimer le compte</button></td>
                                        <?php endif; ?>
                                    </tr>
                                </form>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                            <blockquote class="blockquote mb-0 d-flex flex-row-reverse">
                                <small class="p-2"><i class="fa fa-trash danger"></i> <a class="articles-link" href="index.php?action=usersManager&value=trash">Corbeille</a></small>
                            </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php foreach ($usersList as $user) : ?>
    <!-- Modal edit user -->
    <div class="articles-modal modal fade" id="formModalEdit<?= $user->getId() ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                <h5><i class="fa fa-user-cog"></i> Modifier un utilisateur</h5>
                                <form id="formDataUser" action="index.php?action=usersManager&value=<?= $value ?>&CRUD=U" method="post" onsubmit="return verifForm(this)">
                                    <input type="hidden" name="id" value="<?= $user->getId() ?>">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-caret-right"></i></span>
                                        </div>
                                        <input type="text" id="pseudo" class="form-control form-control-sm"  value="<?= $user->getPseudo() ?>" placeholder="entrez votre pseudonyme ici" name="pseudo" aria-label="Pseudonyme" aria-describedby="basic-addon1" onkeyup="verifPseudo(this)" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-caret-right"></i></span>
                                        </div>
                                        <select name="role" class="form-control form-control-sm">
                                            <?php
                                            foreach (User::$listeRole as $key => $value) :
                                                $selected = '';
                                                if ($user->getRole() == $key) :
                                                    $selected = 'selected';
                                                endif;
                                                echo '<option value="' . $key .'" ' . $selected . '>' . $value .'</option>';
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-caret-right"></i></span>
                                        </div>
                                        <input id="email" value="<?= $user->getEmail() ?>" class="form-control form-control-sm" placeholder="entrez votre email ici" aria-label="email" type="email" name="email" onkeyup="verifEmail(this)" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-caret-right"></i></span>
                                        </div>
                                        <select name="state" class="form-control form-control-sm <?= $user->getStateClass() ?>">
                                            <?php
                                            foreach (User::$listeStatut as $key => $value) :
                                                $selected = '';
                                                if ($user->getState() == $key) :
                                                    $selected = 'selected';
                                                endif;
                                                echo '<option value="' . $key .'" ' . $selected . '>' . $value .'</option>';
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    <button class="btn btn-primary my-2 my-sm-0" aria-label="ajouter" type="submit" value="edit">Modifier un utilisateur</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>