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
}
