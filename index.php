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


$t->render($template, $data);
