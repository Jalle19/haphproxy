<?php

namespace Jalle19\HaPHProxy\Section;

use Jalle19\HaPHProxy\Parameter\Parameter;

/**
 * Class AbstractSection
 * @package Jalle19\HaPHProxy\Section
 * @author  Sam Stenvall <sam.stenvall@nordsoftware.com>
 * @license GNU General Public License 2.0+
 */
abstract class AbstractSection
{

	/**
	 * @var Parameter[]
	 */
	protected $parameters = [];


	/**
	 * @return string the type of section
	 */
	abstract public function getType();


	/**
	 * @param Parameter $parameter
	 *
	 * @return $this
	 */
	public function addParameter(Parameter $parameter)
	{
		$this->parameters[] = $parameter;

		return $this;
	}


	/**
	 * @return Parameter[]
	 */
	public function getParameters()
	{
		return $this->parameters;
	}

}
