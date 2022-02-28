<?php

namespace App;

class Warehouse
{
	private string $id;
	private ?float $latitude = null;
	private ?float $longitude = null;
	private ?int $itemStock = null;

	public function getId(): string
	{
		return $this->id;
	}

	public function setId(string $id): void
	{
		$this->id = $id;
	}

	public function getLatitude(): ?float
	{
		return $this->latitude;
	}

	public function setLatitude(?float $latitude): void
	{
		$this->latitude = $latitude;
	}

	public function getLongitude(): ?float
	{
		return $this->longitude;
	}

	public function setLongitude(?float $longitude): void
	{
		$this->longitude = $longitude;
	}

	public function getItemStock(): ?int
	{
		return $this->itemStock;
	}

	public function setItemStock(?int $itemStock): void
	{
		$this->itemStock = $itemStock;
	}
}
