<?php

namespace Jalle19\HaPHProxy\Section;

/**
 * Class NamedSection
 * @package Jalle19\HaPHProxy\Section
 * @author  Sam Stenvall <sam.stenvall@nordsoftware.com>
 * @license GNU General Public License 2.0+
 */
abstract class NamedSection extends AbstractSection
{

	/**
	 * @var string
	 */
	protected $sectionLine;


	/**
	 * ListenSection constructor.
	 *
	 * @param string $sectionLine
	 */
	public function __construct($sectionLine)
	{
		$this->sectionLine = $sectionLine;
	}


	/**
	 * @return string the name of the section
	 */
	public function getName()
	{
		$words = explode(' ', $this->sectionLine, 2);

		return $words[1];
	}

}
