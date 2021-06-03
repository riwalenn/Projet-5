<?php

abstract class BasePageTemplate implements PageTemplate
{
    protected $labelTemplate;

    public function __construct(LineTemplate $labelTemplate)
    {
        $this->labelTemplate = $labelTemplate;
    }
}