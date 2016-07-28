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

}
