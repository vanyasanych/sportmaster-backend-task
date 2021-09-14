<?php

namespace App\Factory;

use App\Entity\Inventory;

class InventoryFactory implements FactoryInterface
{
    public static function createEntity(): Inventory
    {
        return new Inventory();
    }
}