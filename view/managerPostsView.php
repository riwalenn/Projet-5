<section class="page-profil" id="profil">
    <div class="container">
        <h1 class="titre-dashboard-admin">Liste des articles</h1>
        <div class="row d-flex justify-content-around">
            <div class="card-deck">
                <div class="card" id="profil_Dash">
                    <img src="../ressources/img/dashboard/users.jpg" class="img_users_dashboard"/>
                    <div class="card-header d-flex justify-content-between">
                        <blockquote class="blockquote mb-0">
                            <footer class="blockquote-footer" style="color: #00c0c7"><i class="fa fa-user"></i> Posts Manager</footer>
                        </blockquote>
                        <?= $errorMessage ?>
                    </div>
                    <div class="card-body articles-caption">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                                <li class="breadcrumb-item"><a href="index.php?action=backendDashboard">Tableau de bord</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a href="index.php?action=postsManager&value=<?= $value ?>"><?= $filArianne ?></a></li>
                            </ol>
                        </nav>
                        <table class="table table-striped">
                            <thead class="thead-light">
                            <tr>
                                <th></th>
                                <th>Titre</th>
                                <th>Auteur</th>
                                <th>Créé le</th>
                                <th>Modifié le</th>
                                <th>Categorie</th>
                                <th>Statut</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($postsList as $post) : ?>
                            <?php if ($post->getState() != 3): ?>
                            <form action="index.php?action=postsManager&value=<?= $value ?>&CRUD=U" method="post">
                                <?php else: ?>
                                <form action="index.php?action=postsManager&value=<?= $value ?>&CRUD=D" method="post">
                                    <?php endif; ?>
                                    <input type="hidden" name="id" value="<?= $post->getId() ?>">
                                    <tr>
                                        <td>
                                            <?php if ($post->getState() != 3): ?>
                                                <a data-toggle="modal" href="#formModalEdit<?= $post->getId() ?>"><i class="fa fa-edit"></i> Editer</a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $post->getTitle() ?></td>
                                        <td><?= $post->getPseudo() ?></td>
                                        <td><?= $post->getCreated_at() ?></td>
                                        <td><?= $post->getModified_at() ?></td>
                                        <td>
                                            <select name="id_category" class="form-control form-control-sm">
                                                <?php
                                                foreach ($categories as $category) :
                                                    $selected = '';
                                                    if ($post->getCategory()->getCategory() == $category->getCategory()) :
                                                        $selected = 'selected';
                                                    endif;
                                                    echo '<option value="' . $category->getId() .'" ' . $selected . '>' . $category->getCategory() .'</option>';
                                                endforeach;
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="state" class="form-control form-control-sm <?= $post->getStateClass() ?>">
                                                <?php
                                                foreach (Post::$listeStatut as $key => $valueSelect) :
                                                    $selected = '';
                                                    if ($post->getState() == $key) :
                                                        $selected = 'selected';
                                                    endif;
                                                    echo '<option value="' . $key .'" ' . $selected . '>' . $valueSelect .'</option>';
                                                endforeach;
                                                ?>
                                            </select>
                                        </td>
                                            <?php if ($post->getState() != 3) : ?>
                                                <td><button class="btn btn-primary adm-users" type="submit">Appliquer les modifications</button></td>
                                            <?php else: ?>
                                                <td><button class="btn btn-danger adm-users" type="submit">Supprimer le compte</button></td>
                                            <?php endif; ?>
                                    </tr>
                                </form>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <nav aria-label="...">
                            <ul class="pagination justify-content-end pagination-sm">
                                <?php
                                for ($i = 0; $i < $nbPages; $i++) {
                                    $j = $i + 1;
                                    if ($j == $pageCourante) :
                                        echo '<li class="page-item active">';
                                    else :
                                        echo '<li class="page-item">';
                                    endif;
                                    echo '<a class="page-link" href="index.php?action=postsManager&value=' . $value . '&page=' . $j . '">' . $j . '</a>';
                                    echo '</li>';
                                }
                                ?>
                            </ul>
                        </nav>
                    </div>
                    <div class="card-footer">
                        <blockquote class="blockquote mb-0 d-flex flex-row-reverse">
                            <small class="p-2"><i class="fa fa-trash danger"></i> <a class="articles-link" href="index.php?action=postsManager&value=trash">Corbeille</a></small>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>