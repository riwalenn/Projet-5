<section class="bg-light page-section" id="erreurs">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading text-uppercase">Erreur</h2>
                <h6 class="alert alert-warning"><?php echo  'Message d\'erreur : ' . $erreurMessage . ' (code : ' . $erreurCode . '), ligne ' . $erreurLine . ' dans le fichier ' . $erreurFile; ?></h6>
            </div>
        </div>
    </div>
</section>