<?php

require_once __DIR__ . '/../src/Patterns.php';

it('fetches all patterns', function () {
    expect(\Trunk\Template\src\Patterns::all())->toBeArray();
});

it('fetches string pattern', function () {
    expect(\Trunk\Template\src\Patterns::get('string'))->toBe('/{\*\s*(\w+)\s*\*}/');
});

it('throws exception if called pattern does not exist', function () {
    \Trunk\Template\src\Patterns::get('sldkfj');
})->throws(\Exception::class);
