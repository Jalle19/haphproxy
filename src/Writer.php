<?php

namespace Jalle19\HaPHProxy;

use Jalle19\HaPHProxy\Parameter\Parameter;

/**
 * Class Writer
 * @package Jalle19\HaPHProxy
 * @author Sam Stenvall <sam.stenvall@nordsoftware.com>
 * @license GNU General Public License 2.0+
 */
class Writer
{

	const DEFAULT_PREFACE = '# Generated with Jalle19/haphproxy';
	const DEFAULT_INDENT  = '    ';

	/**
	 * @var Configuration
	 */
	private $configuration;

	/**
	 * @var string
	 */
	private $preface = self::DEFAULT_PREFACE;

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
	 * @param string $preface
	 */
	public function setPreface($preface)
	{
		$this->preface = $preface;
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
		$configuration = $this->preface . PHP_EOL;

		foreach ($this->configuration->getSections() as $section) {
			$configuration .= $section->getName() . PHP_EOL;

			foreach ($section->getParameters() as $parameter) {
				$configuration .= $this->indent . $this->writeParameter($parameter) . PHP_EOL;
			}

			$configuration .= PHP_EOL;
		}

		return $configuration;
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
