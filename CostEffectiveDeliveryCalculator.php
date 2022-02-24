<?php

class CostEffectiveDeliveryCalculator
{
	private int $radius = 100;
	private array $buyerPosition = [];

	private int $warehouseCount = 3;
	private array $warehouses = [];

	public function __construct()
	{
		$this->buyerPosition = $this->getBuyerPosition();
		var_dump($this->buyerPosition);
		var_dump($this->getWarehouses());
	}

	public function getBuyerPosition()
	{
		return $this->generateLatitudeAndLongitude();
	}

	public function getWarehouses()
	{
		for ($i = 0; $i < $this->warehouseCount; $i++) {
			$points = $this->generateLatitudeAndLongitude();
			$warehouse = new Warehouse();
			$warehouse->setId($i);
			$warehouse->setLatitude($points['0']);
			$warehouse->setLongitude($points['1']);
			$this->warehouses[] = $warehouse;
		}

		return $this->warehouses;
	}

	private function generateLatitudeAndLongitude(): array
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
