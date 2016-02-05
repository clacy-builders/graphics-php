<?php

namespace ML_Express\Graphics\Tests;

require_once 'src/Points.php';
require_once 'src/Point.php';
require_once 'src/Angle.php';

use ML_Express\Graphics\Points;
use ML_Express\Graphics\Point;
use ML_Express\Graphics\Angle;

class PointsTest extends \PHPUnit_Framework_TestCase
{
	public function rectangleProvider()
	{
		return array(
				array(
						[[10, 20], [110, 20], [110, 100], [10, 100]],
						Points::rectangle(Point::create(10, 20), 100, 80)
				),
				array(
						[[10, 20], [10, 100], [110, 100], [110, 20]],
						Points::rectangle(Point::create(10, 20), 100, 80, true)
				)
		);
	}

	/**
	 * @dataProvider rectangleProvider
	 */
	public function testRectangle($expected, $points)
	{
		$this->assertEqualPointArrays($expected, $points);
	}

	public function polygonProvider()
	{
		return array(
				array(
						[[10, -80], [110, 20], [10, 120], [-90, 20]],
						Points::polygon(Point::create(10, 20), 4, 100)
				),
				array(
						[[10, -80], [-90, 20], [10, 120], [110, 20]],
						Points::polygon(Point::create(10, 20), 4, 100, true)
				)
		);
	}

	/**
	 * @dataProvider polygonProvider
	 */
	public function testPolygon($expected, $points)
	{
		$this->assertEqualPointArrays($expected, $points);
	}

	public function starProvider()
	{
		return array(
				array(
						[[10, -80], [60, 20], [10, 120], [-40, 20]],
						Points::star(Point::create(10, 20), 2, 100, 50)
				),
				array(
						[[10, -80], [-40, 20], [10, 120], [60, 20]],
						Points::star(Point::create(10, 20), 2, 100, 50, true)
				),
				array(
						[[10, -80], [60, 20], [10, 120], [-40, 20]],
						Points::star(Point::create(10, 20), 1, 100, [50, 100, 50])
				),
				array(
						[[10, -80], [-40, 20], [10, 120], [60, 20]],
						Points::star(Point::create(10, 20), 1, 100, [50, 100, 50], true)
				)
		);
	}

	/**
	 * @dataProvider starProvider
	 */
	public function testStar($expected, $points)
	{
		$this->assertEqualPointArrays($expected, $points);
	}

	public function rotatedProvider()
	{
		return array(
				array(
						[[-2, -4], [2, -4], [4, -2], [4, 2], [2, 4], [-2, 4], [-4, 2], [-4, -2]],
						Points::rotated(Point::create(0, 0), 4, [Point::create(-2, -4),
								Point::create(2, -4)])
				),
				array(
						[[-4, -2], [-4, 2], [-2, 4], [2, 4], [4, 2], [4, -2], [2, -4], [-2, -4]],
						Points::rotated(Point::create(0, 0), 4, [Point::create(-2, -4),
								Point::create(2, -4)], true)
				),
		);
	}

	/**
	 * @dataProvider rotatedProvider
	 */
	public function testRotated($expected, $points)
	{
		$this->assertEqualPointArrays($expected, $points);
	}


	public function sectorProvider()
	{
		$a1 = Angle::byDegrees(45);
		$a2 = Angle::byDegrees(135);
		$l = sin(\deg2rad(45)) * 100;
		return array(
				array(
						[[10, 20], [10 + $l, 20 + $l], [10 - $l, 20 + $l]],
						Points::sector(Point::create(10, 20), $a1, $a2, 100)
				),
				array(
						[[10, 20], [10 - $l, 20 + $l], [10 + $l, 20 + $l]],
						Points::sector(Point::create(10, 20), $a1, $a2, 100, true)
				)
		);
	}

	/**
	 * @dataProvider sectorProvider
	 */
	public function testSector($expected, $points)
	{
		$this->assertEqualPointArrays($expected, $points);
	}

	public function ringSectorProvider()
	{
		$a1 = Angle::byDegrees(45);
		$a2 = Angle::byDegrees(135);
		$l1 = sin(\deg2rad(45)) * 100;
		$l2 = $l1 / 2;
		return array(
				array(
						[[10+$l1, 20+$l1], [10-$l1, 20+$l1], [10-$l2, 20+$l2], [10+$l2, 20+$l2]],
						Points::ringSector(Point::create(10, 20), $a1, $a2, 100, 50)
				),
				array(
						[[10-$l1, 20+$l1], [10+$l1, 20+$l1], [10+$l2, 20+$l2], [10-$l2, 20+$l2]],
						Points::ringSector(Point::create(10, 20), $a1, $a2, 100, 50, true)
				)
		);
	}

	/**
	 * @dataProvider ringSectorProvider
	 */
	public function testRingSector($expected, $points)
	{
		$this->assertEqualPointArrays($expected, $points);
	}

	public function roundedRectangleProvider()
	{
		return array(
				array(
						[[100, 20], [110, 30], [110, 90], [100, 100],
								[20, 100], [10, 90], [10, 30], [20, 20]],
						Points::roundedRectangle(Point::create(10, 20), 100, 80, 10)
				),
				array(
						[[20, 20], [10, 30], [10, 90], [20, 100],
								[100, 100], [110, 90], [110, 30], [100, 20]],
						Points::roundedRectangle(Point::create(10, 20), 100, 80, 10, true)
				),
		);
	}

	/**
	 * @dataProvider roundedRectangleProvider
	 */
	public function testRoundedRectangle($expected, $points)
	{
		$this->assertEqualPointArrays($expected, $points);
	}

	public function scaleXProvider()
	{
		return array(
				array(
						[[-10, 20], [-10, 100], [-110, 100], [-110, 20]],
						Points::rectangle(Point::create(10, 20), 100, 80)
								->scaleX(Point::create(0, 0), -1)
				),
				array(
						[[10, 20], [10, 100], [60, 100], [60, 20]],
						Points::rectangle(Point::create(10, 20), 100, 80, true)
								->scaleX(Point::create(10, 20), 0.5)
				)
		);
	}

	/**
	 * @dataProvider scaleXProvider
	 */
	public function testScaleX($expected, $points)
	{
		$this->assertEqualPointArrays($expected, $points);
	}

	public function assertEqualPointArrays($expected, Points $points)
	{
		$pointsArray = [];
		foreach ($points as $point) {
			$pointsArray[] = [$point->x, $point->y];
		}
		$this->assertEquals($expected, $pointsArray);
	}
}