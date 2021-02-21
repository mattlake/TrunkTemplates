<?php

require_once __DIR__ . '/../UrlParser.php';

use Trunk\UrlParser;

it('adds trailing slash to template directory string if missing', function () {
    expect(UrlParser::formatTemplateDirectory('directory'))->toBe('directory/');
});

it('does not add traling slash if the template directory already contains one', function () {
    expect(UrlParser::formatTemplateDirectory('directory/'))->toBe('directory/');
});

it('adds .mj extension to template filenames if not provided', function () {
    expect(UrlParser::formatTemplateFilename('template'))->toBe('template.mj');
});

it('does not add extension to template filename if already present', function () {
    expect(UrlParser::formatTemplateFilename('template.mj'))->toBe('template.mj');
});
