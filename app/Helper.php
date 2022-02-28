<?php

class Helper
{
	private int $radius;

	public function __construct(int $radius)
	{
		$this->radius = $radius;
	}

	public function generateLatitudeAndLongitude(): array
	{
		$angle = deg2rad(mt_rand(0, 359));
		$pointRadius = mt_rand(0, $this->radius);
		$point = array(
			sin($angle) * $pointRadius,
			cos($angle) * $pointRadius
		);

		return $point;
	}
}
