<?php include 'header.html' ?>
    <!-- Services -->
    <section class="page-section" id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading text-uppercase">Compétences</h2>
                    <h3 class="section-subheading text-muted">Mes compétences en cours et à venir.</h3>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-4">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-primary"></i>
            <i class="fab fa-php fa-stack-1x fa-inverse"></i>
          </span>
                    <h4 class="service-heading">CSS3 / HTML5 / PHP7</h4>
                    <p class="text-muted">Créations de sites & applications avec les derniers languages.</p>
                </div>
                <div class="col-md-4">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-primary"></i>
            <i class="fas fa-laptop fa-stack-1x fa-inverse"></i>
          </span>
                    <h4 class="service-heading">Responsive Design</h4>
                    <p class="text-muted">Sites responsives avec Bootstrap et connaissance de Semantic UI.</p>
                </div>
                <div class="col-md-4">
          <span class="fa-stack fa-4x">
            <i class="fas fa-circle fa-stack-2x text-primary"></i>
            <i class="fab fa-wordpress fa-stack-1x fa-inverse"></i>
          </span>
                    <h4 class="service-heading">Wordpress</h4>
                    <p class="text-muted">Configuration, utilisation et intégration de thèmes dans Wordpress.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Grid -->
    <section class="bg-light page-section" id="portfolio">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading text-uppercase">Portfolio</h2>
                    <h3 class="section-subheading text-muted">Quelques projets sur lesquels j'ai travaillé.</h3>
                </div>
            </div>
            <div class="row">
                <?php foreach ($portfolio as $folio) { ?>
                    <div class="col-md-4 col-sm-6 portfolio-item">
                        <a class="portfolio-link" data-toggle="modal" href="#portfolioModal<?= $folio->getId() ?>">
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content">
                                    <i class="fas fa-plus fa-3x"></i>
                                </div>
                            </div>
                            <?= View::generatePortfolioPicture($folio, Constantes::FULLIMG) ?>
                        </a>
                        <div class="portfolio-caption">
                            <h4><?= $folio->getTitle() ?></h4>
                            <p class="text-muted"><?= $folio->getKicker() ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- About -->
    <section class="page-section" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading text-uppercase">A propos</h2>
                    <h3 class="section-subheading text-muted">Expériences professionnelles & formations.</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <ul class="timeline">
                        <li>
                            <div class="timeline-image">
                                <img class="rounded-circle img-fluid" src="ressources/img/about/1.jpg" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4>2019 - 2021</h4>
                                    <h4 class="subheading">Ilabs & OpenClassrooms</h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">Alternance développement d'applications php Symfony, diplôme
                                        niveau II - Perpignan</p>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-inverted">
                            <div class="timeline-image">
                                <img class="rounded-circle img-fluid" src="ressources/img/about/2.jpg" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4>2016 - 2017</h4>
                                    <h4 class="subheading">Association Apesac & CNED</h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">Responsable réseaux - Association APESAC & 1ère année BTS SIO
                                        SLAM</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="timeline-image">
                                <img class="rounded-circle img-fluid" src="ressources/img/about/3.jpg" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4>2011</h4>
                                    <h4 class="subheading">Constellation Network</h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">Intégratrice de sites internet pour Constellation</p>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-inverted">
                            <div class="timeline-image">
                                <img class="rounded-circle img-fluid" src="ressources/img/about/1.jpg" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4>2010</h4>
                                    <h4 class="subheading">L'idem</h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">Formation de webdéveloppement php</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="timeline-image">
                                <img class="rounded-circle img-fluid" src="ressources/img/about/2.jpg" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4>Depuis 1998...</h4>
                                    <h4 class="subheading">Informatique</h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">20 ans d'expérience en informatique.</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Team -->
    <section class="bg-light page-section" id="team">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading text-uppercase">Réseaux sociaux</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="team-member">
                        <img class="mx-auto rounded-circle" src="ressources/img/team/3.jpg" alt="">
                        <h4>Riwalenn Bas</h4>
                        <p class="text-muted">Développeuse d'applications junior</p>
                        <ul class="list-inline social-buttons">
                            <li class="list-inline-item">
                                <a href="https://www.linkedin.com/in/riwalennbas/">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="https://github.com/riwalenn">
                                    <i class="fab fa-github"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="ressources/pdf/CV_Bas_Riwalenn.pdf" download>
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <p class="large text-muted">Très peu présente sur les réseaux sociaux, je préfère m'adonner à mes
                        hobbies.</p>
                </div>
            </div>
            <div class="row competences">
                <div class="col-md-3 col-sm-6">
                    <img class="img-fluid d-block mx-auto" src="ressources/img/logos/responsive.jpg"
                         alt="Création de sites responsives">
                </div>
                <div class="col-md-3 col-sm-6">
                    <img class="img-fluid d-block mx-auto" src="ressources/img/logos/workbench.jpg"
                         alt="Conception UML et bdd">
                </div>
                <div class="col-md-3 col-sm-6">
                    <img class="img-fluid d-block mx-auto" src="ressources/img/logos/design.jpg"
                         alt="Connaissance de photoshop">
                </div>
                <div class="col-md-3 col-sm-6">
                    <img class="img-fluid d-block mx-auto" src="ressources/img/logos/PHP.jpg" alt="Php 7 / JQuery / JS">
                </div>
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section class="page-section" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading text-uppercase">Contact Us</h2>
                    <h3 class="section-subheading text-muted">Merci d'utiliser ce formulaire pour me contacter.</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form id="contactForm" name="sentMessage" onsubmit="return verifFormContact(this)"
                          novalidate="novalidate">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input class="form-control" id="name" type="text" placeholder="Votre nom *"
                                           required="required"
                                           data-validation-required-message="Veuillez entrer votre nom sans espace."
                                           onblur="verifName(this)">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" id="email" type="email" placeholder="Votre Email *"
                                           required="required"
                                           data-validation-required-message="Veuillez entrer votre email."
                                           onblur="verifEmail(this)">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" id="sujet" type="text" placeholder="Sujet du mail *"
                                           required="required"
                                           data-validation-required-message="Veuillez entrer un sujet .">
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea class="form-control" id="message" placeholder="Message *"
                                              required="required"
                                              data-validation-required-message="Veuillez entrer un message."></textarea>
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12 text-center">
                                <div id="success"></div>
                                <button id="sendMessageButton" class="btn btn-primary btn-xl text-uppercase"
                                        type="submit">Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Modals -->
<?php foreach ($portfolio as $folio) { ?>
    <div class="portfolio-modal modal fade" id="portfolioModal<?= $folio->getId() ?>" tabindex="-1" role="dialog"
         aria-hidden="true">
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
                                <!-- Project Details Go Here -->
                                <h2 class="text-uppercase"><?= $folio->getTitle() ?></h2>
                                <p class="item-intro text-muted"><?= $folio->getKicker() ?></p>
                                <?= View::generatePortfolioPicture($folio, Constantes::FULLIMG) ?>
                                <p><?= $folio->getContent() ?></p>
                                <ul class="list-inline">
                                    <li>Date de conception: <?= $folio->getDate_conception() ?></li>
                                    <li>Client: <?= $folio->getClient() ?></li>
                                    <li><p class="categories">Categorie(s):</p> <p id="variableAPasser<?= $folio->getId() ?>"><?= $folio->getCategoriesFormatted() ?></p>
                                    </li>
                                </ul>
                                <button class="btn btn-primary" data-dismiss="modal" type="button">
                                    <i class="fas fa-times"></i>
                                    Close Project
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>