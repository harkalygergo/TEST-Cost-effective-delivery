<?php

class CostEffectiveDeliveryCalculator
{
	private Helper $helper;
	private Buyer $buyer;
	private array $warehouses;
	private int $radius = 100;
	private int $warehouseCount = 3;

	public function __construct(Buyer $buyer, array $warehouses)
	{
		$this->buyer = $buyer;
		$this->warehouses = $warehouses;
		$this->helper = new Helper($this->radius);
	}

	public function getClosestWarehouse()
	{
		$minimumDistance = null;
		$closestWarehouse = null;
		/* @var Warehouse $warehouse */
		foreach($this->warehouses as $warehouse)
		{
			$distance = $this->getDistanceBeetweenPoints(
				$this->buyer->getPosition(),
				[$warehouse->getLatitude(), $warehouse->getLongitude()]
			);
			if(is_null($minimumDistance) || $distance<$minimumDistance)
			{
				$minimumDistance = $distance;
				$closestWarehouse = $warehouse;
			}
		}

		return $closestWarehouse;
	}

	public function getWarehouses()
	{
		for ($i=0; $i<$this->warehouseCount; $i++)
		{
			$points = $this->helper->generateLatitudeAndLongitude();
			$warehouse = new Warehouse();
			$warehouse->setId($i);
			$warehouse->setLatitude($points['0']);
			$warehouse->setLongitude($points['1']);
			$this->warehouses[] = $warehouse;
		}

		return $this->warehouses;
	}






	// function based on: https://www.geodatasource.com/developers/php
	// other solution could be: $distance = sqrt(pow($lat1-$lat2, 2) + pow($long1-$long2, 2));
	private function getDistanceBeetweenPoints($point1=[], $point2=[], $unit="K")
	{
		if(!empty($point1) && !empty($point2))
		{
			$lat1 = $point1['0'];
			$lon1 = $point1['1'];
			$lat2 = $point2['0'];
			$lon2 = $point2['1'];
			if (($lat1 == $lat2) && ($lon1 == $lon2))
			{
				return 0;
			}
			else
			{
				$theta = $lon1 - $lon2;
				$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
				$dist = acos($dist);
				$dist = rad2deg($dist);
				$miles = $dist * 60 * 1.1515;
				$unit = strtoupper($unit);
				if ($unit==="K")
				{
					return ($miles * 1.609344);
				}
				elseif($unit==="N")
				{
					return ($miles * 0.8684);
				}
				else
				{
					return $miles;
				}
			}
		}
		else
		{
			return null;
		}
	}


}
