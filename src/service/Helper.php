<?php


class Helper
{
    static function helpPseudo()
    {
        $html = "Votre pseudo doit contenir au minimum 4 caractères, les caractères spéciaux sont interdits.";

        return $html;
    }

    static function helpPassword()
    {
        $html = "Voici quelques conseils pour vous aider à mieux sécuriser votre vie dématérialisée." . "<br>\n" .
            "- Utilisez un mot de passe <u>unique</u> pour chaque service. En particulier, l’utilisation d’un même " . "<br>\n" .
            "mot de passe entre sa messagerie professionnelle et sa messagerie personnelle est impérativement à proscrire ;" . "<br>\n" .
            "- Choisissez un mot de passe <u>qui n’a pas de lien avec vous</u> (mot de passe composé d’un nom de société," . "<br>\n" .
            "d’une date de naissance, etc.) ;" . "<br>\n" .
            "- Ne demandez <u>jamais</u> à un tiers de générer pour vous un mot de passe ;" . "<br>\n" .
            "- Modifiez systématiquement et au plus tôt les mots de passe par défaut lorsque les systèmes en contiennent ;" . "<br>\n" .
            "- <u>Renouvelez vos mots de passe avec une fréquence raisonnable</u>. Tous les 90 jours est un bon compromis" . "<br>\n" .
            "pour les systèmes contenant des données sensibles ;" . "<br>\n" .
            "- <u>Ne stockez pas</u> les mots de passe dans un fichier sur un poste informatique particulièrement exposé au risque" . "<br>\n" .
            "(exemple : en ligne sur Internet), encore moins sur un papier facilement accessible ;" . "<br>\n" .
            "- Ne vous envoyez pas vos propres mots de passe <u>sur votre messagerie personnelle</u> ;" . "<br>\n" .
            "- Configurez les logiciels, y compris votre navigateur web, <u>pour qu’ils ne se « souviennent » pas" . "<br>\n" .
            " des mots de passe choisis.</u>" . "<br>\n" .
            "<b>Votre mot de passe doit obligatoirement contenir :</b> " . "<br>\n" .
            "- des majuscules et minuscules," . "<br>\n" .
            "- des caractères spéciaux indiqués ci-après : @-_&*!%:;#~^" . "<br>\n" .
            "- les caractères tels que é,ç,+,à,è,`,(,),[,],{,},°,|,\,',\",/,?,\ et la , ne sont pas autorisés," . "<br>\n" .
            "- des chiffres," . "<br>\n" .
            "- il doit comporter au minimum 10 caractères et 64 au maximum.";

        return $html;
    }
}