<?php

namespace App\Controller;

use App\Model\Buyer;
use App\Model\Order;
use App\Model\Warehouse;

class CostEffectiveDeliveryCalculator
{
    public function __construct(
        private Buyer $buyer,
        private Order $order,
        private array $warehouses
    ) {}

    public function  getClosestWarehouseAndShippingPrice()
    {
        $closestWarehouse = $this->getClosestWarehouse();
        if($closestWarehouse->getItemStock()<$this->order->getItemCount())
        {
            return 'kevesebb van készleten';
        }

        return $closestWarehouse;
    }
    
    
    

    private function getClosestWarehouse()
    {
        $minimumDistance = null;
        $closestWarehouse = null;
        /* @var Warehouse $warehouse */
        foreach($this->warehouses as $warehouse)
        {
            $distance = $this->getDistanceBetweenPoints(
                $this->buyer->getPosition(),
                [$warehouse->getLatitude(), $warehouse->getLongitude()]
            );
            if(is_null($minimumDistance) || is_null($closestWarehouse) || $distance<$minimumDistance)
            {
                $minimumDistance = $distance;
                $closestWarehouse = $warehouse;
            }
        }

        $this->order->setTransportDistance($minimumDistance);
        $this->order->setShippingPrice($minimumDistance*100);
        $this->order->setClosestWarehouse($closestWarehouse);

        return $closestWarehouse;
    }

    public function getDistancesBetweenWarehouses()
    {
        foreach($this->warehouses as $warehouse)
        {
            $distance = $this->getDistanceBetweenPoints(
                $this->buyer->getPosition(),
                [$warehouse->getLatitude(), $warehouse->getLongitude()]
            );
            if(is_null($minimumDistance) || is_null($closestWarehouse) || $distance<$minimumDistance)
            {
                $minimumDistance = $distance;
                $closestWarehouse = $warehouse;
            }
        }
    }

    // function based on: https://www.geodatasource.com/developers/php
    // other solution could be: $distance = sqrt(pow($lat1-$lat2, 2) + pow($long1-$long2, 2));
    private function getDistanceBetweenPoints($point1=[], $point2=[], $unit="kilometer")
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
                switch($unit)
                {
                    case 'kilometer':
                    {
                        return ($miles * 1.609344);
                    }
                    case 'mile':
                    {
                        return $miles;
                    }
                    case 'nautical':
                    {
                        return ($miles * 0.8684);
                    }
                }
            }
        }

        return 0;
    }
}
