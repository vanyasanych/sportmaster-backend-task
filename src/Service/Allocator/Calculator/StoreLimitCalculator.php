<?php

namespace App\Service\Allocator\Calculator;

class StoreLimitCalculator
{
    /**
     * @param array $priorityStoresProductQuantities
     * @param int $productCount
     *
     * @return int
     */
    public static function calculate(array $priorityStoresProductQuantities, int $productCount): int
    {
        $storesCounter = 0;
        $priorityStoresProductQuantitySum = 0;
        foreach ($priorityStoresProductQuantities as $priorityStoresProductQuantity) {

            $priorityStoresProductQuantitySum += $priorityStoresProductQuantity;

            $storesCounter++;
            if ($priorityStoresProductQuantitySum >= $productCount) {
                break;
            }
        }

        return $storesCounter;
    }
}