<?php

namespace Jalle19\HaPHProxy\Section;

/**
 * Class Factory
 * @package Jalle19\HaPHProxy\Section
 * @author  Sam Stenvall <sam.stenvall@nordsoftware.com>
 * @license GNU General Public License 2.0+
 */
class Factory
{

	/**
	 * @param string $line
	 *
	 * @return AbstractSection|null
	 */
	public static function makeFactory($line)
	{
		$words     = explode(' ', $line);
		$firstWord = $words[0];

		switch ($firstWord) {
			case Sections::SECTION_GLOBAL:
				return new GlobalSection();
			case Sections::SECTION_DEFAULTS:
				return new DefaultsSection();
			case Sections::SECTION_FRONTEND:
				return new FrontendSection($line);
			case Sections::SECTION_BACKEND:
				return new BackendSection($line);
			case Sections::SECTION_LISTEN:
				return new ListenSection($line);
		}

		return null;
	}

}
