<?php

require_once __DIR__ . '/../UrlParser.php';

use Trunk\UrlParser;

it('adds trailing slash to template directory string if missing', function () {
    expect(UrlParser::formatTemplateDirectory('directory'))->toBe('directory/');
});

it('does not add traling slash if the template directory already contains one', function () {
    expect(UrlParser::formatTemplateDirectory('directory/'))->toBe('directory/');
});
