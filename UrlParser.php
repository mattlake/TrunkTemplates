<?php

namespace Trunk;

require_once __DIR__ . '/UrlParser.php';

class UrlParser
{
    public static function formatTemplateDirectory(string $path): string
    {
        if (str_ends_with($path, '/')) {
            return $path;
        }
        return $path . '/';
    }

    public static function formatTemplateFilename(string $filename): string
    {
        if (str_ends_with($filename, '.mj')) {
            return $filename;
        }

        return $filename . '.mj';
    }
}
