<?php

namespace Jalle19\HaPHProxy;

use Jalle19\HaPHProxy\Section\AbstractSection;

/**
 * Class Configuration
 * @package Jalle19\HaPHProxy
 * @author  Sam Stenvall <sam.stenvall@nordsoftware.com>
 * @license GNU General Public License 2.0+
 */
class Configuration
{

	const DEFAULT_PREFACE = '# Generated with Jalle19/haphproxy';

	/**
	 * @var string
	 */
	private $preface = self::DEFAULT_PREFACE;

	/**
	 * @var AbstractSection[]
	 */
	private $sections = [];


	/**
	 * @return string
	 */
	public function getPreface()
	{
		return $this->preface;
	}


	/**
	 * Sets the preface. The specified preface will be trimmed.
	 *
	 * @param string $preface
	 */
	public function setPreface($preface)
	{
		$this->preface = trim($preface);
	}


	/**
	 * @param AbstractSection $section
	 */
	public function addSection(AbstractSection $section)
	{
		$this->sections[] = $section;
	}


	/**
	 * @return AbstractSection[]
	 */
	public function getSections()
	{
		return $this->sections;
	}

}
