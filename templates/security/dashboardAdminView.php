<?php
if ((isset($_SESSION['id']))) :
    ?>
    <section class="page-profil" id="profil" xmlns="http://www.w3.org/1999/xhtml">
        <div class="container">
            <h1 class="titre-dashboard-admin">Dashboard ADMIN</h1>
            <div class="row d-flex justify-content-around">
                <div class="card-deck">
                    <div class="card" id="profil_Dash">
                        <?= View::generateDashboardPictureTag("social", "", "img_dashboard") ?>
                        <div class="card-header">
                            <blockquote class="blockquote mb-0">
                                <footer class="blockquote-footer" style="color: #00c0c7"><i class="fa fa-user"></i> Coup
                                    d'oeil - Utilisateurs <span class="badge badge-success"><?= htmlspecialchars($nbUsersTotal) ?></span>
                                </footer>
                            </blockquote>
                        </div>
                        <div class="card-body articles-caption">
                            <h5>Bonjour <b><?= htmlspecialchars($user->getPseudo()) ?></b></h5>
                            <blockquote class="blockquote mb-0">
                                <footer class="blockquote-footer">
                                    Dernière connexion : <?= htmlspecialchars($user->getDate_modification()) ?>
                                </footer>
                            </blockquote>
                            <p class="text-muted">
                                <a href="index.php?action=logoutUser" onclick="return ConfirmDeconnexion()"><i
                                            class="fas fa-sign-out-alt"></i> Deconnexion</a>
                            </p>
                            <hr>
                            <h6 class="dashboard">Utilisateurs (ajout/validation)</h6>
                            <p>
                                <small class="text-muted">
                                    * ajouter un utilisateur -
                                    <a class="articles-link" data-toggle="modal" href="#formModalAdd">
                                        <i class="fa fa-plus-square"></i> ajouter</a>
                                </small><br>
                                <small class="text-muted">
                                    <span class="badge badge-success"><?= htmlspecialchars($nbUsersReferent) ?></span> utilisateur(s)
                                    référents -
                                    <a class="articles-link" href="index.php?action=usersManager&value=referents">
                                        <i class="fa fa-eye"></i> voir liste</a></small><br>
                                <small class="text-muted">
                                    <span class="badge badge-warning"> <?= htmlspecialchars($nbUsersWaitingList) ?> </span>
                                    utilisateur(s) en attente de validation -
                                    <a class="articles-link" href="index.php?action=usersManager&value=uncheckedUsers">
                                        <i class="fa fa-history"></i> voir liste</a>
                                </small><br>
                            </p>
                            <hr>
                            <h6 class="dashboard">Utilisateurs à supprimer</h6>
                            <p>
                                <small class="text-muted">
                                    <span class="badge badge-danger"> <?= htmlspecialchars($nbUsersToDelete) ?> </span> utilisateur(s) à
                                    supprimer -
                                    <a class="articles-link" href="index.php?action=usersManager&value=trash">
                                        <i class="fa fa-eye"></i> voir liste</a></small><br>
                                <small class="text-muted">
                                    <span class="badge badge-danger"> <?= htmlspecialchars($nbUsersConnexionExpired) ?> </span>
                                    utilisateur(s) non connecté depuis 3 mois - <i
                                            class="fas fa-exclamation-triangle danger"></i>
                                    <a class="articles-link" href="index.php?action=delete&value=connexionExpired"
                                       onclick="return ConfirmMessageAdmin()">
                                        <i class="fa fa-trash"></i> purger la liste</a>
                                </small><br>
                            </p>
                            <hr>
                            <h6 class="dashboard">Tokens</h6>
                            <p>
                                <small class="text-muted">
                                    <span class="badge badge-warning"> <?= htmlspecialchars($nbUsersTokenNotValidate) ?> </span>
                                    utilisateur(s) n'ont pas validé leurs token -
                                    <a class="articles-link"
                                       href="index.php?action=usersManager&value=uncheckedTokenUsers">
                                        <i class="fa fa-eye"></i> voir liste</a> </small><br>
                                <small class="text-muted">
                                    <span class="badge badge-danger"> <?= htmlspecialchars($nbUsersTokenExpired) ?> </span> token(s)
                                    expiré(s) - <i class="fas fa-exclamation-triangle danger"></i>
                                    <a class="articles-link" href="index.php?action=delete&value=tokenExpired"
                                       onclick="return ConfirmMessageAdmin()">
                                        <i class="fa fa-trash"></i>
                                        purger la liste</a>
                                </small>
                            </p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">
                                <a class="nav-link" href="index.php?action=usersManager&value=all"><i
                                            class="fas fa-eye"></i> voir la liste des utilisateurs</a>
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
                                    <i class="fa fa-file-alt"></i> Coup d'oeil - Articles <span
                                            class="badge badge-success"><?= htmlspecialchars($nbPostTotal) ?></span>
                                </footer>
                            </blockquote>
                        </div>
                        <div class="card-body articles-caption">
                            <h6 class="dashboard">Articles(ajout/validation/suppression)</h6>
                            <p>
                                <small class="text-muted">
                                    * ajouter un article -
                                    <a class="articles-link" data-toggle="modal" href="#formModalAddPost">
                                        <i class="fa fa-plus-square"></i> ajouter</a>
                                </small><br>
                                <small class="text-muted">
                                    <span class="badge badge-warning"><?= htmlspecialchars($nbPostsUnchecked) ?> </span>
                                    article(s) en attente de validation -
                                    <a class="articles-link" href="index.php?action=postsManager&value=uncheckedPosts">
                                        <i class="fa fa-history"></i> voir liste</a>
                                </small><br>
                                <small class="text-muted">
                                    <span class="badge badge-warning"><?= htmlspecialchars($nbPostsArchived) ?> </span>
                                    article(s) archivés -
                                    <a class="articles-link" href="index.php?action=postsManager&value=archived">
                                        <i class="fa fa-history"></i> voir liste</a>
                                </small><br>
                                <small class="text-muted">
                                    <span class="badge badge-danger"><?= htmlspecialchars($nbPostsToDelete) ?> </span> article(s) à
                                    supprimer - <i class="fas fa-exclamation-triangle danger"></i>
                                    <a class="articles-link" href="index.php?action=delete&value=postsToDelete"
                                       onclick="return ConfirmMessageAdmin()">
                                        <i class="fa fa-trash"></i>
                                        purger la liste</a>
                                </small>
                            </p>
                            <hr>
                            <canvas id="myChart"></canvas>
                            <hr>
                            <h6 class="dashboard">Commentaires</h6>
                            <p>
                                <small class="text-muted">
                                    <span class="badge badge-warning"><?= htmlspecialchars($nbCommentsUnchecked) ?> </span>
                                    commentaire(s) en attente de validation -
                                    <a class="articles-link" href="index.php?action=commentsManager">
                                        <i class="fa fa-history"></i> voir liste</a>
                                </small><br>
                                <small class="text-muted">
                                    <span class="badge badge-danger"><?= htmlspecialchars($nbCommentsToDelete) ?> </span> commentaire(s) à
                                    supprimer - <i class="fas fa-exclamation-triangle danger"></i>
                                    <a class="articles-link" href="index.php?action=commentsManager&CRUD=D"
                                       onclick="return ConfirmMessageAdmin()">
                                        <i class="fa fa-trash"></i>
                                        purger la liste</a>
                                </small>
                            </p>
                            <hr>
                            <h6 class="dashboard">Portfolio</h6>
                            <p>
                                <small class="text-muted">
                                    <a class="articles-link" href="index.php?action=portfolioManager">
                                        <i class="fa fa-copy"></i> voir le portfolio</a>
                                </small><br>
                            </p>
                            <hr>
                                <!--<small class="text-muted chart-wrapper">

                                </small>-->
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">
                                <a class="nav-link" href="index.php?action=postsManager&value=all"><i
                                            class="fas fa-eye"></i> voir la liste des articles</a>
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
                                <form id="formDataUser" action="index.php?action=usersManager&value=all&CRUD=C"
                                      method="post" onsubmit="return verifForm(this)">
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
                                                ?>
                                                <option value="<?= htmlspecialchars($key) ?>"><?= htmlspecialchars($value) ?></option>
                                            <?php
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
                                                ?>
                                                <option value="<?= htmlspecialchars($key) ?>"><?= htmlspecialchars($value) ?></option>
                                            <?php
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
                                <form id="formDataUser" action="index.php?action=postsManager&value=all&CRUD=C"
                                      method="post">
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
                                            <span class="input-group-text" id="basic-addon1"><i
                                                        class="fas fa-caret-right"></i></span>
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
                                        <label for="content"></label><textarea class="form-control" id="summernote"
                                                                               rows="5" name="content"
                                                                               placeholder="entrez le contenu de l'article ici"
                                                                               required></textarea>
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
                                                ?>
                                                <option value="<?= htmlspecialchars($category->getId()) ?>"><?= htmlspecialchars($category->getCategory()) ?></option>
                                            <?php
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
                                                ?>
                                                <option value="<?= htmlspecialchars($key) ?>"><?= htmlspecialchars($value) ?></option>
                                            <?php
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.js" integrity="sha512-b3xr4frvDIeyC3gqR1/iOi6T+m3pLlQyXNuvn5FiRrrKiMUJK3du2QqZbCywH6JxS5EOfW0DY0M6WwdXFbCBLQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script src="/public/js/statistiques.js" type="text/javascript"></script>
    <script>
        var ctx = document.getElementById('myChart');
        var data = <?=$nbPostsByCategory?>;
        var labels = <?=$labelsCategories?>;
        
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: split_array(labels.label),
                datasets: [{
                    label: 'statistiques',
                    data: split_array(data),
                    backgroundColor: [
                        Radar_colors.green,
                        Radar_colors.blueprimary,
                        Radar_colors.navy,
                        Radar_colors.yellow,
                        Radar_colors.blue,
                        Radar_colors.purple,
                        Radar_colors.orange,
                        Radar_colors.lightgreen,
                        Radar_colors.lightblueprimary,
                        Radar_colors.lightnavy,
                        Radar_colors.lightyellow,
                        Radar_colors.lightblue,
                        Radar_colors.lightpurple,
                        Radar_colors.lightorange,
                        Radar_colors.darkgreen,
                        Radar_colors.darkblueprimary,
                        Radar_colors.darknavy,
                        Radar_colors.darkyellow,
                        Radar_colors.darkblue,
                        Radar_colors.darkpurple,
                        Radar_colors.darkorange
                    ],
                    borderColor: [
                        Radar_border_colors.green,
                        Radar_border_colors.blueprimary,
                        Radar_border_colors.navy,
                        Radar_border_colors.yellow,
                        Radar_border_colors.blue,
                        Radar_border_colors.purple,
                        Radar_border_colors.orange,
                        Radar_border_colors.lightgreen,
                        Radar_border_colors.lightblueprimary,
                        Radar_border_colors.lightnavy,
                        Radar_border_colors.lightyellow,
                        Radar_border_colors.lightblue,
                        Radar_border_colors.lightpurple,
                        Radar_border_colors.lightorange,
                        Radar_border_colors.darkgreen,
                        Radar_border_colors.darkblueprimary,
                        Radar_border_colors.darknavy,
                        Radar_border_colors.darkyellow,
                        Radar_border_colors.darkblue,
                        Radar_border_colors.darkpurple,
                        Radar_border_colors.darkorange
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    },
                }
            }
        });
    </script>
<?php
endif;
?>
