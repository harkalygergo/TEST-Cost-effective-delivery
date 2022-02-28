<?php

spl_autoload_register(function ($class_name) {
	include 'app/'.$class_name . '.php';
});

class Test
{
	private int $warehouseCount = 3;
	private int $radius = 100;
	private bool $randomPoints = false;
	private Helper $helper;

	public function __construct()
	{
		$this->helper = new Helper($this->radius);
	}

	public function test()
	{
		// order
		$order = new Order();
		$order->setItemCount(10);

		// buyer
		$buyer = new Buyer();

		// warehouses
		$warehouses = [];
		if($this->randomPoints)
		{
			$cities = $this->helper->getRandomPoints($this->warehouseCount);
			$randomPoint = $this->helper->getRandomPoints(1);
			$buyer->setLatitude($randomPoint['0']['0']);
			$buyer->setLongitude($randomPoint['0']['1']);
		}
		else
		{
			$budapest = array(47.49801, 19.03991);
			$monor = array(47.35133, 19.44733);
			$szolnok = array(47.18333, 20.2);
			$miskolc = array(48.1, 20.78333);
			$szeged = array(46.253, 20.14824);
			$cities = [$szolnok, $miskolc, $szeged];
			$buyer->setLatitude($budapest['0']);
			$buyer->setLongitude($budapest['1']);
		}
		for ($i=0; $i<count($cities); $i++)
		{
			$warehouse = new Warehouse();
			$warehouse->setId($i);
			$warehouse->setLatitude($cities[$i]['0']);
			$warehouse->setLongitude($cities[$i]['1']);
			$warehouse->setItemStock(rand(0, $order->getItemCount()));
			$warehouses[] = $warehouse;
		}

		// run
		new App($buyer, $order, $warehouses);
		print_r($order);
	}
}
(new Test)->test();
