<?php

require_once __DIR__ . '/../TemplateLoader.php';

use Trunk\Template\TemplateLoader;

it('can get the default template path', function () {
    $tl = new TemplateLoader();
    expect($tl->getTemplateDirectory())->toBe('/views/');
});

it('can get and set the template path', function () {
    $tl = new TemplateLoader();
    $tl->setTemplateDirectory('test/');
    expect($tl->getTemplateDirectory())->toBe('test/');
});

it('can get and set the template path and add missing trailing forward slash', function () {
    $tl = new TemplateLoader();
    $tl->setTemplateDirectory('test');
    expect($tl->getTemplateDirectory())->toBe('test/');
});
