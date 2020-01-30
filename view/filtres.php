<div class="container">
    <div class="recherche">
        <form class="px-4 py-3 form-inline d-none d-sm-flex searchForm">
            <div class="row">
                <div class="dropdown">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="recherche" aria-label="recherche" aria-describedby="basic-addon3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <h6>FILTRER PAR CATEGORIE</h6>
                <p>Afficher les articles correspondant à toutes les catégories choisies :</p>
            </div>
            <ul class="list-group">
                <?php foreach ($categories as $category) {  ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input class="form-check-input position-static" type="checkbox" id="blankCheckbox" value="option1" aria-label="...">
                    </div><?= $category->getCategory() ?>
                </li>
                <?php } ?>
            </ul>
            <button type="submit" class="btn btn-secondary btn-sm">Rechercher</button>
        </form>
    </div>
</div>