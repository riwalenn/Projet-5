<section class="page-profil" id="profil">
    <div class="container">
        <h1 class="titre-dashboard-admin">Liste des utilisateurs</h1>
        <div class="row d-flex justify-content-around">
            <div class="card-deck">
                <div class="card" id="profil_Dash">
                    <img src="../ressources/img/dashboard/users.jpg" class="img_users_dashboard"/>
                    <div class="card-header">
                        <blockquote class="blockquote mb-0">
                            <footer class="blockquote-footer" style="color: #00c0c7"><i class="fa fa-user"></i> Users Manager</footer>
                        </blockquote>
                    </div>
                    <div class="card-body articles-caption">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                                <li class="breadcrumb-item"><a href="index.php?action=backendDashboard">Tableau de bord</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?= $filArianne ?></li>
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
                            <form action="#" method="post">
                                <tr class="<?= $user->getRoleClass(). ' ' .$user->getEmailClass() ?>">
                                    <td><a href="index.php?action=user&id=<?= $user->getId() ?>"><i class="fa fa-edit"></i> Editer</a></td>
                                    <td><?= $user->getId() ?></td>
                                    <td><?= $user->getPseudo() ?></td>
                                    <td>
                                        <?php if ($user->getRole() == 1) : ?>
                                        <select name="role" class="form-control form-control-sm">
                                            <option value="<?= $user->getRole() ?> selected"><?= $user->getRoleName() ?></option>
                                            <option value="2">Utilisateur</option>
                                        </select>
                                        <?php elseif ($user->getRole() == 2) : ?>
                                            <select name="role" class="form-control form-control-sm">
                                                <option value="<?= $user->getRole() ?> selected"><?= $user->getRoleName() ?></option>
                                                <option value="1">Administrateur</option>
                                            </select>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $user->getEmail() ?></td>
                                    <td><?= $user->getDate_modification() ?></td>
                                    <td><?= $user->getDate_inscription() ?></td>
                                    <td><?= $user->getCgu() ?></td>
                                    <td>
                                        <?php if ($user->getState() == 0) : ?>
                                            <select name="role" class="form-control form-control-sm user-status-red">
                                                <option value="<?= $user->getState() ?> selected"><?= $user->getStateName($user->getState()) ?></option>
                                                <option value="1">Token validé</option>
                                                <option value="2">Compte validé</option>
                                                <option value="3">Refusé</option>
                                            </select>
                                        <?php elseif ($user->getState() == 1) : ?>
                                            <select name="role" class="form-control form-control-sm user-status-orange">
                                                <option value="<?= $user->getState() ?> selected"><?= $user->getStateName($user->getState()) ?></option>
                                                <option value="2">Compte validé</option>
                                                <option value="3">Refusé</option>
                                            </select>
                                        <?php elseif ($user->getState() == 2) : ?>
                                            <select name="role" class="form-control form-control-sm user-status-green">
                                                <option value="<?= $user->getState() ?> selected"><?= $user->getStateName($user->getState()) ?></option>
                                                <option value="1">Token validé</option>
                                                <option value="3">Refusé</option>
                                            </select>
                                        <?php else: ?>
                                            <select name="role" class="form-control form-control-sm user-status-red">
                                                <option value="<?= $user->getState() ?> selected"><?= $user->getStateName($user->getState()) ?></option>
                                                <option value="1">Token validé</option>
                                                <option value="2">Compte validé</option>
                                            </select>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $user->getExpiration_token() ?></td>
                                    <td><button class="btn btn-primary adm-users" type="submit">Appliquer les modifications</button></td>
                                </tr>
                                <?php endforeach; ?>
                            </form>
                            </tbody>
                        </table>
                        <?php foreach ($usersList as $user) : ?>

                        <?php endforeach; ?>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>