<?php

class TrunkTemplates
{
    public $entries = [];
    public $templateFile;
    private $template;

    private function loadTemplate()
    {
        // Check for a custom template
        $template_file = 'Views/' . $this->templateFile;
        if (file_exists($template_file) && is_readable($template_file)) {
            $path = $template_file;
        } elseif (file_exists($default_file = 'Views/default.inc') && is_readable($default_file)) {
            $path = $default_file;
        } else {
            throw new Exception('No default template found');
        }

        $this->template = file_get_contents($path);
    }

    private function parseTemplate($extra = NULL)
    {
        $template = $this->template;

        //Remove any PHP-style comments from the template
        $comment_pattern = array('#/\*.*?\*/#s', '#(?<!:)//.*#');
        $template = preg_replace($comment_pattern, NULL, $template);

        //Extract the main entry loop from the file
        $pattern = '#.*{loop}(.*?){/loop}.*#is';
        $entry_template = preg_replace($pattern, "$1", $template);

        //Extract the header from the template if one exists
        $header = trim(preg_replace('/^(.*)?{loop.*$/is', "$1", $template));
        if ($header === $template) {
            $header = NULL;
        }

        //Extract the footer from the template if one exists
        $footer = trim(preg_replace('#^.*?{/loop}(.*)$#is', "$1", $template));
        if ($footer === $template) {
            $footer = NULL;
        }

        //Define a regex to match any template tag
        $tag_pattern = '/{(\w+)}/';

        //Curry the function that will replace the tags with entry data
        $callback = $this->_curry('TrunkTemplates::replace_tags', 2);

        //Process each entry and insert its values into the loop 
        $markup = NULL;
        for ($i = 0, $c = count($this->entries); $i < $c; ++$i) {
            $markup .= preg_replace_callback($tag_pattern, $callback(serialize($this->entries[$i])), $entry_template);
        }

        //If extra data was passed to fill in the header/footer, parse it here
        if (is_object($extra)) {
            foreach ($extra as $key => $props) {
                $$key = preg_replace_callback(
                    $tag_pattern,
                    $callback(serialize($extra->$key)),
                    $$key
                );
            }
        }

        //TODO: Return the formatted entries with the header and footer

        // TEMPORARY: return the template after comment removal
        return $header . $markup . $footer;
    }

    public function generateMarkup($extra = array())
    {
        $this->loadTemplate();
        return $this->parseTemplate($extra);
    }

    /** * A currying function * * Currying allows a function to be called incrementally. This means that if
     * a function accepts two arguments, it can be curried with only one
     * argument supplied, which returns a new function that will accept the
     * remaining argument and return the output of the original curried function
     * using the two supplied parameters.
     * 
     * Example: 
     * function add($a, $b) { return $a + $b; }
     * $func = $this->_curry('add', 2); 
     * $func2 = $func(1); // Stores 1 as the first argument of add() 
     * echo $func2(2); // Executes add() with 2 as the second arg and outputs 3
     * @param string $function The name of the function to curry
     * @param int $num_args The number of arguments the function accepts
     * @return mixed Function or return of the curried functio
     * */
    private function _curry($function, $num_args)
    {
        return function () use ($num_args, $function) {
            // Store the passed arguments in an array
            $args = func_get_args();

            // Execute the function if the right number of arguments were passed
            if (count($args) >= $num_args) {
                return call_user_func_array($function, $args);
            }

            // Return a new function with the arguments stored otherwise
            return function () use ($args, $function) {
                $a = func_get_args();
                $z = $args;
                $a = array_merge($z, $a);
                return call_user_func_array($function, $a);
            };
        };
    }

    /** * Replaces template tags with the corresponding entry data 
     * @param string $entry A serialized entry object
     * @param array $params Parameters for replacement
     * @param array $matches The match array from preg_replace_callback()
     * @return string The replaced template value
     * */
    public static function replace_tags($entry, $matches)
    {
        // Unserialize the object
        $entry = unserialize($entry);

        // Make sure the template tag has a matching array element
        if (property_exists($entry, $matches[1])) {
            // Grab the value from the Entry object
            return $entry->{$matches[1]};
        } else {
            // Otherwise, simply return the tag as is  
            return "{" . $matches[1] . "}";
        }
    }
}
