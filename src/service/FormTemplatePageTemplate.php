<?php

class FormTemplatePageTemplate extends BasePageTemplate
{

    public function render(): string
    {
        $rendered = $this->labelTemplate->getTemplateLineString();

        $html = "<div class='two fields'>";
        $html .= "$rendered";
        $html .= "</div>";

        return $html;

    }
}