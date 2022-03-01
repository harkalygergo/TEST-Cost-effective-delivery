<?php

namespace App\Model;

abstract class AbstractPosition
{
    private ?float $latitude = null;
    private ?float $longitude = null;

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

    public function getPosition(): array
    {
        return [$this->getLatitude(), $this->getLongitude()];
    }
}
