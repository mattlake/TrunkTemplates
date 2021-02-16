<?php

require_once __DIR__ . '/../Template.php';

it('can be initiated', function () {
    $template = new \Trunk\Template();
    expect($template)->toBeInstanceOf(\Trunk\Template::class);
});

it('can translate string', function () {
    $placeholder = '{* string *}';
    $expected = 'replaced';
    $data = [
        'string' => $expected,
    ];

    $template = new \Trunk\Template();
    $result = $template->translateString($placeholder, $data);

    expect($result)->toBe($expected);
});

it('can translate string with zero spaces in tag', function () {
    $placeholder = '{*string*}';
    $expected = 'replaced';
    $data = [
        'string' => $expected,
    ];

    $template = new \Trunk\Template();
    $result = $template->translateString($placeholder, $data);

    expect($result)->toBe($expected);
});

it('can translate string with multiple spaces spaces in tag', function () {
    $placeholder = '{*     string  *}';
    $expected = 'replaced';
    $data = [
        'string' => $expected,
    ];

    $template = new \Trunk\Template();
    $result = $template->translateString($placeholder, $data);

    expect($result)->toBe($expected);
});

it('can translate tag with paragraph of text', function () {
    $placeholder = '{* paragraph *}';
    $expected = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vitae magna non sapien accumsan cursus. Mauris vestibulum ut risus quis efficitur. Vestibulum sed elementum odio. Ut aliquet ante eu egestas elementum. Duis at sem quis elit commodo pellentesque sed vitae dui. Pellentesque vitae cursus augue. Aenean vitae est non orci euismod vestibulum. Sed ornare purus risus, id pharetra neque facilisis sit amet. Vivamus vitae iaculis augue. Donec eget laoreet tortor. Duis eu blandit neque. Praesent ornare viverra nulla, placerat posuere lorem pellentesque id. ';
    $data = [
        'paragraph' => $expected,
    ];

    $template = new \Trunk\Template();
    $result = $template->translateString($placeholder, $data);

    expect($result)->toBe($expected);
});

it('returns template if no tags are found', function () {
    $placeholder = 'string';
    $data = [
        'random' => 'Some random block of text',
    ];

    $template = new \Trunk\Template();
    $result = $template->translateString($placeholder, $data);

    expect($result)->toBe($placeholder);
});

it('returns template if there is no matching replacement', function () {
    $placeholder = '{* string *}';
    $data = ['number' => 123];

    $template = new \Trunk\Template();
    $result = $template->translateString($placeholder, $data);

    expect($result)->toBe($placeholder);
});
