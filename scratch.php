<?php

require_once './Models/BlogPosts.php';

$reflector = new ReflectionClass("BlogPost");

foreach ($reflector->getMethod('add')->getParameters() as $param) {
    // param name
    var_dump($param->name);

    // param type hint (or null, if not specified).
    var_dump($param->getType()->getName());

    // finds out if the param is required or optional
    var_dump($param->isOptional());
}
