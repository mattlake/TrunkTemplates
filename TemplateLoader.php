<?php

namespace Trunk\Template;

use Trunk\UrlParser;

class TemplateLoader
{
    private string $templateDirectory = '/views/';

    public function setTemplateDirectory(string $url): self
    {
        $this->templateDirectory = UrlParser::formatTemplateDirectory($url);
        return $this;
    }

    public function getTemplateDirectory(): string
    {
        return $this->templateDirectory;
    }

    public function loadTemplate(string $filename): string
    {
        $file = file_get_contents($this->getTemplateDirectory() . $filename);
        return $file;
    }
}
