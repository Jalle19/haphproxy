<?php

namespace Jalle19\HaPHProxy;

use Jalle19\HaPHProxy\Section\AbstractSection;
use Jalle19\HaPHProxy\Section\BackendSection;
use Jalle19\HaPHProxy\Section\DefaultsSection;
use Jalle19\HaPHProxy\Section\FrontendSection;
use Jalle19\HaPHProxy\Section\GlobalSection;
use Jalle19\HaPHProxy\Section\ListenSection;
use Jalle19\HaPHProxy\Section\Sections;

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
	 * Sets the preface. If the preface is empty after being trimmed, it won't be set.
	 *
	 * @param string $preface
	 */
	public function setPreface($preface)
	{
		// Don't override the default preface with an empty one
		$preface = trim($preface);

		if (!empty($preface)) {
			$this->preface = trim($preface);
		}
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


	/**
	 * @return GlobalSection|null
	 */
	public function getGlobalSection()
	{
		return $this->getSingleSection(Sections::SECTION_GLOBAL);
	}


	/**
	 * @return DefaultsSection|null
	 */
	public function getDefaultsSection()
	{
		return $this->getSingleSection(Sections::SECTION_DEFAULTS);
	}


	/**
	 * @return FrontendSection[]
	 */
	public function getFrontendSections()
	{
		return $this->getMultipleSections(Sections::SECTION_FRONTEND);
	}


	/**
	 * @return BackendSection[]
	 */
	public function getBackendSections()
	{
		return $this->getMultipleSections(Sections::SECTION_BACKEND);
	}


	/**
	 * @return ListenSection[]
	 */
	public function getListenSections()
	{
		return $this->getMultipleSections(Sections::SECTION_LISTEN);
	}


	/**
	 * @param string $type
	 *
	 * @return AbstractSection|null
	 */
	private function getSingleSection($type)
	{
		foreach ($this->sections as $section) {
			if ($section->getType() === $type) {
				return $section;
			}
		}

		return null;
	}


	/**
	 * @param string $type
	 *
	 * @return AbstractSection[]
	 */
	private function getMultipleSections($type)
	{
		$sections = [];

		foreach ($this->sections as $section) {
			if ($section->getType() === $type) {
				$sections[] = $section;
			}
		}

		return $sections;
	}

}
