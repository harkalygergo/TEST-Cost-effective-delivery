<?php

class Order
{
	private int $itemCount = 0;
	private float $transportDistance = 0;
	private float $shippingPrice = 0;
	private ?Warehouse $closestWarehouse = null;

	/**
	 * @return int
	 */
	public function getItemCount(): int
	{
		return $this->itemCount;
	}

	/**
	 * @param int $itemCount
	 */
	public function setItemCount(int $itemCount): void
	{
		$this->itemCount = $itemCount;
	}

	/**
	 * @return float|int
	 */
	public function getTransportDistance()
	{
		return $this->transportDistance;
	}

	/**
	 * @param float|int $transportDistance
	 */
	public function setTransportDistance($transportDistance): void
	{
		$this->transportDistance = $transportDistance;
	}

	/**
	 * @return float|int
	 */
	public function getShippingPrice()
	{
		return $this->shippingPrice;
	}

	/**
	 * @param float|int $shippingPrice
	 */
	public function setShippingPrice($shippingPrice): void
	{
		$this->shippingPrice = $shippingPrice;
	}

	/**
	 * @return Warehouse|null
	 */
	public function getClosestWarehouse(): ?Warehouse
	{
		return $this->closestWarehouse;
	}

	/**
	 * @param Warehouse|null $closestWarehouse
	 */
	public function setClosestWarehouse(?Warehouse $closestWarehouse): void
	{
		$this->closestWarehouse = $closestWarehouse;
	}
}
