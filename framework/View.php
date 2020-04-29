<?php


class View
{

    private $title;
    private $params;

    public function __construct($title)
    {
        $this->title = $title;
        $this->params = [];
    }

    public function addVariable($name, $value)
    {
        $this->params[$name] = $value;
    }

    public function render($path, $params = null)
    {
        if (!empty($params)) {
            $this->params = array_merge($this->params, $params);
        }

        $content = $this->renderContent($path);
        $title = $this->title;
        require TEMPLATE_PATH;
    }

    public function renderContent($path)
    {
        if (file_exists($path)) {
            extract($this->params);
            ob_start();

            require $path;

            return ob_get_clean();
        }
        throw new Exception("Mauvais paramètre renseigné ! => renderContent(path)");
    }

    static public function generatePictureTag($post)
    {
        $category = $post->getCategory();
        $tag = "<picture>";
        $tag .= '<source srcset="'. Constantes::PATH_IMG_RESSOURCES . 'categories/' . $category->getId() . Constantes::EXTENSION_WEBP . '" media="all">';
        $tag .=  '<img class="img-fluid d-block mx-auto" src="'. Constantes::PATH_IMG_RESSOURCES . 'categories/' . $category->getId() . Constantes::EXTENSION_PNG . '" alt="' . $category->getCategory() . '">';
        $tag .= "</picture>";
        return $tag;
    }

    static public function generatePortfolioPictureTag($folio)
    {
        $tag = "<picture>";
        $tag .= '<source srcset="'. Constantes::PATH_IMG_RESSOURCES . 'portfolio/' . $folio->getId() . Constantes::FULLIMG . Constantes::EXTENSION_WEBP . '" alt="' . $folio->getTitle() . '">';
        $tag .= '<img class="img-fluid d-block mx-auto" src="' . Constantes::PATH_IMG_RESSOURCES . 'portfolio/' . $folio->getId() . Constantes::FULLIMG . Constantes::EXTENSION_JPG . '" alt="' . $folio->getTitle() . '">';
        $tag .= "</picture>";
        return $tag;
    }

    static public function generatePortfolioThumbailTag($folio)
    {
        $tag = "<picture>";
        $tag .= '<source srcset="'. Constantes::PATH_IMG_RESSOURCES . 'portfolio/' . $folio->getId() . Constantes::THUMBNAIL . Constantes::EXTENSION_WEBP . '" alt="' . $folio->getTitle() . '">';
        $tag .= '<img class="img-fluid d-block mx-auto" src="' . Constantes::PATH_IMG_RESSOURCES . 'portfolio/' . $folio->getId() . Constantes::THUMBNAIL . Constantes::EXTENSION_JPG . '" alt="' . $folio->getTitle() . '">';
        $tag .= "</picture>";
        return $tag;
    }

    static public function generateDashboardPictureTag($name, $alt, $classe)
    {
        $tag = "<picture>";
        $tag .= '<source srcset="'. Constantes::PATH_IMG_RESSOURCES . 'dashboard/' . $name . Constantes::EXTENSION_WEBP . '" media="all" class="'. $classe .'">';
        $tag .=  '<img class="img-fluid d-block mx-auto ' . $classe . '" src="'. Constantes::PATH_IMG_RESSOURCES . 'dashboard/' . $name . Constantes::EXTENSION_PNG . '" alt="' . $alt . '">';
        $tag .= "</picture>";
        return $tag;
    }

    static public function generateDropdown($allValues, $manager)
    {
        $tag = "<div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdownMenuLink\">";
        foreach ($allValues as $key => $value) {
            $tag .= "<a class=\"dropdown-item\" href=\"index.php?action=".$manager."&value=" . $key . "\">" . $value . "</a>";
        }
        $tag .= "</div>";
        return $tag;
    }
}