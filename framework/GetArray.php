<?php


class GetArray
{
    public function userManagerList()
    {
        return [
            "all"                   => "Tous les utilisateurs",
            "uncheckedUsers"        => "Utilisateurs à valider",
            "uncheckedTokenUsers"   => "Tokens non validés",
            "referents"             => "Utilisateurs référents",
            "trash"                 => "Comptes à supprimer"
        ];
    }

    public function postManagerList()
    {
        return [
            "all"               => "Tous les articles",
            "uncheckedPosts"    => "Articles à valider",
            "checkedPosts"      => "Articles validés",
            "archived"          => "Articles archivés",
            "trash"             => "Articles à supprimer"
        ];
    }

    public function commentManagerList()
    {
        return [
            "all"               => "Tous les commentaires",
            "uncheckedComments"    => "Commentaires à valider",
            "checkedComments"      => "Commentaires validés",
            "archived"          => "Commentaires archivés",
            "trash"             => "Commentaires à supprimer"
        ];
    }

    public function categoriesFolioManagerList()
    {
        $manager = new FolioCategoriesColorManager();
        $array = $manager->getFolioCategoriesColors();

            $html = '<select name="categories" id="sel-bs" class="mdb-select md-form selectpicker" multiple>';

            foreach ($array as $value) {
                $html .= '<option value="'. $value["id"] .'">'. $value["category"] .'</option>';
            }

            $html .= '</select>';

        return $html;
    }

    /**
     * @param $array
     * @return string
     */
    public function convert_multi_array($array) {
        $out = implode(",",array_map(function($a) {return implode("~",$a);},$array));

        return $out;
    }
}