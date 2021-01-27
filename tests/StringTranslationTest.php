<?php

require_once __DIR__ . '/../Template.php';

it('translates single tag', function () {
    $t = new TrunkTemplates\Template();
    $template = '{* string *}';
    $data = ['string' => 'replaced'];

    $result = $t->parse($template, $data);

    $this->assertSame('replaced', $result);
    unset($t);
    unset($template);
    unset($data);
    unset($result);
});

it('translates tag within longer string', function () {
    $t = new TrunkTemplates\Template();
    $template = 'Replacing the tag with {* string *}';
    $data = ['string' => 'replaced'];

    $result = $t->parse($template, $data);

    $this->assertSame('Replacing the tag with replaced', $result);
    unset($t);
    unset($template);
    unset($data);
    unset($result);
});

it('translates multiple identical tags', function () {
    $t = new TrunkTemplates\Template();
    $template = '{* string *} {* string *}';
    $data = ['string' => 'replaced'];

    $result = $t->parse($template, $data);

    $this->assertSame('replaced replaced', $result);
    unset($t);
    unset($template);
    unset($data);
    unset($result);
});


it('translates string with multiple tags', function () {
    $t = new TrunkTemplates\Template();
    $template = 'Replacing the tag with {* string *} and {* second *}';
    $data = ['string' => 'replaced', 'second' => 'here also'];

    $result = $t->parse($template, $data);

    $this->assertSame('Replacing the tag with replaced and here also', $result);
    unset($t);
    unset($template);
    unset($data);
    unset($result);
});

it('translates strings without whitespace', function () {
    $t = new TrunkTemplates\Template();
    $template = '{*string*}';
    $data = ['string' => 'replaced'];

    $result = $t->parse($template, $data);

    $this->assertSame('replaced', $result);
    unset($t);
    unset($template);
    unset($data);
    unset($result);
});
