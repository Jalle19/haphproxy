<?php

namespace Jalle19\HaPHProxy\Test\Section;

use Jalle19\HaPHProxy\Parameter\Parameter;

/**
 * Class SectionTest
 * @package Jalle19\HaPHProxy\Test\Section
 */
class SectionTest extends \PHPUnit_Framework_TestCase
{

	public function testParameters()
	{
		$section = new DummySection();

		$section->addParameter(new Parameter('foo', 'bar'));
		$this->assertCount(1, $section->getParameters());
		$this->assertTrue($section->hasParameter('foo'));
		$this->assertFalse($section->hasParameter('bar'));
		$this->assertEquals('bar', $section->getParameterByName('foo')->getValue());
		$this->assertNull($section->getParameterByName('bar'));

		$section->addParameter(new Parameter('qux', 'baz'));
		$this->assertCount(2, $section->getParameters());
		$this->assertCount(1, $section->getParametersByName('foo'));
	}

}
