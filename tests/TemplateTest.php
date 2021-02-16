<?php

require_once __DIR__ . '/../Template.php';

it('can be initiated', function () {
    $template = new \Trunk\Template();
    expect($template)->toBeInstanceOf(\Trunk\Template::class);
});
