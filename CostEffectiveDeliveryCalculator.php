<?php

class CostEffectiveDeliveryCalculator
{
	private Helper $helper;
	private int $radius = 100;
	private array $buyerPosition = [];

	private int $warehouseCount = 3;
	private array $warehouses = [];

	public function __construct()
	{
		$this->helper = new Helper($this->radius);
		//$this->buyerPosition = $this->getBuyerPosition();
		//$this->warehouses = $this->getWarehouses();

		$this->buyerPosition = $budapest = array(47.49801, 19.03991);
		$szolnok = array(47.18333, 20.2);
		$miskolc = array(48.1, 20.78333);
		$szeged = array(46.253, 20.14824);
		$varosok = [$szolnok, $miskolc, $szeged];

		for ($i=0; $i<$this->warehouseCount; $i++)
		{
			$warehouse = new Warehouse();
			$warehouse->setId($i);
			$warehouse->setLatitude($varosok[$i]['0']);
			$warehouse->setLongitude($varosok[$i]['1']);
			$this->warehouses[] = $warehouse;
		}
		/*
		var_dump($this->warehouses);
		var_dump($this->getClosestWarehouse());
		exit;

		echo $this->getDistanceBeetweenPoints($szolnok, $budapest, "K") . " Miles\n";
		echo $this->getDistanceBeetweenPoints($miskolc, $budapest, "K") . " Kilometers\n";
		echo $this->getDistanceBeetweenPoints($szeged, $budapest, "K") . " Nautical Miles\n";
		exit;


		$distance = sqrt(pow($lat1-$lat2, 2) + pow($long1-$long2, 2));
		var_dump($distance);


		$earthRadius = 6371000;
		$latFrom = deg2rad($lat1);
		$lonFrom = deg2rad($long1);
		$latTo = deg2rad($lat2);
		$lonTo = deg2rad($long2);

		$lonDelta = $lonTo - $lonFrom;
		$a = pow(cos($latTo) * sin($lonDelta), 2) +
			pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
		$b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

		$angle = atan2(sqrt($a), $b);
		echo $angle * $earthRadius;

		exit;
		*/
	}

	public function getClosestWarehouse()
	{
		$minimumDistance = null;
		$closestWarehouse = null;
		/* @var Warehouse $warehouse */
		foreach($this->warehouses as $warehouse)
		{
			$distance = $this->getDistanceBeetweenPoints(
				$this->buyerPosition,
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
