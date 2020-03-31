<?php
if ((isset($_SESSION['id']))) :
    ?>
    <h1>Dashboard ADMIN</h1>
    <section class="page-profil" id="profil">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-6 card">
                    <img src="../ressources/img/dashboard/admin_profil.jpg" class="img_dashboard"/>
                    <div class="articles-caption">
                        <footer class="blockquote-footer"><b>Date d'inscription :</b> <?= $user->getDate_inscription() ?></footer>
                        <footer class="blockquote-footer"><b>Dernière connexion :</b> <?= $user->getDate_modification() ?></footer>
                        <h4>Bonjour <b><?= $user->getPseudo() ?></b></h4>
                        <p class="text-muted"><b>Votre email :</b> <?= $user->getEmail() ?><br>
                            <b>Role :</b> <?= $user->getRole() ?> - <b>Statut :</b> <?= $user->getState() ?><br>
                            <b>Id Session :</b> <?= $_SESSION['id'] ?><br>
                            <b>Votre email :</b> <?= $user->getEmail() ?>
                        </p>
                        <p class="text-muted"><a href="index.php?action=logoutUser">Deconnexion</a></p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 card">
                    <img src="../ressources/img/dashboard/articles.jpg" class="img_dashboard"/>
                    <div class="articles-caption">
                        <h4>...</h4>
                        <p class="text-muted"><b>... </b></p>
                        <footer class="blockquote-footer">...</footer>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 card">
                    <img src="../ressources/img/dashboard/social.jpg" class="img_dashboard"/>
                    <div class="articles-caption">
                        <h4>...</h4>
                        <p class="text-muted">...</p>
                    </div>
                </div>
            </div>
    </section>
    <section class="page-profil" id="profil">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-primary mb-3" style="max-width: 20rem;">
                        <div class="card-header"><b>Tableau de bord Admin</b></div>
                        <div class="card-body text-dark">
                            <div class="col-md-4">
                                  <span class="fa-stack fa-4x">
                                    <i class="fas fa-circle fa-stack-2x text-primary"></i>
                                    <i class="fas fa-user-astronaut fa-stack-1x fa-inverse"></i>
                                  </span>
                            </div>
                            <h5 class="card-title">Bonjour <b><?= $user->getPseudo() ?></b></h5>
                            <p class="card-text"><b>Votre role :</b> <?= $user->getRole() ?></b></p>
                            <p class="card-text"><b>Votre statut :</b> <?= $user->getState() ?></b></p>
                            <p class="card-text"><b>Id Session :</b> <?= $_SESSION['id'] ?></b></p>
                            <p class="card-text"><b>Votre email :</b> <?= $user->getEmail() ?></p>
                            <p class="card-text"><b>Date d'inscription :</b> <?= $user->getDate_inscription() ?></p>
                            <p class="card-text"><b>Dernière connexion :</b> <?= $user->getDate_modification() ?></p>
                            <p class="card-text"><a href="index.php?action=logoutUser">Deconnexion</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>