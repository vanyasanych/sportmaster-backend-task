<?php

namespace App\Factory;

use App\Entity\Product;

class ProductFactory implements FactoryInterface
{
    public static function createEntity(): Product
    {
        return new Product();
    }
}