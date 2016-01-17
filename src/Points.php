<?php

namespace ML_Express\Graphics;

use ML_Express\Graphics\Point;
use ML_Express\Graphics\Angle;

class Points implements \IteratorAggregate
{
	private $points;
	private $ccw;

	/**
	 * Returns a new <code>Points</code> instance.
	 *
	 * @param  boolean  $ccw  Whether the following points should be added counterclockwise or not.
	 * @return Points
	 */
	public static function create($ccw = false)
	{
		$points = new Points();
		$points->points = [];
		$points->ccw = $ccw;
		return $points;
	}

	/**
	 * Hint that following points should be added counterclockwise.
	 *
	 * @param  boolean  $ccw
	 * @return Points
	 */
	public function ccw($ccw = true)
	{
		$this->ccw = $ccw;
		return $this;
	}

	/**
	 * Adds a point.
	 *
	 * @param  Point  $point
	 * @return Point;
	 */
	public function addPoint(Point $point)
	{
		return $this->points[] = $point->copy();
	}

	/**
	 * Adds points.
	 *
	 * @param  Points  $points
	 * @return Points
	 */
	public function addPoints(Points $points)
	{
		foreach ($points as $point)
		{
			$this->addPoint($point);
		}
		return $this;
	}

	/**
	 * Calculates the points for a rectangle.
	 *
	 * @param  Point  $corner
	 * @param  float  $width
	 * @param  float  $height
	 * @return Points
	 */
	public function rectangle(Point $corner, $width, $height)
	{
		$this->addPoint($corner);
		$this->addPoint($corner)->translateX($width);
		$this->addPoint($corner)->translate($width, $height);
		$this->addPoint($corner)->translateY($height);
		$this->reverseIfCcw(3);
		return $this;
	}

	/**
	 * Calculates the points for a regular polygon.
	 *
	 * @param  Point  $center
	 * @param  int    $n       Number of corners.
	 * @param  float  $radius
	 * @return Points
	 */
	public function polygon(Point $center, $n, $radius)
	{
		return $this->star($center, $n, $radius, []);
	}

	/**
	 * Calculates the Points for a regular star polygon.
	 *
	 * @param  Point          $center
	 * @param  int            $n          Number of corners of the underlying polygon.
	 * @param  float          $radius
	 * @param  float|float[]  $starRadii
	 * @return Points
	 */
	public function star(Point $center, $n, $radius, $starRadii = [])
	{
		if (!is_array($starRadii)) {
			$starRadii = [$starRadii];
		}
		$radii = array_merge([$radius], $starRadii);
		$count = count($radii);
		$delta = deg2rad(360) / $n / $count;
		$angle = Angle::create(0);
		for ($i = 0; $i < $n; $i++) {
			foreach ($radii as $k => $radius) {
				$this->addPoint($center)->translateY(-$radius)->rotate($center, $angle);
				$angle->add($delta);
			}
		}
		$this->reverseIfCcw($n * $count - 1);
		return $this;
	}

	/**
	 * Calculates the points for a sector of a circle.
	 *
	 * @param  Point  $center
	 * @param  Angle  $start
	 * @param  Angle  $stop    Must be greater than <code>$start</code>.
	 * @param  float  $radius
	 * @return Points
	 */
	public function sector(Point $center, Angle $start, Angle $stop, $radius)
	{
		$this->addPoint($center);
		$this->addPoint($center)->translateX($radius)->rotate($center, $start);
		$this->addPoint($center)->translateX($radius)->rotate($center, $stop);
		$this->reverseIfCcw(2);
		return $this;
	}

	/**
	 * Calculates the points for a sector of a ring.
	 *
	 * @param  Point  $center
	 * @param  Angle  $start
	 * @param  Angle  $stop         Must be greater than <code>$start</code>.
	 * @param  float  $radius
	 * @param  float  $innerRadius
	 * @return Points
	 */
	public function ringSector(Point $center, Angle $start, Angle $stop, $radius, $innerRadius)
	{
		if ($this->ccw) { $swap = $start; $start = $stop; $stop = $swap; }
		$this->addPoint($center)->translateX($radius)->rotate($center, $start);
		$this->addPoint($center)->translateX($radius)->rotate($center, $stop);
		$this->addPoint($center)->translateX($innerRadius)->rotate($center, $stop);
		$this->addPoint($center)->translateX($innerRadius)->rotate($center, $start);
		return $this;
	}

	/**
	 * Rotates points.
	 *
	 * @param  Point  $center
	 * @param  Angle  $angle
	 * @return Points
	 */
	public function rotate(Point $center, Angle $angle)
	{
		foreach ($this->points as $point) {
			$point->rotate($center, $angle);
		}
		return $this;
	}

	/**
	 * Scales points.
	 *
	 * @param  Point  $center
	 * @param  float  $factor
	 * @return Points
	 */
	public function scale(Point $center, $factor)
	{
		foreach ($this->points as $point) {
			$point->scale($center, $factor);
		}
		return $this;
	}

	/**
	 * Scales points along the X-axis.
	 *
	 * @param  Point  $center
	 * @param  float  $factor
	 * @return Points
	 */
	public function scaleX(Point $center, $factor)
	{
		foreach ($this->points as $point) {
			$point->scaleX($center, $factor);
		}
		return $this;
	}

	/**
	 * Scales points along the Y-axis.
	 *
	 * @param  Point  $center
	 * @param  float  $factor
	 * @return Points
	 */
	public function scaleY(Point $center, $factor)
	{
		foreach ($this->points as $point) {
			$point->scaleY($center, $factor);
		}
		return $this;
	}

	/**
	 * A skew transformation along the X-axis.
	 *
	 * @param  Point  $center
	 * @param  Angle  $angle
	 * @return Points
	 */
	public function skewX(Point $center, Angle $angle)
	{
		foreach ($this->points as $point) {
			$point->skewX($center, $angle);
		}
		return $this;
	}

	/**
	 * A skew transformation along the Y-axis.
	 *
	 * @param  Point  $center
	 * @param  Angle  $angle
	 * @return Points
	 */
	public function skewY(Point $center, Angle $angle)
	{
		foreach ($this->points as $point) {
			$point->skewY($center, $angle);
		}
		return $this;
	}

	/**
	 * Translates points.
	 *
	 * @param  float  $deltaX
	 * @param  float  $deltaY
	 * @return Points
	 */
	public function translate($deltaX, $deltaY)
	{
		foreach ($this->points as $point) {
			$point->translate($deltaX, $deltaY);
		}
		return $this;
	}

	/**
	 * Translates points along the X-axis.
	 *
	 * @param  float  $deltaX
	 * @param  float  $deltaY
	 * @return Points
	 */
	public function translateX($deltaX)
	{
		foreach ($this->points as $point) {
			$point->translateX($deltaX);
		}
		return $this;
	}

	/**
	 * Translates points along the Y-axis.
	 *
	 * @param  float  $deltaX
	 * @param  float  $deltaY
	 * @return Points
	 */
	public function translateY($deltaY)
	{
		foreach ($this->points as $point) {
			$point->translateY($deltaY);
		}
		return $this;
	}

	public function getIterator()
	{
		return new \ArrayIterator($this->points);
	}

	public function __get($name)
	{
		return $this->points;
	}

	private function reverseIfCcw($n)
	{
		if (!$this->ccw) return;
		$count = count($this->points);
		for ($i = $count - $n, $k = $count - 1; $i < $k; $i++, $k--) {
			$swap = $this->points[$i];
			$this->points[$i] = $this->points[$k];
			$this->points[$k] = $swap;
		}
	}
}