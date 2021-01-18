<?php

declare(strict_types=1);

namespace TrunkTemplates;

class Template
{
    private string $viewsDir = 'Views/';
    private string $fileExtension = '.mj';
    private string $tagPattern = '/{\*\s*(\w+)\s*\*}/';
    private string $methodPattern = '/{\*\s*:(\w+)\((.*?)\)\s*\*}\s*(.*)\s*{\*\s*:(end\w+)\s*}/';
    private array $data = [];

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
        $this->data = $data;

        //Load template
        $tpl = $this->getTemplate($template);

        $tpl = $this->parse($tpl);

        echo $tpl;
    }


    // Recursive parse method

    private function parse($tpl, $data = null)
    {
        $data = $data ?? $this->data;


        // If Method, call method sending the 'body from between the tags'
        if (preg_match_all($this->methodPattern, $tpl, $methodData)) {
            $tpl = $this->parseMethods($methodData, $tpl);
        };

        // If printable then replace string

        $tpl = $this->parseVariables($tpl, $data);

        return $tpl;
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

    private function parseMethods(array $methodData, $tpl)
    {
        $count = count($methodData[0]);
        for ($i = 0; $i < $count; $i++) {
            $methodName = '_' . $methodData[1][$i];
            $methodArgs = $methodData[2][$i];
            $methodBody = $methodData[3][$i];

            // Does method exist?
            if (!method_exists($this, $methodName)) {
                throw new \Exception('Method does not exist');
            }

            // Call Method
            $res = $this->$methodName($methodArgs, $methodBody);
            $pattern = $methodData[0][$i];

            // Update $tpl
            $tpl = str_replace($methodData[0][$i], $res, $tpl);
        }

        return $tpl;
    }

    private function parseVariables($tpl, $data): string
    {
        $vars = preg_match_all($this->tagPattern, $tpl, $matches);

        // Match Variables
        foreach ($matches[1] as $tag) {
            if (array_key_exists($tag, $data)) {
                // Is the tag an array
                if (is_array($data[$tag])) {
                    $tpl = preg_replace('/{\*\s*' . $tag . '\s*\*}/', 'Error:' . $tag . ' is an array and cannot be parsed as a string', $tpl);
                    continue;
                } else {
                    $tpl = preg_replace('/{\*\s*' . $tag . '\s*\*}/', $data[$tag], $tpl);
                }
            }
        }
        return $tpl;
    }

    private function _foreach($args, $body)
    {
        preg_match('/(\w+)\s+as\s+(\w+)/', $args, $argsMatches);

        $iterable = $argsMatches[1];
        $item = $argsMatches[2];
        $parsed = '';

        foreach ($this->data[$iterable] as $v) {
            $parsed .= $this->parse($body, [$item => $v]);
        }

        return $parsed;
    }
}
