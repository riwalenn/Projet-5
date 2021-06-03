<?php


class ViewTemplateRenderer implements TemplateRenderer
{

    public function render(string $templateString, array $arguments = []): string
    {
        extract($arguments);
        ob_start();
        eval( ' ?>' . $templateString  . '<?php ' );
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }
}