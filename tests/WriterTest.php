<?php

namespace Jalle19\HaPHProxy\Test;

use Jalle19\HaPHProxy\Configuration;
use Jalle19\HaPHProxy\Parameter\Parameter;
use Jalle19\HaPHProxy\Parser;
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


	/**
	 * Tests that indent handling works correctly
	 */
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


	/**
	 * Tests that eventual magic comments in sections are preserved in the dumped output
	 */
	public function testPreserveMagicComments()
	{
		$parser       = new Parser(__DIR__ . '/../resources/examples/magic_comments.cfg');
		$configuraton = $parser->parse();

		$writer   = new Writer($configuraton);
		$expected = <<<EOD
# Generated with Jalle19/haphproxy
global
    # HAPHPROXY_COMMENT this is the magic comment
    daemon

EOD;

		$this->assertEquals($expected, $writer->dump());
	}

}
