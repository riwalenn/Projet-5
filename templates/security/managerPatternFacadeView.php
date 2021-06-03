<section class="page-profil" id="profil">
    <div class="container dashboard">
        <h1 class="titre-dashboard-admin">Liste des labels - pattern de façade</h1>
        <div class="row d-flex justify-content-around">
            <div class="card-deck">
                <div class="card" id="profil_Dash">
                    <?= View::generateDashboardPictureTag("users", "Users management", "img_users_dashboard") ?>
                    <div class="card-header d-flex justify-content-between">
                        <blockquote class="blockquote mb-0">
                            <footer class="blockquote-footer" style="color: #00c0c7"><i class="fa fa-tools"></i> Test Pattern
                            </footer>
                        </blockquote>
                    </div>
                    <div class="card-body articles-caption">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                                <li class="breadcrumb-item"><a href="index.php?action=backendDashboard">Tableau de
                                        bord</a></li>
                                <li class="breadcrumb-item">
                                    <a class="dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?= $filArianne ?>
                                    </a>
                                </li>
                            </ol>
                        </nav>
                        <table>
                            <thead>
                            <th>Labels</th>
                            <th>Données rééls 2021</th>
                            <th>% 2021</th>
                            </thead>
                            <tbody>
                                <?php foreach ($document as $doc) : ?>
                                    <?= $doc ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!--<table>
                            <thead>
                            <th>Labels</th>
                            <th>Données rééls 2021</th>
                            <th>% 2021</th>
                            </thead>
                            <tbody>
                            <?php /*foreach ($datas as $data) : */?>
                            <tr>
                                <td><?/*= $data->getLabel() */?></td>
                                <td><?/*= $data->getValue() */?></td>
                                <td><?/*= $data->getValuePercent() */?></td>
                            </tr>
                            <?php /*endforeach; */?>
                            </tbody>
                        </table>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>