<?php

namespace ML_Express\Graphics\Tests;

require_once 'src/Point.php';
require_once 'src/Angle.php';

use ML_Express\Graphics\Point;
use ML_Express\Graphics\Angle;

class PointTest extends \PHPUnit_Framework_TestCase
{
	public function rotateProvider()
	{
		$degrees = 60;
		$angle = Angle::byDegrees($degrees);
		$sin = $angle->sin;
		$cos = $angle->cos;
		return array(
				[1, 0, 0, 0, $degrees, $cos, $sin],
				[0, 1, 0, 0, $degrees, -$sin, $cos],
				[-1, 0, 0, 0, $degrees, -$cos, -$sin],
				[0, -1, 0, 0, $degrees, $sin, -$cos],
				[2, 1, 1, 1, $degrees, 1 + $cos, 1 + $sin],
				[1, 2, 1, 1, $degrees, 1 - $sin, 1 + $cos],
				[0, 1, 1, 1, $degrees, 1 - $cos, 1 - $sin],
				[1, 0, 1, 1, $degrees, 1 + $sin, 1 - $cos],
		);
	}

	/**
	 * @dataProvider rotateProvider
	 */
	public function testRotate($x, $y, $cx, $cy, $degrees, $expectedX, $expectedY)
	{
		$this->assertEqualCoordinates($expectedX, $expectedY, Point::create($x, $y)
				->rotate(Point::create($cx, $cy), Angle::byDegrees($degrees)));
	}

	public function scaleProvider()
	{
		return array(
				[100, 200, 0, 0, 0.5, 50, 100],
				[100, 200, 50, 50, 0.5, 75, 125],
		);
	}

	/**
	 * @dataProvider scaleProvider
	 */
	public function testScale($x, $y, $cx, $cy, $factor, $expectedX, $expectedY)
	{
		$this->assertEqualCoordinates($expectedX, $expectedY, Point::create($x, $y)
				->scale(Point::create($cx, $cy), $factor));
	}

	public function skewXProvider()
	{
		return array(
				[0,10, 0,0, 45, 10,10],
				[10,10, 0,0, 45, 20,10],
				[0,-10, 0,0, 45, -10,-10],
				[0,10, 40,40, 45, -30,10],
				[10,10, 40,40, 45, -20,10],
				[0,-10, 40,40, 45, -50,-10]
		);
	}

	/**
	 * @dataProvider skewXProvider
	 */
	public function testSkewX($x, $y, $cx, $cy, $degrees, $expectedX, $expectedY)
	{
		$this->assertEqualCoordinates($expectedX, $expectedY, Point::create($x, $y)
				->skewX(Point::create($cx, $cy), Angle::byDegrees($degrees)));
	}

	public function skewYProvider()
	{
		return array(
				[10,0, 0,0, 45, 10,10],
				[10,10, 0,0, 45, 10,20],
				[-10,0, 0,0, 45, -10,-10],
				[10,0, 40,40, 45, 10,-30],
				[10,10, 40,40, 45, 10,-20],
				[-10,0, 40,40, 45, -10,-50]
		);
	}

	/**
	 * @dataProvider skewYProvider
	 */
	public function testSkewY($x, $y, $cx, $cy, $degrees, $expectedX, $expectedY)
	{
		$this->assertEqualCoordinates($expectedX, $expectedY, Point::create($x, $y)
				->skewY(Point::create($cx, $cy), Angle::byDegrees($degrees)));
	}

	public function testTranslate()
	{
		$this->assertEqualCoordinates(25, 25, Point::create(20.5, 10)->translate(4.5, 15));
	}

	public function assertEqualCoordinates($expectedX, $expectedY, Point $point)
	{
		$this->assertEquals([$expectedX, $expectedY], [$point->x, $point->y]);
	}
}
