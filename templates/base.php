<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Blog personnel réalisé dans le cadre de ma formation développeur php/symfony">
    <meta name="author" content="Riwalenn Bas">
    <title><?= $title ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?= Constantes::PATH_FOLDER_VENDOR ?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet'
          type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">

    <!-- include summernote css -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= Constantes::PATH_FOLDER_PUBLIC ?>css/styleSheet.css" rel="stylesheet">
    <link href="<?= Constantes::PATH_FOLDER_PUBLIC ?>css/agency.min.css" rel="stylesheet">
    <!--<link href="public/css/chart.scss" rel="stylesheet">-->
</head>
<body class="container-fluid" id="page-top">
<?php include 'menu.php' ?>
<?= $content ?>

<?php include 'footer.php' ?>
<!-- Bootstrap core JavaScript -->
<script src="<?= Constantes::PATH_FOLDER_VENDOR ?>jquery/jquery.min.js"></script>
<script src="<?= Constantes::PATH_FOLDER_VENDOR ?>bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- include summernote js -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>

<!-- Plugin JavaScript -->
<script src="<?= Constantes::PATH_FOLDER_VENDOR ?>jquery-easing/jquery.easing.min.js"></script>

<!-- Contact form JavaScript -->
<script src="<?= Constantes::PATH_FOLDER_PUBLIC ?>js/jqBootstrapValidation.js"></script>
<script src="<?= Constantes::PATH_FOLDER_PUBLIC ?>js/contact_me.js"></script>

<!-- Custom scripts for this template -->
<script src="<?= Constantes::PATH_FOLDER_PUBLIC ?>js/agency.min.js"></script>
<script src="<?= Constantes::PATH_FOLDER_PUBLIC ?>js/verifForm.js"></script>
<script src="<?= Constantes::PATH_FOLDER_PUBLIC ?>js/summernote.js"></script>
<script src="<?= Constantes::PATH_FOLDER_PUBLIC ?>js/charts.js"></script>

</body>
</html>