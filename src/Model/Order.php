<?php

namespace App\Model;

class Order
{
	private ?int $id = null;
	private int $itemCount = 0;
	private float $transportDistance = 0;
	private float $shippingPrice = 0;
	private ?Warehouse $closestWarehouse = null;
	private ?Buyer $buyer = null;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function setId(?int $id): void
	{
		$this->id = $id;
	}

	public function getItemCount(): int
	{
		return $this->itemCount;
	}

	public function setItemCount(int $itemCount): void
	{
		$this->itemCount = $itemCount;
	}

	public function getTransportDistance()
	{
		return $this->transportDistance;
	}

	public function setTransportDistance($transportDistance): void
	{
		$this->transportDistance = $transportDistance;
	}

	public function getShippingPrice()
	{
		return $this->shippingPrice;
	}

	public function setShippingPrice($shippingPrice): void
	{
		$this->shippingPrice = $shippingPrice;
	}

	public function getClosestWarehouse(): ?Warehouse
	{
		return $this->closestWarehouse;
	}

	public function setClosestWarehouse(?Warehouse $closestWarehouse): void
	{
		$this->closestWarehouse = $closestWarehouse;
	}

	public function getBuyer(): ?Buyer
	{
		return $this->buyer;
	}

	public function setBuyer(?Buyer $buyer): void
	{
		$this->buyer = $buyer;
	}
}
