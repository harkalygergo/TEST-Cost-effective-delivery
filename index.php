<?php

spl_autoload_register(function ($class_name) {
	include $class_name . '.php';
});

class App
{
	public function __construct()
	{
		try {
			print_r( (new CostEffectiveDeliveryCalculator())->getClosestWarehouse() );
		} catch (Exception $e) {
			echo $e->getMessage(), "\n";
		}
	}
}
(new App());
