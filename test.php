<?php

spl_autoload_register(function ($class_name) {
	include $class_name . '.php';
});

$budapest = array(47.49801, 19.03991);
$monor = array(47.35133, 19.44733);
$szolnok = array(47.18333, 20.2);
$miskolc = array(48.1, 20.78333);
$szeged = array(46.253, 20.14824);
$cities = [$szolnok, $miskolc, $szeged];

$warehouses = [];
for ($i=0; $i<count($cities); $i++)
{
	$warehouse = new Warehouse();
	$warehouse->setId($i);
	$warehouse->setLatitude($cities[$i]['0']);
	$warehouse->setLongitude($cities[$i]['1']);
	$warehouses[] = $warehouse;
}

$buyer = new Buyer();
$buyer->setLatitude($budapest['0']);
$buyer->setLongitude($budapest['1']);

new App($buyer, $warehouses);
