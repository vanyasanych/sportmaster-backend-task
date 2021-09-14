<?php

namespace App\Service\Allocator\Calculator;

class StoreLimitCalculator
{
    /**
     * @param array $quantities
     * @param int $productCount
     *
     * @return int
     */
    public static function calculate(array $quantities, int $productCount): int
    {
        $storesCounter = 0;
        $quantitiesSum = 0;
        foreach ($quantities as $quantity) {

            $quantitiesSum += $quantity;

            $storesCounter++;
            if ($quantitiesSum >= $productCount) {
                break;
            }
        }

        return $storesCounter;
    }
}