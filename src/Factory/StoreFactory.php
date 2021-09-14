<?php

namespace App\Factory;

use App\Entity\Store;

class StoreFactory implements FactoryInterface
{
    public static function createEntity(): Store
    {
        return new Store();
    }
}