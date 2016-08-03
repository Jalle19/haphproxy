<?php

namespace Jalle19\HaPHProxy\Test\Section;

use Jalle19\HaPHProxy\Section\AbstractSection;

/**
 * Class DummySection
 * @package Jalle19\HaPHProxy\Test\Section
 */
class DummySection extends AbstractSection
{

	/**
	 * @inheritdoc
	 */
	public function getType()
	{
		return 'test';
	}

}
