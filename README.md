# Clinch

Clinch is a lightweight, _no singing no dancing_ command line argument parser that acts as a 
wrapper to the `getopt` function native to PHP.

It provides a simple and friendly API that makes working with command line 
arguments a lot more pleasant.

### Installation

Clinch is installed via Composer by running the following

```
composer require olliesplayground/clinch
``` 

### Usage

Clinch is used in the following way

`example.php`

```
<?php

require_once 'vendor/autoload.php';

use Clinch\Options;

$options = new Options();

$option = $options->newOption('l');
$option->setLongName('locale');

$locale = $options->getOptionValue('l');

echo "Locale: $locale\n"

```

Then from the command line, this can be executed as so

```
php example.php -len
Locale: en
```

or

```
php example.php --locale=de
Locale: de
```

### API

#### Options Class

#### `newOption (string $shortName): Option`

Create a new Option and add it. Returns the new Option object

#### `addOption (Option $option, string $shortName): Option`

Add a new Option object

#### `optionExists (string $shortName): bool` 

Check whether an option exists

#### `getOptions (): array`

Get all Options objects

#### `getOption (string $shortName): ?Option`

Returns an Option if it exists, `null` otherwise

#### `getOptionValue (string $shortName)`

Gets the value of an option, if it has been provided via the command line

#### Option Class

#### `setShortName (string $shortName): Option`

Sets the short name of an option

#### `setLongName (string $longName): Option`

Sets the long name of an option

#### `setValue ($value): Option`

Sets the value of an option

#### `setType (int $type): Option`

Sets the type of an option, possible values are 

`Option::TYPE_FLAG` - the option is not expecting a value, if provided the value will be set to `true`  
`Option::TYPE_OPTIONAL` - the option is optional. This is the default setting  
`Option::TYPE_REQUIRED` - the option is required.  
 
#### `shortName (): string`

Get the short name

#### `longName (): ?string`

Get the long name. Will return `null` if not set.

#### `type (): int`

Get the type of an option

#### `value ()`

Get the value of an option, if it has been provided via the command line, `null` otherwise

#### `compileShortOption (): string` 

Creates the short options string as required by `getopt`

#### `compileLongOption (): array` 

Creates the long options array as required by `getopt`

#### `parseValues (array $values)`

Parses the values provided by `getopt`

#### `getValue ()` 

Gets the value for an option, if provided via the command line
