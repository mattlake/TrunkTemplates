<?php

namespace Trunk\Template\src;

class Patterns
{
    private static array $patterns = [
        'string' => '/{\*\s*(\w+)\s*\*}/',
    ];

    public static function all(): array
    {
        return self::$patterns;
    }

    public static function get(string $key): string
    {
        if (!array_key_exists($key, self::$patterns)) {
            throw new \Exception('Pattern does not exist');
        }

        return self::$patterns[$key];
    }
}
