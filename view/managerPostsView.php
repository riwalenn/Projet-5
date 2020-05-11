<section class="page-profil" id="profil">
    <div class="container dashboard">
        <h1 class="titre-dashboard-admin">Liste des articles</h1>
        <div class="row d-flex justify-content-around">
            <div class="card-deck">
                <div class="card" id="profil_Dash">
                    <?= View::generateDashboardPictureTag("posts", "Posts management", "img_posts_dashboard") ?>
                    <div class="card-header d-flex justify-content-between">
                        <blockquote class="blockquote mb-0">
                            <footer class="blockquote-footer" style="color: #00c0c7"><i class="fa fa-file-alt"></i> Posts Manager</footer>
                        </blockquote>
                        <?php if (preg_match('/Erreur/', $errorMessage)) : ?>
                            <small class="error-message"><?= $errorMessage ?></small>
                        <?php else: ?>
                            <small class="success-message"><?= $errorMessage ?></small>
                        <?php endif; ?>
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
                                     <?= View::generateDropdown($allValues, "postsManager") ?>
                                </li>
                            </ol>
                        </nav>
                        <table class="table table-striped">
                            <thead class="thead-light">
                            <tr>
                                <th></th>
                                <th>Id</th>
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
                                        <td><?= $post->getId() ?></td>
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
                                                <td><button class="btn btn-danger adm-users" type="submit">Supprimer l'article</button></td>
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
<!-- Modal modif Post -->
<?php foreach ($postsList as $post) : ?>
<div class="articles-modal modal fade" id="formModalEdit<?= $post->getId() ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                            <h5><i class="fa fa-pencil-alt"></i> Modifier un article</h5>
                            <form id="formDataUser" action="index.php?action=postsManager&value=all&CRUD=FU" method="post">
                                <input type="hidden" name="id" value="<?= $post->getId() ?>">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                        class="fas fa-caret-right"></i></span>
                                    </div>
                                    <input type="text" id="title" class="form-control form-control-sm"
                                           placeholder="entrez le titre ici" name="title" value="<?= $post->getTitle() ?>"
                                           aria-label="title" aria-describedby="basic-addon1"  required>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                        class="fas fa-caret-right"></i></span>
                                    </div>
                                    <input type="text" id="pseudo" class="form-control form-control-sm"
                                           placeholder="entrez le pseudo ici" name="pseudo" value="<?= $post->getPseudo() ?>"
                                           aria-label="pseudo" aria-describedby="basic-addon1"  disabled>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                        class="fas fa-caret-right"></i></span>
                                    </div>
                                    <input type="text" id="author" class="form-control form-control-sm" name="author" value="<?= $post->getAuthor() ?>">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-caret-right"></i></span>
                                    </div>
                                    <label for="content"></label><textarea class="form-control" id="kicker" rows="3" name="kicker" placeholder="entrez le contenu du châpo ici" required><?= $post->getKicker() ?></textarea>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                        class="fas fa-caret-right"></i></span>
                                    </div>

                                        <label for="content"></label><textarea class="form-control summernote" id="content" rows="10" name="content" placeholder="entrez le contenu de l'article ici" required><?= $post->getContent() ?></textarea>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                        class="fas fa-caret-right"></i></span>
                                    </div>
                                    <input type="text" id="url" class="form-control form-control-sm"
                                           placeholder="entrez le lien ici" name="url" value="<?= $post->getUrl() ?>"
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
                                            $selected = '';
                                            if ($post->getCategory()->getCategory() == $category->getCategory()) :
                                                $selected = 'selected';
                                            endif;
                                            echo '<option value="' . $category->getId() .'" ' . $selected . '>' . $category->getCategory() .'</option>';
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
                                        foreach (Post::$listeStatut as $key => $valueSelect) :
                                            $selected = '';
                                            if ($post->getState() == $key) :
                                                $selected = 'selected';
                                            endif;
                                            echo '<option value="' . $key .'" ' . $selected . '>' . $valueSelect .'</option>';
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                <button class="btn btn-primary my-2 my-sm-0" aria-label="ajouter" type="submit"
                                        value="add">Modifier un article
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>