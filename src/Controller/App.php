<?php

namespace App\Controller;

use Exception;
use App\Model\Buyer;
use App\Model\Order;

class App
{
	public function __construct(Buyer $buyer, Order $order, array $warehouses)
	{
		try {
			$costEffectiveDeliveryCalculator = new CostEffectiveDeliveryCalculator($buyer, $order, $warehouses);
			print_r($costEffectiveDeliveryCalculator->getClosestWarehouseAndShippingPrice());
		} catch (Exception $e) {
			echo $e->getMessage(), "\n";
		}
	}
}
