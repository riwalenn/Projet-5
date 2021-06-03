<?php


class ViewTemplateFactory implements TemplateFactory
{

    public function createLabelTemplate(): LineTemplate
    {
        return new ViewTemplateLineTemplate();
    }

    public function createLineTemplate(): LineTemplate
    {
        return new ViewTemplateLineTemplate();
    }

    public function createPageTemplate(): PageTemplate
    {
        return new TableTemplatePageTemplate($this->createLabelTemplate());
    }

    public function getRenderer(): TemplateRenderer
    {
        return new ViewTemplateRenderer();
    }
}