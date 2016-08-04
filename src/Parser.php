<?php

namespace Jalle19\HaPHProxy;

use Jalle19\HaPHProxy\Exception\FileNotFoundException;
use Jalle19\HaPHProxy\Parameter\Parameter;
use Jalle19\HaPHProxy\Section\AbstractSection;
use Jalle19\HaPHProxy\Section\Factory;

/**
 * Class Parser
 * @package Jalle19\HaPHProxy
 * @author  Sam Stenvall <sam.stenvall@nordsoftware.com>
 * @license GNU General Public License 2.0+
 */
class Parser
{

	const MAGIC_COMMENT_PREFIX = '# HAPHPROXY_COMMENT';

	/**
	 * @var string
	 */
	private $filePath;


	/**
	 * Parser constructor.
	 *
	 * @param string $filePath
	 *
	 * @throws FileNotFoundException if the specified file could not be found or is not readable
	 */
	public function __construct($filePath)
	{
		if (!file_exists($filePath) || !is_readable($filePath)) {
			throw new FileNotFoundException($filePath . ' not found or is not readable');
		}

		$this->filePath = $filePath;
	}


	/**
	 * @return Configuration
	 */
	public function parse()
	{
		$configuration = new Configuration();
		$preface       = '';

		/* @var AbstractSection|null $currentSection */
		$currentSection = null;

		foreach ($this->getNormalizedConfigurationLines() as $line) {
			// Parse preface
			if ($currentSection === null && self::isComment($line)) {
				$preface .= $line . PHP_EOL;
			}

			// Omit empty lines
			if (empty($line)) {
				continue;
			}

			// Check for section changes
			$newSection = Factory::makeFactory($line);

			if ($newSection !== null) {
				$currentSection = $newSection;
				$configuration->addSection($currentSection);

				continue;
			}

			// Parse parameters into the current section
			if ($currentSection !== null) {
				// Distinguish between parameters and magic comments
				if (self::isMagicComment($line)) {
					$currentSection->addMagicComment(self::parseMagicComment($line));
				} else if (!self::isComment($line)) {
					$currentSection->addParameter(self::parseParameter($line));
				}
			}
		}

		if (!empty($preface)) {
			$configuration->setPreface($preface);
		}

		return $configuration;
	}


	/**
	 * Reads the configuration and yields one line at a time
	 *
	 * @return \Generator
	 */
	private function getConfigurationLines()
	{
		$handle = fopen($this->filePath, "r");

		while (($line = fgets($handle)) !== false) {
			yield $line;
		}
	}


	/**
	 * @return \Generator
	 */
	private function getNormalizedConfigurationLines()
	{
		foreach ($this->getConfigurationLines() as $line) {
			yield self::normalizeLine($line);
		}
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
	 * @return bool if the line is a comment
	 */
	private static function isComment($line)
	{
		return substr($line, 0, 1) === '#';
	}


	/**
	 * @param string $line
	 *
	 * @return bool whether the line is a magic comment
	 */
	private static function isMagicComment($line)
	{
		return substr($line, 0, strlen(self::MAGIC_COMMENT_PREFIX)) === self::MAGIC_COMMENT_PREFIX;
	}


	/**
	 * @param string $line
	 *
	 * @return string
	 */
	private static function parseMagicComment($line)
	{
		return trim(substr($line, strlen(self::MAGIC_COMMENT_PREFIX)));
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
