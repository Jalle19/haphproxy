<?php

namespace Jalle19\HaPHProxy\Section;

/**
 * Class DefaultSection
 * @package Jalle19\HaPHProxy\Section
 * @author  Sam Stenvall <sam.stenvall@nordsoftware.com>
 * @license GNU General Public License 2.0+
 */
class DefaultSection extends AbstractSection
{

	/**
	 * @inheritdoc
	 */
	public function getType()
	{
		return Sections::SECTION_DEFAULTS;
	}

}
