<?php

namespace App\Factory;

use App\Entity\EntityInterface;

interface FactoryInterface
{
    /**
     * @return EntityInterface
     */
    public static function createEntity(): EntityInterface;
}