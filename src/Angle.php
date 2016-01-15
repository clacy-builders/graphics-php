<?php

namespace ML_Express\Graphics;

class Angle
{
	private $radians, $sin, $cos, $tan;

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
	 * Resets the angle in radians.
	 *
	 * @param  float  $radians
	 */
	public function set($radians)
	{
		$this->radians = $radians;
		$this->sin = sin($radians);
		$this->cos = cos($radians);
		$this->tan = tan($radians);
	}

	/**
	 * Resets the angle in degrees.
	 *
	 * @param  float  $degrees
	 */
	public function setDegrees($degrees)
	{
		$this->set(deg2rad($degrees));
	}

	/**
	 * Adds an angle in radians.
	 *
	 * @param  float  $radians
	 */
	public function add($radians)
	{
		$this->set($this->radians + $radians);
	}

	/**
	 * Adds an angle in degrees.
	 *
	 * @param  float  $degrees
	 */
	public function addDegrees($degrees)
	{
		$this->add(deg2rad($degrees));
	}

	/**
	 * Read access to <code>radians</code>, <code>sin</code>, <code>cos</code>, <code>tan</code>.
	 */
	public function __get($name)
	{
		return $this->{$name};
	}
}