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

it('returns template if there is no matching replacement', function () {
    $placeholder = '{* string *}';
    $data = ['number' => 123];

    $template = new \Trunk\Template();
    $result = $template->translateString($placeholder, $data);

    expect($result)->toBe($placeholder);
});
