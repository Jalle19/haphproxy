# haphproxy

[![Build Status](https://travis-ci.org/Jalle19/haphproxy.svg?branch=master)](https://travis-ci.org/Jalle19/haphproxy)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Jalle19/haphproxy/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Jalle19/haphproxy/?branch=master)

haphproxy is a PHP library which can parse and create HAproxy configuration files.

The library operates on the configuration at a low level. A configuration is made up of sections (e.g. `global` and 
`default`). Each section is made up of parameters (e.g. `mode` and `timeout`). Each parameter has a value associated 
with it, e.g. a parameter named `timeout` can have a value of `timeout 30s`.

Since the library doesn't actually understand how HAproxy works, it is only guaranteed to generate syntactically valid 
configurations. For proper validation, please use `haproxy -f <configurationFile> -c`.

## Requirements

* PHP 5.6 or newer

## Installation

Install via Composer:

```
composer require jalle19/haphproxy
```

## Usage

### Reading a configuration

This example reads an existing configuration file, parses it and dumps it back as a string:

```php
<?php

require_once('vendor/autoload.php');

use Jalle19\HaPHProxy\Exception\FileNotFoundException;
use Jalle19\HaPHProxy\Parser;
use Jalle19\HaPHProxy\Writer;
use Jalle19\HaPHProxy\Section;

// Create a parser
try {
	$parser = new Parser('/etc/haproxy/haproxy.cfg');
} catch (FileNotFoundException $e) {
	die($e->getMessage());
}

// Parse and dump the configuration
$configuration = $parser->parse();
$writer = new Writer($configuration);

echo $writer->dump();
```

### Writing a configuration

This example shows how you can dynamically create a configuration:

```php
<?php

require_once('vendor/autoload.php');

use Jalle19\HaPHProxy\Configuration;
use Jalle19\HaPHProxy\Parameter\Parameter;
use Jalle19\HaPHProxy\Writer;
use Jalle19\HaPHProxy\Section;

$configuration = new Configuration();

// Add a global section
$globalSection = new Section\GlobalSection();
$globalSection->addParameter(new Parameter('daemon'))
              ->addParameter(new Parameter('maxconns', 128));
$configuration->addSection($globalSection);

// Add a defaults section
$defaultSection = new Section\DefaultSection();
$defaultSection->addParameter(new Parameter('mode', 'http'));
$configuration->addSection($defaultSection);

// Dump the configuration
$writer = new Writer($configuration);
echo $writer->dump();

```

The above results in the following configuration being generated:

```
# Generated with Jalle19\haphproxy
global
    daemon
    maxconns 128

defaults
    mode http

```

### Inspecting a configuration

You can access the individual parameters of each section like this:

```php
// Make a section with some parameters
$section = new Section\DefaultSection();
$section->addParameter(new Parameter('mode', 'http'));
$section->addParameter(new Parameter('timeout', 'client 30s'));
$section->addParameter(new Parameter('timeout', 'connect 30s'));
$section->addParameter(new Parameter('timeout', 'server 30s'));

// Get the value of a single parameter
$modeParameter = $section->getParameter('mode');
$mode = $modeParameter->getValue();

// Loop through all the "timeout" parameters
foreach ($section->getParametersByName('timeout') as $timeoutParameter) {

}
```

## Testing

The test suite leaves all the validation of the generated configurations to HAproxy itself, so in order to run the test 
suite you'll need to have `haproxy` in your path. To run the test suite, run `php vendor/bin/phpunit`.

There is a `Vagrantfile` shipped with the library which automatically provisions itself with all the required software.

## License

This library is licensed under the GNU General Public License 2 or newer
