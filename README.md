# Trunk Templates

Trunk Templates is a lightweight view templating system for PHP.

- PHP7.4+

## Usage

$t = new TrunkTemplates\Template();

## Configuration

### Set base views directory
Trunk Templates will set a default views directory of '/views/', this can be changed using setViewsDir():

$t->setViewsDir('/resource/views/');

# Syntax
## Variables

The syntax for template variables is {* variable *}

## Arrays
Array can be iterated through with the following syntax:
{* :foreach($array as $item)}
// Template to be parsed
{* :endforeach *}
