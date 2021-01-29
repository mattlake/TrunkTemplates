<?php

declare(strict_types=1);

namespace TrunkTemplates;

class Template
{
    private string $viewsDir = 'Views/';
    private string $fileExtension = '.mj';
    private string $tagPattern = '/{\*\s*(\w+)\s*\*}/';

    private string $objectPattern = '/{\*\s*(\w+)(?:->)(\w+)\(?(.*?)\)?\s+\*}/';
    private array $data = [];
    private string $forEachPattern = '/{\*\s*:foreach\((.*?)\)\s\*}(.*?){\*\s*:endforeach\s\*}/';

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

        // Parse Template
        $tpl = $this->parse($tpl);

        echo $tpl;
    }


    // Recursive parse method

    public function parse($tpl, $data = null)
    {
        $data = $data ?? $this->data;

        $this->parseMethods($tpl, $data);

        // Do we have any objects?
        // if (preg_match_all($this->objectPattern, $tpl, $objectMatches)) {
        //     $tpl = $this->handleObjects($objectMatches, $tpl);
        // }

        // // If printable then replace string
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

    private function handleObjects($data, $tpl)
    {
        preg_match_all($this->objectPattern, $tpl, $matches);
        $tally = count($matches[0]);

        for ($i = 0; $i < $tally; $i++) {
            $objName = $matches[1][$i];
            $objProp = $matches[2][$i];
            if (!empty($matches[3][$i])) {
                // We have a method call
                // TODO enable type checks in arguments 
                $args = explode(',', $matches[3][$i]);
                $this->parseArgs($args, $this->data[$objName], $objProp);

                $tpl = str_replace($matches[0][$i], $this->data[$objName]->$objProp(...$args), $tpl);
            } else {
                $tpl = str_replace($matches[0][$i], $this->data[$objName]->$objProp, $tpl);
            }
        }

        return $tpl;
    }

    private function parseArgs(&$args, $class, $method)
    {
        $reflector = new \ReflectionClass($class);
        $params = $reflector->getMethod($method)->getParameters();
        $newArgs = [];

        for ($i = 0; $i < count($params); $i++) {
            $name = $params[$i]->getName();

            if ($params[$i]->getType()) {
                $type =  $params[$i]->getType()->getName();
                settype($args[$i], $type);
            }
        }
    }

    private function parsemethods(&$tpl, $data)
    {
        $pattern = '/\B{\*\s:(\w+)(\((.*?)\))\s*\*}(.*?){\*\s*:end(\1)\s*\*}/s';
        preg_match_all($pattern, $tpl, $match);
        for ($i = 0; $i < count($match[0]); $i++) {
            $func = $match[1][$i];
            $args = $match[2][$i];
            $body = $match[3][$i];
            echo "<p>Found Method $func with arguments $args and a body of $body</p>";
        }
    }
}
