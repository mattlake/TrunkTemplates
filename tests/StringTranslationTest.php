<?php

require_once __DIR__ . '/../Template.php';

it('translates single tag', function () {
    $t = new TrunkTemplates\Template();
    $template = '{* string *}';
    $data = ['string' => 'replaced'];

    $result = $t->parse($template, $data);

    expect($result)->toEqual('replaced');
});

it('translates tag within longer string', function () {
    $t = new TrunkTemplates\Template();
    $template = 'Replacing the tag with {* string *}';
    $data = ['string' => 'replaced'];

    $result = $t->parse($template, $data);

    expect($result)->toEqual('Replacing the tag with replaced');
});

it('translates multiple identical tags', function () {
    $t = new TrunkTemplates\Template();
    $template = '{* string *} {* string *}';
    $data = ['string' => 'replaced'];

    $result = $t->parse($template, $data);

    expect($result)->toEqual('replaced replaced');
});


it('translates string with multiple tags', function () {
    $t = new TrunkTemplates\Template();
    $template = 'Replacing the tag with {* string *} and {* second *}';
    $data = ['string' => 'replaced', 'second' => 'here also'];

    $result = $t->parse($template, $data);

    expect($result)->toEqual('Replacing the tag with replaced and here also');
});

it('translates strings without whitespace', function () {

    $t = new TrunkTemplates\Template();
    $template = '{*string*}';
    $data = ['string' => 'replaced'];

    $result = $t->parse($template, $data);

    expect($result)->toEqual('replaced');
});

it('translates integers', function () {

    $t = new TrunkTemplates\Template();
    $template = '{*string*}';
    $data = ['string' => 5];

    $result = $t->parse($template, $data);

    expect($result)->toEqual('5');
});

it('translates floats', function () {

    $t = new TrunkTemplates\Template();
    $template = '{*string*}';
    $data = ['string' => 5.5];

    $result = $t->parse($template, $data);

    expect($result)->toEqual('5.5');
});
