<?php

namespace App\Model;

class Warehouse extends AbstractPosition implements PositionInterface
{
    private ?string $id = null;
    private ?int $itemStock = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
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
