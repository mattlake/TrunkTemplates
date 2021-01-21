# Trunk Templates

Trunk Templates is a lightweight view templating system for PHP.

- PHP7.4+

## Configuration

### Set base views directory

Trunk Templates will set a default views directory of '/views/', this can be changed using setViewsDir():

```php
$t->setViewsDir('/resource/views/');
```

## Syntax

### Usage

```php
// Create Template instance
$t = new TrunkTemplates\Template();

// Create data array to be passed to view
$data = [
    'title' => 'Sample Template Usage',
    'string' => 'this is a string',
    'int' => 4,
    'array' => ['item1', 'item2', 'item3'],
    'users' => ['David', 'John', 'Mary', 'Christine'],
    'orgs' => ['google', 'apple', 'Microsoft'],
    'assoc' => ['name' => 'Matthew', 'age' => 37],
];

// Render the view
$t->render('sampleTemplate, $data);
```

### Variables

The syntax for template variables is:

```php
{* variable *}
```

### Arrays

Array can be iterated through with the following syntax:

```php
{* :foreach(indexedArray as value) *}
    {* value *}
{* :endforeach *}
```

Associative arrays can be iterated through with the following syntax:

```php
{* :foreach(AssocArray as key => value) *}
    {* key *} has a vlue of {* value *}
{* :endforeach *}
```

### Object Syntax

Object properties can be called using the following syntax:

```php
{* object->name *}
```

Object methods can be called using the following syntax:

```php
{* object->add(3,2) *}
```

### Conditionals

If, else and elseif statments can be used with the following syntax:

```php
{* :if(x == y)*}
    {* ifString *}
{* :elseif(x === z)}
    {* elseifString *}
{* :else}
    {* fallbackString **}
{* :endif *}
```
