<?php

namespace Jalle19\HaPHProxy\Section;

/**
 * Class ListenSection
 * @package Jalle19\HaPHProxy\Section
 * @author  Sam Stenvall <sam.stenvall@nordsoftware.com>
 * @license GNU General Public License 2.0+
 */
class ListenSection extends NamedSection
{

	/**
	 * @inheritdoc
	 */
	public function getType()
	{
		return Sections::SECTION_LISTEN;
	}

}
