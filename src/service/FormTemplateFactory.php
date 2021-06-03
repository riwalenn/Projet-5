<?php

class FormTemplateFactory implements TemplateFactory
{

    public function createLabelTemplate(): LineTemplate
    {
        return new FormTemplateLineTemplate();
    }

    public function createLineTemplate(): LineTemplate
    {
        return new FormTemplateLineTemplate();
    }

    public function createPageTemplate(): PageTemplate
    {
        return new FormTemplatePageTemplate($this->createLabelTemplate());
    }

    public function getRenderer(): TemplateRenderer
    {
        return new ViewTemplateRenderer();
    }
}