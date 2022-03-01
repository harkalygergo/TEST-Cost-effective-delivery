<?php

use App\Controller\App;
use App\Helper;
use App\Model\Buyer;
use App\Model\Order;
use App\Model\Warehouse;

require_once __DIR__ . '/vendor/autoload.php';

class Test
{
	private Helper $helper;

	public function __construct(
		private int $warehouseCount = 3,
		private int $radius = 100,
		private bool $randomPoints = false,
	)
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
		if ($this->randomPoints) {
			$cities = $this->helper->getRandomPoints($this->warehouseCount);
			$randomPoint = $this->helper->getRandomPoints(1);
			$buyer->setLatitude($randomPoint['0']['1']);
			$buyer->setLongitude($randomPoint['0']['2']);
		} else {
			$budapest = array(47.49801, 19.03991);
			$cities = [
				//array('Monor', 47.35133, 19.44733),
				array('Szolnok', 47.18333, 20.2),
				array('Miskolc', 48.1, 20.78333),
				array('Szeged', 46.253, 20.14824),
			];
			$buyer->setLatitude($budapest['0']);
			$buyer->setLongitude($budapest['1']);
		}
		for ($i = 0; $i < count($cities); $i++) {
			$warehouse = new Warehouse();
			$warehouse->setId($cities[$i]['0']);
			$warehouse->setLatitude($cities[$i]['1']);
			$warehouse->setLongitude($cities[$i]['2']);
			$warehouse->setItemStock(rand(0, $order->getItemCount()));
			$warehouses[] = $warehouse;
		}

		// run
		new App($buyer, $order, $warehouses);
		print_r($order);
	}
}

(new Test())->test();
