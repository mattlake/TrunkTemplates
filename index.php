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
$data = [];
$data['title'] = 'Sample Template Usage';
$data['string'] = 'this is a string';
$data['int'] = 4;
$data['array'] = ['item1', 'item2', 'item3'];
$data['users'] = ['David', 'John', 'Mary', 'Christine'];
$data['orgs'] = ['google', 'apple', 'Microsoft'];


$t->render($template, $data);
