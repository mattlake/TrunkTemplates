<?php

// require_once './Controllers/BlogPostController.php';
// require_once './TrunkTemplates.php';

// $bc = new BlogPostController();
// $template = new TrunkTemplates();
// $template->entries = $bc->entries;
// $template->templateFile = "sampleTemplate.mj";
// echo $template->generateMarkup();

require_once './Template.php';

$t = new TrunkTemplates\Template();

$template = 'sampleTemplate';
$testObject = new stdClass();
$testObject->name = 'This is the property name';
$testObject->age = 37;
$data = [
    'title' => 'Sample Template Usage',
    'string' => 'this is a string',
    'int' => 4,
    'array' => ['item1', 'item2', 'item3'],
    'users' => ['David', 'John', 'Mary', 'Christine'],
    'orgs' => ['google', 'apple', 'Microsoft'],
    'assoc' => ['name' => 'Matthew', 'age' => 37],
    'object' => $testObject,
];


$t->render($template, $data);
