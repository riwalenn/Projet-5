<?php


class Constantes
{
    // ----------- _URL_
    const HTTP_RIWALENN                     = BASE_URL;
    const HTTPS_URL                             = 'https://';
    const WWW_RIWALENN                      = 'www.riwalennbas.com';

    // ----------- DOSSIERS
    const PATH_FOLDER_PUBLIC                = 'public/';
    const PATH_FOLDER_VENDOR                = 'vendor/';
    const PATH_FOLDER_TEMPLATES             = 'templates/';
    const PATH_FOLDER_TEMPLATES_FRONT       = 'templates/frontend/';
    const PATH_FOLDER_TEMPLATES_SECURITY    = 'templates/security/';

    // ----------- PICTURES CONSTANTES
    const PATH_IMG_RESSOURCES               = 'public/img/';
    const THUMBNAIL                         = '-thumb';
    const FULLIMG                           = '-full';
    const SMALLIMG                          = '-small';
    const EXTENSION_WEBP                    = '.webp';
    const EXTENSION_PNG                     = '.png';
    const EXTENSION_JPG                     = '.jpg';

    // ----------- USERS CONSTANTES
    const ROLE_AUTHOR                       = 3; //auteur
    const ROLE_USER                         = 2; //utilisateur
    const ROLE_ADMIN                        = 1; //admin

    const USER_PENDING_STATUS               = 0; //en attente
    const USER_PENDING_STATUS_MODO          = 1; //en attente validation modérateur
    const USER_STATUS_VALIDATED             = 2; //compte validé
    const USER_STATUS_DELETED               = 3; //compte à supprimer

    // ----------- POSTS CONSTANTES
    const POST_PENDING_STATUS               = 0; //en attente
    const POST_STATUS_VALIDATED             = 1; //article validé
    const POST_STATUS_ARCHIVED              = 2; //article archivé
    const POST_STATUS_DELETED               = 3; //article à supprimer

    // ----------- COMMENTARY CONSTANTES
    const COM_PENDING_STATUS                = 0; //en attente
    const COM_STATUS_VALIDATED              = 1; //commentaire validé
    const COM_STATUS_ARCHIVED               = 2; //commentaire archivé
    const COM_STATUS_DELETED                = 3; //commentaire à supprimer
}