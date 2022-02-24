<?php

class App
{
	public function __construct(Buyer $buyer, array $warehouses)
	{
		try {
			$costEffectiveDeliveryCalculator = new CostEffectiveDeliveryCalculator($buyer, $warehouses);
			print_r ($costEffectiveDeliveryCalculator->getClosestWarehouse() );
		} catch (Exception $e) {
			echo $e->getMessage(), "\n";
		}
	}
}
