<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ml-auto">
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="index.php"><i class="fa fa-home"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="index.php#services">Compétences</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="index.php#portfolio">Portfolio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="index.php#about">A propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="index.php#team">Réseaux sociaux</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="index.php#contact">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="index.php?action=articlesListe&page=1">Articles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="ressources/pdf/CV_Bas_Riwalenn.pdf" download><i
                                class="fas fa-file-pdf"></i></a>
                </li>
                <li class="nav-item <?php if (isset($_SESSION['id'])) : ?> dropdown<?php endif; ?>">
                    <?php if ((isset($_SESSION['id'])) && ($_SESSION['role'] == 2)) : ?>
                        <a class="nav-link js-scroll-trigger <?php if (isset($_SESSION['id'])) : ?>dropdown-toggle"<?php endif; ?> href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user-ninja"></i></a>
                    <?php elseif((isset($_SESSION['id'])) && ($_SESSION['role'] == 1)) : ?>
                        <a class="nav-link js-scroll-trigger <?php if (isset($_SESSION['id'])) : ?>dropdown-toggle"<?php endif; ?> href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user-secret"></i></a>
                    <?php else : ?>
                        <a class="nav-link js-scroll-trigger" href="index.php?action=connexion"><i class="fas fa-users-cog"></i></a>
                    <?php endif; ?>
                    <?php if ((isset($_SESSION['id']))) : ?>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php if ($_SESSION['role'] == 2) : ?>
                            <a class="dropdown-item" href="index.php?action=dashboard">Voir profil</a>
                        <?php elseif ($_SESSION['role'] == 1) : ?>
                            <a class="dropdown-item" href="index.php?action=backendDashboard">Voir profil</a>
                        <?php endif; ?>
                        <div class="dropdown-divider"></div>
                        <a class="nav-link js-scroll-trigger deco" href="index.php?action=logoutUser">Se déconnecter</a>
                        <?php endif; ?>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>