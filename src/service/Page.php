<?php


class Page
{
    public $label;

    public $value;

    public function __construct($label, $value)
    {
        $this->label = $label;
        $this->value = $value;
    }

    public function render(TemplateFactory $factory): string
    {
        $pageTemplate = $factory->createPageTemplate();

        $renderer = $factory->getRenderer();
        return $renderer->render($pageTemplate->render(), [
            'label' => $this->label,
            'value' => $this->value
        ]);
    }

}