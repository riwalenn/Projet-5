<?php


interface TemplateFactory
{
    public function createLabelTemplate(): LineTemplate;
    public function createLineTemplate(): LineTemplate;
    public function createPageTemplate(): PageTemplate;
    public function getRenderer(): TemplateRenderer;
}