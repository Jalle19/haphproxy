<?php

namespace Jalle19\HaPHProxy\Test;

use Jalle19\HaPHProxy\Configuration;
use Jalle19\HaPHProxy\Parser;
use Jalle19\HaPHProxy\Section\DefaultsSection;
use Jalle19\HaPHProxy\Section\FrontendSection;
use Jalle19\HaPHProxy\Writer;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class ConfigurationTest
 * @package Jalle19\HaPHProxy\Test
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * This test reads each of the configuration files in resources/, dumps them to a temporary file, then tells
	 * haproxy to validate it. If the process exits successfully, the test passes
	 *
	 * @dataProvider configurationProvider
	 */
	public function testParseDump($configurationPath)
	{
		// Parse the configuration
		$parser        = new Parser($configurationPath);
		$configuration = $parser->parse();

		// Dump the configuration to a temporary file
		$tempFilePath = tempnam(sys_get_temp_dir(), 'haphproxy-test');
		$writer       = new Writer($configuration);
		file_put_contents($tempFilePath, $writer->dump());

		// Tell haproxy to validate the configuration and check the output of the command
		$builder = new ProcessBuilder(['haproxy', '-f', $tempFilePath, '-c']);
		$process = $builder->getProcess();
		$process->run();

		$output = $process->getOutput();
		$this->assertTrue($process->isSuccessful());
		$this->assertEquals('Configuration file is valid', trim($output));
	}


	/**
	 * Tests that getSingleSection() and getMultipleSections() work properly
	 */
	public function testGetSections()
	{
		$configuration = new Configuration();
		$configuration->addSection(new DefaultsSection());
		$configuration->addSection(new FrontendSection('frontend frontend-1'));
		$configuration->addSection(new FrontendSection('frontend frontend-2'));
		$configuration->addSection(new FrontendSection('frontend frontend-3'));

		$this->assertNotNull($configuration->getDefaultsSection());
		$this->assertCount(3, $configuration->getFrontendSections());
	}


	/**
	 * @return array
	 */
	public function configurationProvider()
	{
		return [
			[__DIR__ . '/../resources/examples/example1.cfg'],
			[__DIR__ . '/../resources/examples/example2.cfg'],
		];
	}

}
