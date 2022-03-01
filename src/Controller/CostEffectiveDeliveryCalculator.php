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
        private array $warehouses,
        private ?Warehouse $closestWarehouse = null
    ) {}

    public function getClosestWarehouseWithShippingPrice()
    {
        $this->closestWarehouse = $this->getClosestWarehouse();
        if($this->closestWarehouse->getItemStock()<$this->order->getItemCount())
        {
            $missingItems = $this->order->getItemCount() - $this->closestWarehouse->getItemStock();
            $this->findOptimalRoute($missingItems);
        }

        return $this->closestWarehouse;
    }
    
    public function findOptimalRoute($missingItems)
    {
        $warehouseHasMissingItem = null;
        foreach($this->warehouses as $warehouse)
        {
            if($this->closestWarehouse!==$warehouse)
            {
                /* @var Warehouse $warehouse */
                if($warehouse->getItemStock()===$missingItems)
                {
                    $warehouseHasMissingItem = $warehouse;
                }
            }
        }
        if(!is_null($warehouseHasMissingItem))
        {
            $this->increaseShippingPriceWithOneWarehouse($warehouseHasMissingItem);
        }
        else
        {
            $this->increaseShippingPriceWithMultipleWarehouses();
        }
    }

    private function increaseShippingPriceWithOneWarehouse($warehouse)
    {
        $extraShippingFeeDistance = $this->getDistanceBetweenPoints(
            $this->closestWarehouse->getPosition(),
            $warehouse->getPosition()
        );
        $this->order->setShippingPrice( $this->order->getShippingPrice() + $extraShippingFeeDistance*0.15 );
    }

    private function increaseShippingPriceWithMultipleWarehouses()
    {
        $extraShippingFeeDistance = 0;
        foreach($this->warehouses as $warehouse)
        {
            if($this->closestWarehouse!==$warehouse)
            {
                $extraShippingFeeDistance += $this->getDistanceBetweenPoints(
                    $this->closestWarehouse->getPosition(),
                    $warehouse->getPosition()
                );
            }
        }
        $this->order->setShippingPrice( $this->order->getShippingPrice() + $extraShippingFeeDistance*0.15 );
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

    // function based on: https://www.geodatasource.com/developers/php
    // other solution could be: $distance = sqrt(pow($lat1-$lat2, 2) + pow($long1-$long2, 2));
    private function getDistanceBetweenPoints($coordinates1=[], $coordinates2=[], $unit="kilometer")
    {
        if(!empty($coordinates1) && !empty($coordinates2))
        {
            $lat1 = $coordinates1['0'];
            $lon1 = $coordinates1['1'];
            $lat2 = $coordinates2['0'];
            $lon2 = $coordinates2['1'];
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
