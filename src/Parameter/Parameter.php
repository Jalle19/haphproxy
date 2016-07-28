<?php

namespace Jalle19\HaPHProxy\Parameter;

/**
 * Class Parameter
 * @package Jalle19\HaPHProxy\Parameter
 * @author  Sam Stenvall <sam.stenvall@nordsoftware.com>
 * @license GNU General Public License 2.0+
 */
class Parameter
{

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var mixed
	 */
	private $value;


	/**
	 * Parameter constructor.
	 *
	 * @param string     $name
	 * @param mixed|null $value (optional)
	 */
	public function __construct($name, $value = null)
	{
		$this->name  = $name;
		$this->value = $value;
	}


	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}


	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}


	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}


	/**
	 * @param mixed $value
	 */
	public function setValue($value)
	{
		$this->value = $value;
	}

}
