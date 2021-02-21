<?php

namespace Trunk\Template;

class TemplateLoader
{
    private string $templateDirectory = '/views/';

    public function setTemplateDirectory(string $url): self
    {
        $this->templateDirectory = $url;
        return $this;
    }

    public function getTemplateDirectory(): string
    {
        return $this->templateDirectory;
    }
}
