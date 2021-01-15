<?php

class BlogPostController
{
    public $entries = [];

    public function __construct()
    {
        $this->entries[] = (object)['title' => 'Why Do Birds appear?', 'site' => 'www.google.co.uk', 'url' => 'http://www.google.co.uk'];
        $this->entries[] = (object)['title' => 'Look at that!', 'site' => 'www.xbox.com', 'url' => 'http://www.xbox.com'];
        $this->entries[] = (object)['title' => 'Authentic Builds', 'site' => 'www.php.net', 'url' => 'http://www.php.net'];
        $this->entries[] = (object)['title' => 'Churchill\'s Toilet', 'site' => 'www.ebay.co.uk', 'url' => 'http://www.ebay.co.uk'];
        $this->entries[] = (object)['title' => 'Why Do Birds appear?', 'site' => 'www.paypal.com', 'url' => 'http://www.paypal.com'];
    }
}
