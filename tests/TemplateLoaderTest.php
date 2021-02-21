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

it('can load fie with full filename', function () {
    $tl = new TemplateLoader();
    $tl->setTemplateDirectory(__DIR__ . '/templates');
    expect($tl->loadTemplate('simple.mj'))->toBeString();
});

it('throws exception if template file is not found', function () {
    $tl = new TemplateLoader();
    $tl->setTemplateDirectory(__DIR__ . '/templates');
    expect($tl->loadTemplate('kjsklfjkdlsjfdsmlkfjdsmjvjnv.mj'))->toBeString();
})->throws(\Exception::class);;

it('formats the filename if necessary when loading a template', function () {
    $tl = new TemplateLoader();
    $tl->setTemplateDirectory(__DIR__ . '/templates');
    expect($tl->loadTemplate('simple'))->toBeString();
});

it('can load templates in subdirectories when / seperated', function () {
    $tl = new TemplateLoader();
    $tl->setTemplateDirectory(__DIR__);
    expect($tl->loadTemplate('./templates/simple'))->toBeString();
});
