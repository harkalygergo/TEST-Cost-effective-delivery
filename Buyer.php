<?php

class Buyer
{
	private int $id;
	private float $latitude;
	private float $longitude;

	public function __construct()
	{
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function setId(int $id): void
	{
		$this->id = $id;
	}

	public function getLatitude(): float
	{
		return $this->latitude;
	}

	public function setLatitude(float $latitude): void
	{
		$this->latitude = $latitude;
	}

	public function getLongitude(): float
	{
		return $this->longitude;
	}

	public function setLongitude(float $longitude): void
	{
		$this->longitude = $longitude;
	}

	public function getPosition()
	{
		return [$this->getLatitude(), $this->getLongitude()];
	}
}
