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

	/**
	 * @var AbstractSection[]
	 */
	private $sections = [];


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
