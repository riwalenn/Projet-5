<?php


class TableTemplatePageTemplate extends BasePageTemplate
{

    public function render(): string
    {
        $renderedLabel = $this->labelTemplate->getTemplateLineString();

        $html = "$renderedLabel";
        return $html;

    }
}