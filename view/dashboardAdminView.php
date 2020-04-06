<?php
if ((isset($_SESSION['id']))) :
    ?>
    <h1>Dashboard ADMIN</h1>
    <section class="page-profil" id="profil">
        <div class="container">
            <div class="row d-flex justify-content-around">
                <div class="card-deck">
                    <div class="card" id="profil_Dash">
                        <img src="../ressources/img/dashboard/social.jpg" class="img_dashboard"/>
                        <div class="card-header">
                            <blockquote class="blockquote mb-0">
                                <footer class="blockquote-footer"><i class="fa fa-user"></i> User Manager</footer>
                            </blockquote>
                        </div>
                        <div class="card-body articles-caption">
                            <h5>Bonjour <b><?= $user->getPseudo() ?></b></h5>
                            <blockquote class="blockquote mb-0">
                                <footer class="blockquote-footer">Dernière connexion : <?= $user->getDate_modification() ?></footer>
                            </blockquote>
                            <small class="text-muted"><a class="articles-link" data-toggle="modal" href="#formModal" ><i class="fas fa-pen"></i> Modifier mes informations</a></small>
                            <p class="text-muted"><a href="index.php?action=logoutUser"><i class="fas fa-sign-out-alt"></i> Deconnexion</a></p>
                            <hr>
                            <p>
                                <small class="text-muted"><i class="fa fa-plus-square" style="color: #0056b3"></i> <a class="articles-link" data-toggle="modal" href="#" >ajouter un utilisateur</a></small><br>
                                <small class="text-muted"><i class="fa fa-history" style="color: #ffc107"></i> <a class="articles-link" data-toggle="modal" href="#" >liste des utilisateurs en attente de validation</a> <span class="badge badge-info"> <?= $nbUsersWaitingList ?> </span></small><br>
                                <small class="text-muted"><i class="fa fa-trash" style="color: red"></i> <a class="articles-link" data-toggle="modal" href="#" >vider la liste des utilisateurs non connecté depuis 3 mois</a> <span class="badge badge-danger"> <?= $nbUsersConnexionExpired ?> </span></small><br>
                                <small class="text-muted"><i class="fa fa-eye" style="color: #ffc107"></i> <a class="articles-link" data-toggle="modal" href="#" >voir la liste des utilisateurs n'ayant pas validé leurs token</a> <span class="badge badge-warning"> <?= $nbUsersTokenNotValidate ?> </span></small><br>
                                <small class="text-muted"><i class="fa fa-trash" style="color: red"></i> <a class="articles-link" data-toggle="modal" href="#" >vider la liste des utilisateurs avec un token expiré</a> <span class="badge badge-danger"> <?= $nbUsersTokenExpired ?> </span></small>
                            </p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted"><a class="articles-link" data-toggle="modal" href="#" ><i class="fas fa-eye"></i> voir la liste des utilisateurs</a></small>
                        </div>
                    </div>
                </div>
                <div class="card-deck">
                    <div class="card" id="profil_Dash">
                        <img src="../ressources/img/dashboard/articles.jpg" class="img_dashboard"/>
                        <div class="card-header">
                            <blockquote class="blockquote mb-0">
                                <footer class="blockquote-footer"><i class="fa fa-file"></i> Post Manager</footer>
                            </blockquote>
                        </div>
                        <div class="card-body articles-caption">
                            <p>
                                <small class="text-muted"><a class="articles-link" data-toggle="modal" href="#" ><i class="fa fa-plus-square"></i> ajouter un article</a></small><br>
                                <small class="text-muted"><a class="articles-link" data-toggle="modal" href="#" ><i class="fa fa-history"></i> liste des articles en attente de validation</a> (1)</small><br>
                                <small class="text-muted"><a class="articles-link" data-toggle="modal" href="#" ><i class="fa fa-trash"></i> vider la liste des articles non validés</a> (0)</small><br>
                            </p>
                            <hr>
                            <p>
                                <small class="text-muted"><a class="articles-link" data-toggle="modal" href="#" ><i class="fa fa-history"></i> liste des commentaires en attente de validation</a> (5)</small>
                            </p>
                            <hr>
                            <p>
                                <small class="text-muted"><a class="articles-link" data-toggle="modal" href="#" ><i class="fa fa-plus-square"></i> ajouter un portfolio</a></small><br>
                            </p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted"><a class="articles-link" data-toggle="modal" href="#" ><i class="fas fa-eye"></i> voir la liste des articles</a></small>
                        </div>
                    </div>
                </div>
    </section>
    <!-- Modal modifs user -->
    <div class="articles-modal modal fade" id="formModal" tabindex="-1" role="dialog" aria-hidden="true">
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
                                <h5>Modification de mes données</h5>
                                <form id="formDataUser" action="index.php?action=modifDataUser" method="post" onsubmit="return verifForm(this)">
                                    <input type="hidden" value="<?= $_SESSION['id'] ?>" name="id" id="id">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-user-ninja"></i></span>
                                        </div>
                                        <input type="text" id="pseudo" class="form-control form-control-sm" placeholder="entrez votre pseudonyme ici" name="pseudo" aria-label="Pseudonyme" aria-describedby="basic-addon1" onkeyup="verifPseudo(this)" value="<?= $user->getPseudo() ?>" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-pen" data-toggle="tooltip" data-placement="right"></i></span>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-at"></i></span>
                                        </div>
                                        <input id="email" class="form-control form-control-sm" placeholder="entrez votre email ici" aria-label="email" type="email" name="email" value="<?= $user->getEmail() ?>" onkeyup="verifEmail(this)" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-pen" data-toggle="tooltip" data-placement="right"></i></span>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                                        </div>
                                        <input id="password" class="form-control form-control-sm classeMdp" placeholder="merci d'entrer votre mot de passe pour valider vos informations" aria-label="password" type="password" name="password" maxlength="64" minlength="10" onkeyup="verifPassword(this)" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-pen" data-toggle="tooltip" data-placement="right" title="Cliquez ici pour avoir plus d'infos !"></i></span>
                                        </div>
                                    </div>
                                    <p>Si vous avez oublié votre mot de passe ou que vous souhaitez le changer<br> merci d'utiliser le <a href="index.php?action=forgotPassword">formulaire dédié</a>.<br> Le champ ci-dessus n'étant utilisé que pour valider vos informations.</p>
                                    <button class="btn btn-primary my-2 my-sm-0" aria-label="connexion" type="submit" value="Modification">Modifier mes données</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php endif; ?>
