<?php

namespace Jalle19\HaPHProxy;

use Jalle19\HaPHProxy\Exception\FileNotFoundException;
use Jalle19\HaPHProxy\Exception\ParserException;
use Jalle19\HaPHProxy\Parameter\Parameter;
use Jalle19\HaPHProxy\Section\BackendSection;
use Jalle19\HaPHProxy\Section\DefaultSection;
use Jalle19\HaPHProxy\Section\Factory;
use Jalle19\HaPHProxy\Section\FrontendSection;
use Jalle19\HaPHProxy\Section\GlobalSection;
use Jalle19\HaPHProxy\Section\ListenSection;
use Jalle19\HaPHProxy\Section\Sections;

/**
 * Class Parser
 * @package Jalle19\HaPHProxy
 * @author  Sam Stenvall <sam.stenvall@nordsoftware.com>
 * @license GNU General Public License 2.0+
 */
class Parser
{

	/**
	 * @var string
	 */
	private $filePath;


	/**
	 * Parser constructor.
	 *
	 * @param string $filePath
	 *
	 * @throws FileNotFoundException if the specified file could not be found
	 */
	public function __construct($filePath)
	{
		if (!file_exists($filePath)) {
			throw new FileNotFoundException($filePath . ' not found');
		}

		$this->filePath = $filePath;
	}


	/**
	 * @return Configuration
	 *
	 * @throws ParserException if the parsing fails
	 */
	public function parse()
	{
		$configuration  = new Configuration();
		$currentSection = null;

		foreach ($this->readConfigurationLines() as $line) {
			// Check for section changes
			$newSection = Factory::makeFactory($line);

			if ($newSection !== null) {
				$currentSection = $newSection;
				$configuration->addSection($currentSection);

				continue;
			}

			// Parse parameters into the current section
			if ($currentSection !== null) {
				$currentSection->addParameter(self::parseParameter($line));
			}
		}

		return $configuration;
	}


	/**
	 * @return array the normalized configuration lines
	 *
	 * @throws ParserException if the configuration file could not be read
	 */
	private function readConfigurationLines()
	{
		$handle = fopen($this->filePath, "r");

		if (!$handle) {
			throw new ParserException('Unable to parse ' . $this->filePath . ', could not open file handle');
		}

		$lines = [];

		while (($line = fgets($handle)) !== false) {
			$line = self::normalizeLine($line);

			if (self::shouldOmitLine($line)) {
				continue;
			}

			$lines[] = $line;
		}

		return $lines;
	}


	/**
	 * @param string $line
	 *
	 * @return string
	 */
	private static function normalizeLine($line)
	{
		return preg_replace('/\s+/', ' ', trim($line));
	}


	/**
	 * @param string $line
	 *
	 * @return bool
	 */
	private static function shouldOmitLine($line)
	{
		if (substr($line, 0, 1) === '#') {
			return true;
		}

		if (empty($line)) {
			return true;
		}

		return false;
	}


	/**
	 * @param string $line
	 *
	 * @return Parameter
	 */
	private static function parseParameter($line)
	{
		$words = explode(' ', $line, 2);

		if (count($words) > 1) {
			list($name, $value) = $words;

			return new Parameter($name, $value);
		}

		list($name) = $words;

		return new Parameter($name);
	}

}
