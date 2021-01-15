<?php

require_once './Controllers/BlogPostController.php';
require_once './TrunkTemplates.php';

$bc = new BlogPostController();
$template = new TrunkTemplates();
$template->entries = $bc->entries;
$template->templateFile = "entrylist.mj";
$extra = (object) array('header' => (object) array('header_stuff' => 'Some extra content.'), 'footer' => (object) array('footerStuff' => 'More extra content.'));
echo $template->generateMarkup($extra);
