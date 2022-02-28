<?php

class App
{
	public function __construct(Buyer $buyer, Order $order, array $warehouses)
	{
		try {
			$costEffectiveDeliveryCalculator = new CostEffectiveDeliveryCalculator($buyer, $order, $warehouses);
			$costEffectiveDeliveryCalculator->getClosestWarehouse();
		} catch (Exception $e) {
			echo $e->getMessage(), "\n";
		}
	}
}
