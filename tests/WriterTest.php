<?php

namespace Jalle19\HaPHProxy\Test;

use Jalle19\HaPHProxy\Configuration;
use Jalle19\HaPHProxy\Parameter\Parameter;
use Jalle19\HaPHProxy\Section\GlobalSection;
use Jalle19\HaPHProxy\Writer;

/**
 * Class WriterTest
 * @package Jalle19\HaPHProxy\Test
 */
class WriterTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * Tests that the preface can be changed
	 */
	public function testPreface()
	{
		$configuration = new Configuration();
		$configuration->setPreface('# TEST');

		$writer = new Writer($configuration);
		$this->assertEquals("# TEST\n", $writer->dump());
	}


	public function testIndent()
	{
		$configuration = new Configuration();
		$configuration->setPreface('# PREFACE');
		$section = new GlobalSection();
		$section->addParameter(new Parameter('foo', 'bar'));
		$configuration->addSection($section);

		$writer = new Writer($configuration);
		$writer->setIndent('INDENT');

		$expected = <<<EOD
# PREFACE
global
INDENTfoo bar


EOD;

		$this->assertEquals($expected, $writer->dump());
	}

}