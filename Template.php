<?php

namespace Trunk;

require_once __DIR__ . '/src/Patterns.php';

class Template
{
    public function __construct()
    {
        // TODO create method
    }

    public function removeComments(string $template): string
    {
        $pattern = \Trunk\Template\src\Patterns::get('singleLineComment');
        return preg_replace($pattern, '', $template);
    }

    public function translateStrings(string $template, array $data): string
    {
        $pattern = \Trunk\Template\src\Patterns::get('string');
        preg_match_all($pattern, $template, $matches);

        if (empty($matches)) {
            return $template;
        }

        for ($i = 0; $i < count($matches[0]); $i++) {
            if (array_key_exists($matches[1][$i], $data)) {
                $template = str_replace($matches[0][$i], $data[$matches[1][$i]], $template);
            }
        }

        return $template;
    }

    public function parse(string $template, array $data): string
    {
        // Remove PHP Comments
        $template = $this->removeComments($template);

        // Translate strings
        $template = $this->translateStrings($template, $data);

        // Return result
        return $template;
    }
}
