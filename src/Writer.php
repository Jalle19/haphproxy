<?php

namespace Jalle19\HaPHProxy;

use Jalle19\HaPHProxy\Parameter\Parameter;
use Jalle19\HaPHProxy\Section\AbstractSection;
use Jalle19\HaPHProxy\Section\NamedSection;

/**
 * Class Writer
 * @package Jalle19\HaPHProxy
 * @author  Sam Stenvall <sam.stenvall@nordsoftware.com>
 * @license GNU General Public License 2.0+
 */
class Writer
{

	const DEFAULT_INDENT = '    ';

	/**
	 * @var Configuration
	 */
	private $configuration;

	/**
	 * @var string
	 */
	private $indent = self::DEFAULT_INDENT;


	/**
	 * Writer constructor.
	 *
	 * @param Configuration $configuration
	 */
	public function __construct(Configuration $configuration)
	{
		$this->configuration = $configuration;
	}


	/**
	 * @param Configuration $configuration
	 */
	public function setConfiguration($configuration)
	{
		$this->configuration = $configuration;
	}


	/**
	 * @param string $indent
	 */
	public function setIndent($indent)
	{
		$this->indent = $indent;
	}


	/**
	 * @return string the configuration as a string
	 */
	public function dump()
	{
		$configuration = $this->configuration->getPreface() . PHP_EOL;

		foreach ($this->configuration->getSections() as $section) {
			$configuration .= $this->writeSection($section);

			foreach ($section->getMagicComments() as $magicComment) {
				$configuration .= $this->indent . $this->writeMagicComment($magicComment) . PHP_EOL;
			}

			foreach ($section->getParameters() as $parameter) {
				$configuration .= $this->indent . $this->writeParameter($parameter) . PHP_EOL;
			}

			$configuration .= PHP_EOL;
		}

		// Ensure there's only one empty line in the end
		return trim($configuration) . PHP_EOL;
	}


	/**
	 * @param AbstractSection $section
	 *
	 * @return string
	 */
	private function writeSection(AbstractSection $section)
	{
		$output = $section->getType();

		if ($section instanceof NamedSection) {
			$output .= ' ' . $section->getName();
		}

		$output .= PHP_EOL;

		return $output;
	}


	/**
	 * @param string $magicComment
	 *
	 * @return string
	 */
	private function writeMagicComment($magicComment)
	{
		return Parser::MAGIC_COMMENT_PREFIX . ' ' . $magicComment;
	}


	/**
	 * @param Parameter $parameter
	 *
	 * @return string
	 */
	private function writeParameter(Parameter $parameter)
	{
		$value = $parameter->getValue();

		if ($value === null) {
			return $parameter->getName();
		}

		return $parameter->getName() . ' ' . $parameter->getValue();
	}

}
