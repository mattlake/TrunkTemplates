<?php

namespace Trunk;

require_once __DIR__ . '/src/Patterns.php';

class Template
{
    public function __construct()
    {
        // TODO create method
    }

    public function translateString(string $template, array $data): string
    {
        $pattern = \Trunk\Template\src\Patterns::get('string');
        preg_match($pattern, $template, $matches);

        if (empty($matches)) {
            return $template;
        }

        if (!array_key_exists($matches[1], $data)) {
            return $template;
        }
        return $data[$matches[1]];
    }
}
