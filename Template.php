<?php

declare(strict_types=1);

namespace TrunkTemplates;

class Template
{
    private string $viewsDir = 'Views/';
    private string $fileExtension = '.mj';
    private string $tagPattern = '/{\*\s*(\w+)\s*\*}/';

    public function __construct()
    {
    }

    public function setViewsDir(string $dir): self
    {
        // Check path ends with a /
        if (!$this->endsWith($dir, '/')) {
            $dir = $dir . '/';
        }

        $this->viewsDir = $dir;
        return $this;
    }

    public function setFileExtension(string $ext): self
    {
        // Check extension starts with .
        if (!$this->startsWith($ext, '.')) {
            $ext = '.' . $ext;
        }

        $this->fileExtension = $ext;
        return $this;
    }


    public function render(string $template, array $data)
    {
        //Load template
        $tpl = $this->getTemplate($template);

        // Get variables
        $vars = preg_match_all($this->tagPattern, $tpl, $matches);

        // Match Variables
        foreach ($matches[1] as $tag) {
            if (array_key_exists($tag, $data)) {
                $tpl = preg_replace('/{\*\s*' . $tag . '\s*\*}/', $data[$tag], $tpl);
            }
        }

        // Replace variables

        // echo page
        echo $tpl;
    }

    private function getTemplate(string $template)
    {
        // Build template path
        $path = $this->buildTemplatePath($template);

        // Check path exists
        if (!file_exists($path) || !is_readable($path)) {
            throw new \Exception('Unable to open file ' . $path);
        }

        return file_get_contents($path);
    }

    private function buildTemplatePath($template)
    {
        // Check template name for extension
        if (!$this->endsWith($template, $this->fileExtension)) {
            $template = $template . $this->fileExtension;
        }


        return $this->viewsDir . $template;
    }

    private function endsWith(string $haystack, string $needle): bool
    {
        $pattern = '/\\' . $needle . '$/';
        return (bool) preg_match($pattern, $haystack);
    }

    private function startsWith(string $haystack, string $needle): bool
    {
        $pattern = '/^\\' . $needle . '/';
        return (bool) preg_match($pattern, $haystack);
    }
}
