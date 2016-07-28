<?php

namespace Jalle19\HaPHProxy\Section;

/**
 * Class Sections
 * @package Jalle19\HaPHProxy\Section
 * @author  Sam Stenvall <sam.stenvall@nordsoftware.com>
 * @license GNU General Public License 2.0+
 */
class Sections
{

	const SECTION_GLOBAL   = 'global';
	const SECTION_DEFAULTS = 'defaults';
	const SECTION_FRONTEND = 'frontend';
	const SECTION_BACKEND  = 'backend';
	const SECTION_LISTEN   = 'listen';

	/**
	 * @var array the available sections
	 */
	public static $availableSections = [
		self::SECTION_GLOBAL,
		self::SECTION_DEFAULTS,
		self::SECTION_FRONTEND,
		self::SECTION_BACKEND,
		self::SECTION_LISTEN,
	];

}
