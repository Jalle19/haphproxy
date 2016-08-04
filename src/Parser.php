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
		$configuration  = new Configuration();
		$currentSection = null;

		// Parse the preface
		$configuration->setPreface($this->parsePreface());

		foreach ($this->getNormalizedConfigurationLines() as $line) {
			// Check for section changes
			$newSection = Factory::makeFactory($line);

			if ($newSection !== null) {
				$currentSection = $newSection;
				$configuration->addSection($currentSection);

				continue;
			}

			// Parse the current section line by line
			if ($currentSection !== null) {
				$this->parseSectionLine($currentSection, $line);
			}
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
			$line = $this->normalizeLine($line);

			if (!empty($line)) {
				yield $line;
			}
		}
	}


	/**
	 * @param string $line
	 *
	 * @return string
	 */
	private function normalizeLine($line)
	{
		return preg_replace('/\s+/', ' ', trim($line));
	}


	/**
	 * @param string $line
	 *
	 * @return bool if the line is a comment
	 */
	private function isComment($line)
	{
		return substr($line, 0, 1) === '#';
	}


	/**
	 * @param string $line
	 *
	 * @return bool whether the line is a magic comment
	 */
	private function isMagicComment($line)
	{
		return substr($line, 0, strlen(self::MAGIC_COMMENT_PREFIX)) === self::MAGIC_COMMENT_PREFIX;
	}


	/**
	 * @return string
	 */
	private function parsePreface()
	{
		$preface = '';

		foreach ($this->getNormalizedConfigurationLines() as $line) {
			if ($this->isComment($line)) {
				$preface .= $line . PHP_EOL;
			} else {
				break;
			}
		}

		return $preface;
	}


	/**
	 * @param AbstractSection $section
	 * @param string          $line
	 */
	private function parseSectionLine($section, $line)
	{
		// Distinguish between parameters and magic comments
		if ($this->isMagicComment($line)) {
			$section->addMagicComment($this->parseMagicComment($line));
		} else if (!$this->isComment($line)) {
			$section->addParameter($this->parseParameter($line));
		}
	}


	/**
	 * @param string $line
	 *
	 * @return string
	 */
	private function parseMagicComment($line)
	{
		return trim(substr($line, strlen(self::MAGIC_COMMENT_PREFIX)));
	}


	/**
	 * @param string $line
	 *
	 * @return Parameter
	 */
	private function parseParameter($line)
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
