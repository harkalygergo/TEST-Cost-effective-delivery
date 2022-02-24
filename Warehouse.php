<?php

class Warehouse
{
	private int $id;
	private ?float $latitude = null;
	private ?float $longitude = null;

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

	/**
	 * @return float|null
	 */
	public function getLatitude(): ?float
	{
		return $this->latitude;
	}

	/**
	 * @param float|null $latitude
	 */
	public function setLatitude(?float $latitude): void
	{
		$this->latitude = $latitude;
	}

	/**
	 * @return float|null
	 */
	public function getLongitude(): ?float
	{
		return $this->longitude;
	}

	/**
	 * @param float|null $longitude
	 */
	public function setLongitude(?float $longitude): void
	{
		$this->longitude = $longitude;
	}
}
