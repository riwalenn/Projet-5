<?php
if ((isset($_SESSION['id']))) :
    ?>
    <section class="page-profil" id="profil">
        <div class="container">
            <h1 class="titre-dashboard-admin">Dashboard ADMIN</h1>
            <div class="row d-flex justify-content-around">
                <div class="card-deck">
                    <div class="card" id="profil_Dash">
                        <?= View::generateDashboardPictureTag("social", "", "img_dashboard") ?>
                        <div class="card-header">
                            <blockquote class="blockquote mb-0">
                                <footer class="blockquote-footer" style="color: #00c0c7"><i class="fa fa-user"></i> Coup
                                    d'oeil - Utilisateurs <span class="badge badge-success"><?= $nbUsersTotal ?></span>
                                </footer>
                            </blockquote>
                        </div>
                        <div class="card-body articles-caption">
                            <h5>Bonjour <b><?= $user->getPseudo() ?></b></h5>
                            <blockquote class="blockquote mb-0">
                                <footer class="blockquote-footer">
                                    Dernière connexion : <?= $user->getDate_modification() ?>
                                </footer>
                            </blockquote>
                            <p class="text-muted">
                                <a href="index.php?action=logoutUser" onclick="return ConfirmDeconnexion()"><i class="fas fa-sign-out-alt"></i> Deconnexion</a>
                            </p>
                            <hr>
                            <p>
                                <small class="text-muted">
                                    * ajouter un utilisateur -
                                    <a class="articles-link" data-toggle="modal" href="#formModalAdd">
                                        <i class="fa fa-plus-square"></i> ajouter</a>
                                </small><br>
                                <small class="text-muted"><span class="badge badge-success"><?= $nbUsersReferent ?></span> utilisateur(s) référents -
                                    <a class="articles-link" href="index.php?action=usersManager&value=referents">
                                        <i class="fa fa-eye"></i> voir liste</a></small><br>
                                <small class="text-muted"><span class="badge badge-danger"> <?= $nbUsersToDelete ?> </span> utilisateur(s) à supprimer -
                                    <a class="articles-link" href="index.php?action=usersManager&value=trash">
                                        <i class="fa fa-eye"></i> voir liste</a></small><br>
                                <small class="text-muted">
                                    <span class="badge badge-warning"> <?= $nbUsersWaitingList ?> </span>
                                    utilisateur(s) en attente de validation -
                                    <a class="articles-link" href="index.php?action=usersManager&value=uncheckedUsers">
                                        <i class="fa fa-history"></i> voir liste</a>
                                </small><br>
                                <small class="text-muted"><span class="badge badge-danger"> <?= $nbUsersConnexionExpired ?> </span>
                                    utilisateur(s) non connecté depuis 3 mois - <i class="fas fa-exclamation-triangle danger"></i>
                                    <a class="articles-link" href="index.php?action=delete&value=connexionExpired" onclick="return ConfirmMessageAdmin()">
                                        <i class="fa fa-trash"></i> purger la liste</a>
                                </small><br>
                                <small class="text-muted"><span class="badge badge-warning"> <?= $nbUsersTokenNotValidate ?> </span>
                                    utilisateur(s) n'ont pas validé leurs token -
                                    <a class="articles-link" href="index.php?action=usersManager&value=uncheckedTokenUsers">
                                        <i class="fa fa-eye"></i> voir liste</a> </small><br>
                                <small class="text-muted">
                                    <span class="badge badge-danger"> <?= $nbUsersTokenExpired ?> </span> token(s)
                                    expiré(s) - <i class="fas fa-exclamation-triangle danger"></i>
                                    <a class="articles-link" href="index.php?action=delete&value=tokenExpired" onclick="return ConfirmMessageAdmin()">
                                        <i class="fa fa-trash"></i>
                                        purger la liste</a>
                                </small>
                            </p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">
                                <a class="nav-link" href="index.php?action=usersManager&value=all"><i class="fas fa-eye"></i> voir la liste des utilisateurs</a>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="card-deck">
                    <div class="card" id="profil_Dash">
                        <?= View::generateDashboardPictureTag("articles", "", "img_dashboard") ?>
                        <div class="card-header">
                            <blockquote class="blockquote mb-0">
                                <footer class="blockquote-footer" style="color: #00c0c7">
                                    <i class="fa fa-file-alt"></i> Coup d'oeil - Articles <span class="badge badge-success"><?= $nbPostTotal ?></span>
                                </footer>
                            </blockquote>
                        </div>
                        <div class="card-body articles-caption">
                            <p>
                                <small class="text-muted">
                                    * ajouter un article -
                                    <a class="articles-link" data-toggle="modal" href="#formModalAddPost">
                                        <i class="fa fa-plus-square"></i> ajouter</a>
                                </small><br>
                                <small class="text-muted">
                                    <span class="badge badge-warning"><?= $nbPostsUnchecked ?> </span>
                                    article(s) en attente de validation -
                                    <a class="articles-link" href="index.php?action=postsManager&value=uncheckedPosts">
                                        <i class="fa fa-history"></i> voir liste</a>
                                </small><br>
                                <small class="text-muted">
                                    <span class="badge badge-warning"><?= $nbPostsArchived ?> </span>
                                    article(s) archivés -
                                    <a class="articles-link" href="index.php?action=postsManager&value=archived">
                                        <i class="fa fa-history"></i> voir liste</a>
                                </small><br>
                                <small class="text-muted">
                                    <span class="badge badge-danger"><?= $nbPostsToDelete ?> </span> article(s) à supprimer - <i class="fas fa-exclamation-triangle danger"></i>
                                    <a class="articles-link" href="index.php?action=delete&value=postsToDelete" onclick="return ConfirmMessageAdmin()">
                                        <i class="fa fa-trash"></i>
                                        purger la liste</a>
                                </small>
                            </p>
                            <hr>
                            <p>
                                <small class="text-muted">
                                    <span class="badge badge-warning"><?= $nbCommentsUnchecked ?> </span>
                                    commentaire(s) en attente de validation -
                                    <a class="articles-link" href="index.php?action=commentsManager">
                                        <i class="fa fa-history"></i> voir liste</a>
                                </small><br>
                                <small class="text-muted">
                                    <span class="badge badge-danger"><?= $nbCommentsToDelete ?> </span> commentaire(s) à supprimer - <i class="fas fa-exclamation-triangle danger"></i>
                                    <a class="articles-link" href="index.php?action=commentsManager&CRUD=D" onclick="return ConfirmMessageAdmin()">
                                        <i class="fa fa-trash"></i>
                                        purger la liste</a>
                                </small>
                            </p>
                            <hr>
                            <p>
                                <small class="text-muted">
                                    <a class="articles-link" href="index.php?action=portfolioManager">
                                        <i class="fa fa-copy"></i> voir le portfolio</a>
                                </small><br>
                            </p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">
                                <a class="nav-link" href="index.php?action=postsManager&value=all"><i class="fas fa-eye"></i> voir la liste des articles</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal add user -->
    <div class="articles-modal modal fade" id="formModalAdd" tabindex="-1" role="dialog" aria-hidden="true">
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
                                <h5><i class="fa fa-user-cog"></i> Ajouter un utilisateur</h5>
                                <form id="formDataUser" action="index.php?action=usersManager&value=all&CRUD=C" method="post" onsubmit="return verifForm(this)">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                        class="fas fa-caret-right"></i></span>
                                        </div>
                                        <input type="text" id="pseudo" class="form-control form-control-sm"
                                               placeholder="entrez votre pseudonyme ici" name="pseudo"
                                               aria-label="Pseudonyme" aria-describedby="basic-addon1"
                                               onkeyup="verifPseudo(this)" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                        class="fas fa-caret-right"></i></span>
                                        </div>
                                        <select id="role" class="form-control form-control-sm" name="role">
                                            <?php
                                            foreach (User::$listeRole as $key => $value) :
                                                echo '<option value="' . $key .'">' . $value .'</option>';
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                        class="fas fa-caret-right"></i></span>
                                        </div>
                                        <input id="email" class="form-control form-control-sm"
                                               placeholder="entrez votre email ici" aria-label="email" type="email"
                                               name="email" onkeyup="verifEmail(this)" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                        class="fas fa-caret-right"></i></span>
                                        </div>
                                        <input id="password" class="form-control form-control-sm classeMdp"
                                               placeholder="merci d'entrer votre mot de passe pour valider vos informations"
                                               aria-label="password" type="password" name="password" maxlength="64"
                                               minlength="10" onkeyup="verifPassword(this)" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                        class="fas fa-caret-right"></i></span>
                                        </div>
                                        <select id="state" class="form-control form-control-sm" name="state">
                                            <?php
                                            foreach (User::$listeStatut as $key => $value) :
                                                echo '<option value="' . $key .'">' . $value .'</option>';
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    <button class="btn btn-primary my-2 my-sm-0" aria-label="ajouter" type="submit"
                                            value="add">Ajouter un utilisateur
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal add Post -->
    <div class="articles-modal modal fade" id="formModalAddPost" tabindex="-1" role="dialog" aria-hidden="true">
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
                                <h5><i class="fa fa-pencil-alt"></i> Ajouter un article</h5>
                                <form id="formDataUser" action="index.php?action=postsManager&value=all&CRUD=C" method="post">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                        class="fas fa-caret-right"></i></span>
                                        </div>
                                        <input type="text" id="title" class="form-control form-control-sm"
                                               placeholder="entrez le titre ici" name="title"
                                               aria-label="title" aria-describedby="basic-addon1" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-caret-right"></i></span>
                                        </div>
                                        <input type="text" id="kicker" class="form-control form-control-sm"
                                               placeholder="entrez le châpo ici" name="kicker"
                                               aria-label="kicker" aria-describedby="basic-addon1" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                        class="fas fa-caret-right"></i></span>
                                        </div>
                                        <label for="content"></label><textarea class="form-control" id="summernote" rows="5" name="content" placeholder="entrez le contenu de l'article ici" required></textarea>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                        class="fas fa-caret-right"></i></span>
                                        </div>
                                        <input type="text" id="url" class="form-control form-control-sm"
                                               placeholder="entrez le lien ici" name="url"
                                               aria-label="url" aria-describedby="basic-addon1">
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                        class="fas fa-caret-right"></i></span>
                                        </div>
                                        <select name="id_category" class="form-control form-control-sm">
                                            <?php
                                            foreach ($categories as $category) :
                                                echo '<option value="' . $category->getId() .'">' . $category->getCategory() .'</option>';
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                        class="fas fa-caret-right"></i></span>
                                        </div>
                                        <select id="state" class="form-control form-control-sm" name="state">
                                            <?php
                                            foreach (Post::$listeStatut as $key => $value) :
                                                echo '<option value="' . $key .'">' . $value .'</option>';
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    <button class="btn btn-primary my-2 my-sm-0" aria-label="ajouter" type="submit"
                                            value="add">Ajouter un article
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
endif;
?>
