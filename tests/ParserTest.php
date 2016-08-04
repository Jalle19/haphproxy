<?php

namespace Jalle19\HaPHProxy\Test;

use Jalle19\HaPHProxy\Parser;

/**
 * Class ParserTest
 * @package Jalle19\HaPHProxy\Test
 */
class ParserTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @expectedException \Jalle19\HaPHProxy\Exception\FileNotFoundException
	 */
	public function testFileNotFound()
	{
		new Parser('/nonexisting');
	}


	/**
	 * @expectedException \Jalle19\HaPHProxy\Exception\FileNotFoundException
	 */
	public function testFileFoundButUnreadable()
	{
		$filePath = tempnam(sys_get_temp_dir(), 'foo');

		touch($filePath);
		chmod($filePath, 0000);

		new Parser($filePath);
	}


	/**
	 * Tests that existing preface comments in configuration file are parsed correctly
	 */
	public function testParsePreface()
	{
		$parser        = new Parser(__DIR__ . '/../resources/examples/example3.cfg');
		$configuration = $parser->parse();

		$expected = <<<EOD
# Generated with Jalle19/haphproxy
EOD;

		$this->assertEquals($expected, $configuration->getPreface());
	}

}
