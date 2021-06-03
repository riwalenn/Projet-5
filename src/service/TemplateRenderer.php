<?php


interface TemplateRenderer
{
    public function render(string $templateString, array $arguments = []): string;
}