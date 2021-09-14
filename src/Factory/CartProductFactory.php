<?php

namespace App\Factory;

use App\Entity\ProductGroup;

class CartProductFactory
{
    public static function createEntity(): ProductGroup
    {
        return new ProductGroup();
    }
}