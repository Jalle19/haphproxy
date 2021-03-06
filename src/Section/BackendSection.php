<?php

namespace Jalle19\HaPHProxy\Section;

/**
 * Class BackendSection
 * @package Jalle19\HaPHProxy\Section
 * @author  Sam Stenvall <sam.stenvall@nordsoftware.com>
 * @license GNU General Public License 2.0+
 */
class BackendSection extends NamedSection
{

	/**
	 * @inheritdoc
	 */
	public function getType()
	{
		return Sections::SECTION_BACKEND;
	}

}
