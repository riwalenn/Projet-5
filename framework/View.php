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
        $tag = "<picture>";
        foreach ($post->getCategories() as $category) {

            $tag .= '<source srcset="'. Constantes::PATH_IMG_RESSOURCES . 'categories/' . $category->getId() . Constantes::EXTENSION_WEBP . '" media="all">';
            $tag .=  '<img class="img-fluid d-block mx-auto" src="'. Constantes::PATH_IMG_RESSOURCES . 'categories/' . $category->getId() . Constantes::EXTENSION_PNG . '" alt="">';
        }
        $tag .= "</picture>";
        return $tag;
    }
}