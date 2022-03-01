<?php

namespace App;

class Helper
{
	public function __construct(
		private int $radius
	) {}

	public function generateLatitudeAndLongitude(): array
	{
		$angle = deg2rad(mt_rand(0, 359));
		$pointRadius = mt_rand(0, $this->radius);
		$point = array(
			hash('adler32', rand(0, 100)),
			sin($angle) * $pointRadius,
			cos($angle) * $pointRadius
		);

		return $point;
	}

	public function getRandomPoints(int $count=0)
	{
		$points = [];
		for($i=0; $i<$count; $i++)
		{
			$points[] = $this->generateLatitudeAndLongitude();
		}

		return $points;
	}
}
