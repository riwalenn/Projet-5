<?php

/**
 * Cette classe va contenir diverses fonctions utiles pour le debug.
 */
class Debug
{
    /**
     * Cette fonction affiche à l'écran le contenu intégral d'une variable.
     * @param mixed $var : La variable à afficher.
     * @param string $titre : Facultatif, a utiliser si on veut mettre un "titre" à l'affichage.
     */
    public static function printr($var, $titre=NULL) {
        if (!isset($var)) {
            echo ("Debug::printr : aucune variable définie.<br />");
        }
        if (empty($titre)) {
            echo ("<pre>");
        } else {
            echo ("<pre> $titre : \n");
        }
        print_r($var);
        echo ("</pre>");
    }

    /**
     * Cette fonction est un raccourci qui affiche à l'écran le contenu intégral de
     * $_REQUEST.
     */
    public static function pr() {
        self::printr($_REQUEST);
    }

    /**
     * Cette fonction affiche à l'écran le contenu d'une variable, et stoppe l'application
     * juste apres l'affichage.
     * @param mixed $var : La variable à afficher.
     * @param string $titre : Facultatif, à utiliser si on veut mettre un "titre" à l'affichage.
     */
    public static function dier($var, $titre = NULL) {
        Debug::printr($var, $titre);
        die ();
    }

    /**
     * Cette fonction affiche la pile des fonctions depuis l'endroit ou elle a été appelé. Cela permet de savoir
     * précisement ou l'on se trouve dans le code.
     * @param string $titre : Facultatif, a utiliser si on veut mettre un "titre" à l'affichage.
     */
    public static function printPile($titre = NULL) {
        $liste_fonction = debug_backtrace();
        $i = 0;
        echo ($titre . " : <br /> \n");
        foreach ($liste_fonction as $ligne) {
            if ($i != 0) { // On passe le premier affichage, car cela affiche "PrintFunctionStack"
                if (!isset($ligne['file'])) {
                    $ligne['file'] = 'fichier inconnu';
                }
                if (!isset($ligne['line'])) {
                    $ligne['line'] = 'inconnue';
                }
                echo '<strong>' . $ligne['function'] . '</strong> dans <em>' . $ligne['file'] . '</em> (ligne ' . $ligne['line'] . ") <br />\n";
            } else {
                $i++;
            }
        }
    }
}