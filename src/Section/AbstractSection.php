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
	 * @var array
	 */
	protected $magicComments = [];


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
	 * @param string $name
	 *
	 * @return bool whether the specified parameter exists
	 */
	public function hasParameter($name)
	{
		return $this->getParameterByName($name) !== null;
	}


	/**
	 * @param string $name
	 *
	 * @return Parameter|null the parameter matching the specified name, or null if not found
	 */
	public function getParameterByName($name)
	{
		foreach ($this->parameters as $parameter) {
			if ($parameter->getName() === $name) {
				return $parameter;
			}
		}

		return null;
	}


	/**
	 * @return Parameter[]
	 */
	public function getParameters()
	{
		return $this->parameters;
	}


	/**
	 * @param string $name
	 *
	 * @return Parameter[] all parameters matching the specified nameF
	 */
	public function getParametersByName($name)
	{
		$parameters = [];

		foreach ($this->parameters as $parameter) {
			if ($parameter->getName() === $name) {
				$parameters[] = $parameter;
			}
		}

		return $parameters;
	}


	/**
	 * @return array
	 */
	public function getMagicComments()
	{
		return $this->magicComments;
	}


	/**
	 * @param string $comment
	 */
	public function addMagicComment($comment)
	{
		$this->magicComments[] = $comment;
	}

}
