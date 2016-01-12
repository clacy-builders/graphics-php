<?php

namespace ML_Express\Graphics;

use ML_Express\Graphics\Angle;

class Point
{
	private $x, $y;

	/**
	 * Returns a new <code>Point</code> instance.
	 *
	 * @param  float  $x
	 * @param  float  $y
	 * @return Point
	 */
	public static function create($x, $y)
	{
		$point = new Point();
		$point->x = $x;
		$point->y = $y;
		return $point;
	}

	/**
	 * Rotates current point clockwise.
	 *
	 * @param  Point  $center
	 * @param  Angle  $angle
	 * @return Point
	 */
	public function rotate(Point $center, Angle $angle)
	{
		$x = $this->x - $center->x;
		$y = $this->y - $center->y;
		$this->x = $x * $angle->cos - $y * $angle->sin + $center->x;
		$this->y = $y * $angle->cos + $x * $angle->sin + $center->y;
		return $this;
	}

	/**
	 * Changes the distance from <code>$center</code>.
	 *
	 * @param  Point  $center
	 * @param  float  $factor
	 * @return Point
	 */
	public function scale(Point $center, $factor)
	{
		return $this->scaleX($center, $factor)->scaleY($center, $factor);
	}

	/**
	 * Changes the distance from <code>$center</code> along the X-axis.
	 *
	 * @param  Point  $center
	 * @param  float  $factor
	 * @return Point
	 */
	public function scaleX(Point $center, $factor)
	{
		$this->x = ($this->x - $center->x) * $factor + $center->x;
		return $this;
	}

	/**
	 * Changes the distance from <code>$center</code> along the Y-axis.
	 *
	 * @param  Point  $center
	 * @param  float  $factor
	 * @return Point
	 */
	public function scaleY(Point $center, $factor)
	{
		$this->y = ($this->y - $center->y) * $factor + $center->y;
		return $this;
	}

	/**
	 * Moves current point along both axes.
	 *
	 * @param  float  $deltaX
	 * @param  float  $deltaY
	 * @return Point
	 */
	public function translate($deltaX, $deltaY)
	{
		return $this->translateX($deltaX)->translateY($deltaY);
	}

	/**
	 * Moves current point along the X-axis.
	 *
	 * @param  float  $deltaX
	 * @return Point
	 */
	public function translateX($deltaX)
	{
		$this->x += $deltaX;
		return $this;
	}

	/**
	 * Moves current point along the Y-axis.
	 *
	 * @param  float  $deltaY
	 * @return Point
	 */
	public function translateY($deltaY)
	{
		$this->y += $deltaY;
		return $this;
	}

	/**
	 * Returns a copy of the point.
	 *
	 * @return Point
	 */
	public function copy()
	{
		return self::create($this->x, $this->y);
	}

	/**
	 * Read access to <code>x</code>, <code>y</code>.
	 */
	public function __get($coordinate)
	{
		return $this->{$coordinate};
	}
}