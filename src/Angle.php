<?php

namespace ML_Express\Graphics;

class Angle
{
	public $radians, $sin, $cos;

	/**
	 * Returns a new <code>Angle</code> instance.
	 *
	 * @param  float  $radians
	 * @return Angle
	 */
	public static function create($radians)
	{
		$angle = new Angle();
		$angle->set($radians);
		return $angle;
	}

	/**
	 * Returns a new <code>Angle</code> instance.
	 *
	 * @param  float  $degrees
	 * @return Angle
	 */
	public static function byDegrees($degrees)
	{
		return self::create(deg2rad($degrees));
	}

	/**
	 * Sets angle in radians.
	 *
	 * @param  float  $radians
	 */
	public function set($radians)
	{
		$this->radians = $radians;
		$this->sin = sin($radians);
		$this->cos = cos($radians);
	}

	/**
	 * Sets angle in degrees.
	 *
	 * @param  float  $degrees
	 */
	public function setDegrees($degrees)
	{
		$this->set(deg2rad($degrees));
	}

	/**
	 * Adds angle in radians.
	 *
	 * @param  float  $radians
	 */
	public function add($radians)
	{
		$this->set($this->radians + $radians);
	}

	/**
	 * Adds angle in degrees.
	 *
	 * @param  float  $degrees
	 */
	public function addDegrees($degrees)
	{
		$this->add(deg2rad($degrees));
	}

	/**
	 * Read access to <code>radians</code>, <code>sin</code>, <code>cos</code>.
	 */
	public function __get($name)
	{
		return $this->{$name};
	}
}