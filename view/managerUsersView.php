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
                                    <td><?= $user->getCguClass() ?></td>
                                    <td>
                                        <select name="state" class="form-control form-control-sm <?= $user->getStateClass() ?>">
                                            <?php
                                            $i = 0;
                                            $j = 4;
                                            do {
                                                switch ($i)
                                                {
                                                    case 0:
                                                        if ($i == $user->getState()) {
                                                            echo '<option value=' . $user->getState() . ' selected>'. $user->getStateName() .'</option>';
                                                        } else {
                                                            echo '<option value='.$i.'>Compte non validé</option>';
                                                        }
                                                        break;

                                                    case 1:
                                                        if ($i == $user->getState()) {
                                                            echo '<option value=' . $user->getState() . ' selected>'. $user->getStateName() .'</option>';
                                                        } else {
                                                            echo '<option value='.$i.'>Token Validé</option>';
                                                        }
                                                        break;

                                                    case 2:
                                                        if ($i == $user->getState()) {
                                                            echo '<option value=' . $user->getState() . ' selected>'. $user->getStateName() .'</option>';
                                                        } else {
                                                            echo '<option value='.$i.'>Compte validé</option>';
                                                        }
                                                        break;

                                                    case 3:
                                                        if ($i == $user->getState()) {
                                                            echo '<option value=' . $user->getState() . ' selected>'. $user->getStateName() .'</option>';
                                                        } else {
                                                            echo '<option value='.$i.'>Compte supprimé</option>';
                                                        }
                                                        break;
                                                }
                                                do {
                                                    if ($j > $user->getState()){
                                                        switch ($j)
                                                        {
                                                            case 0:
                                                                echo '<option value='.$j.'>Compte non validé</option>';
                                                                break;

                                                            case 1:
                                                                echo '<option value='.$j.'>Token Validé</option>';
                                                                break;

                                                            case 2:
                                                                echo '<option value='.$j.'>Compte validé</option>';
                                                                break;

                                                            case 3:
                                                                echo '<option value='.$j.'>Compte supprimé</option>';
                                                                break;
                                                        }
                                                    }
                                                    $j--;
                                                } while ($j > $user->getState());
                                                $i++;
                                            } while ($i <= $user->getState())
                                            ?>
                                        </select>
                                    </td>
                                    <td><?= $user->getExpiration_token() ?></td>
                                    <td><button class="btn btn-primary adm-users" type="submit">Appliquer les modifications</button></td>
                                </tr>
                                <?php endforeach; ?>
                            </form>
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