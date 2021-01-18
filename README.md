# Trunk Templates

Trunk Templates is a lightweight view templating system for PHP.

- PHP7.4+

## Usage
```php
$t = new TrunkTemplates\Template();
```

## Configuration

### Set base views directory
Trunk Templates will set a default views directory of '/views/', this can be changed using setViewsDir():
```php
$t->setViewsDir('/resource/views/');
```

# Syntax
## Variables

The syntax for template variables is:
```php
{* variable *}
```
## Arrays
Array can be iterated through with the following syntax:
```php
{* :foreach(array as value) *}
    {* value *}
{* :endforeach *}
```

Associative arrays can be iterated through with the following syntax:
```php
{* :foreach(AssocArray as key => value) *}
    {* key *} has a vlue of {* value *}
{* :endforeach *}