<?php

class CostEffectiveDeliveryCalculator
{
	private Helper $helper;
	private Buyer $buyer;
	private int $radius = 100;
	private int $warehouseCount = 3;
	private array $warehouses = [];

	public function __construct()
	{
		$this->helper = new Helper($this->radius);
		$this->buyer = new Buyer();
		$test = true;

		if($test)
		{
			$budapest = array(47.49801, 19.03991);
			$monor = array(47.35133, 19.44733);
			$szolnok = array(47.18333, 20.2);
			$miskolc = array(48.1, 20.78333);
			$szeged = array(46.253, 20.14824);
			$varosok = [$szolnok, $miskolc, $szeged];
			$this->buyer->setLatitude($budapest['0']);
			$this->buyer->setLongitude($budapest['1']);
			for ($i=0; $i<$this->warehouseCount; $i++)
			{
				$warehouse = new Warehouse();
				$warehouse->setId($i);
				$warehouse->setLatitude($varosok[$i]['0']);
				$warehouse->setLongitude($varosok[$i]['1']);
				$this->warehouses[] = $warehouse;
			}
		}
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

	public function getBuyerPosition()
	{
		return $this->helper->generateLatitudeAndLongitude();
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
