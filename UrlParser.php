<?php

namespace Trunk;

class UrlParser
{
    public static function formatTemplateDirectory(string $path): string
    {
        if (str_ends_with($path, '/')) {
            return $path;
        }
        return $path . '/';
    }
}
