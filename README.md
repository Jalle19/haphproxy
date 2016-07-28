# haphproxy-configuration-parser

haphproxy-configuration-parser is a PHP library which can parse and create HAproxy configuration files.

## Installation

Install via Composer:

```
composer require jalle19/haphproxy-configuration-parser
```

## Usage

This example reads an existing configuration file, parses it and dumps it back as a string:

```php
use Jalle19\HaPHProxy\Exception\FileNotFoundException;
use Jalle19\HaPHProxy\Parser;
use Jalle19\HaPHProxy\Exception\ParserException;
use Jalle19\HaPHProxy\Writer;
use Jalle19\HaPHProxy\Section;

// Create a parser
try {
	$parser = new Parser(__DIR__ . '/../resources/examples/config2.cfg');
} catch (FileNotFoundException $e) {
	die($e->getMessage());
}

// Parse the configuration
try {
	$configuration = $parser->parse();
} catch (ParserException $e) {
	die($e->getMessage());
}

// Dump the parsed configuration
$writer = new Writer($configuration);
echo $writer->dump();
```

This example shows how you can dynamically create a configuration:

```php
<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Jalle19\HaPHProxy\Configuration;
use Jalle19\HaPHProxy\Parameter\Parameter;
use Jalle19\HaPHProxy\Writer;
use Jalle19\HaPHProxy\Section;

// Create a configuration manually
$configuration = new Configuration();

$globalSection = new Section\GlobalSection();
$globalSection->addParameter(new Parameter('daemon'))
              ->addParameter(new Parameter('maxconns', 128));
$configuration->addSection($globalSection);

$defaultSection = new Section\DefaultSection();
$defaultSection->addParameter(new Parameter('mode', 'http'));
$configuration->addSection($defaultSection);

$writer = new Writer($configuration);
echo $writer->dump();

```

The above results in the following configuration being generated:

```
# Generated with Jalle19\haphproxy-configuration-parser
global
    daemon
    maxconns 128

defaults
    mode http

```

## Testing

The test suite leaves all the validation of the generated configurations to HAproxy itself, so in order to run the test 
suite you'll need to have `haproxy` in your path. To run the test suite, run `php vendor/bin/phpunit`.

There is a `Vagrantfile` shipped with the library which automatically provisions itself with all the required software.

## License

This library is licensed under the GNU General Public License 2 or newer
