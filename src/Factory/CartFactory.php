<?php

namespace App\Factory;

use App\Entity\Cart;

class CartFactory implements FactoryInterface
{
    public static function createEntity(): Cart
    {
        return new Cart();
    }
}