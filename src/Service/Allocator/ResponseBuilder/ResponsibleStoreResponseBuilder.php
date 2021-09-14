<?php

namespace App\Service\Allocator\ResponseBuilder;

use App\DTO\Response\ResponsibleStoreResponse;
use App\Entity\ProductGroup;
use App\Service\Allocator\Calculator\StoreLimitCalculator;
use App\Service\EntityManager\StoreManager;

class ResponsibleStoreResponseBuilder
{
    private StoreManager $storeManager;

    /**
     * @param StoreManager $storeManager
     */
    public function __construct(StoreManager $storeManager)
    {
        $this->storeManager = $storeManager;
    }


    /**
     * @param array $stores
     *
     * @return ResponsibleStoreResponse[]|array
     */
    public function buildResponseByStoresWithRandom(array $stores): array
    {
        $storesCount = count($stores);
        $result = [];
        if ($storesCount !== 0) {
            $storeRandomIndex = rand(0, $storesCount - 1);
            $store = $stores[$storeRandomIndex];

            $result[] = new ResponsibleStoreResponse($store->getId());
        }

        return $result;
    }


    /**
     * @param array $quantities
     * @param ProductGroup $productGroup
     * @return ResponsibleStoreResponse[]|array
     */
    public function buildResponseByPriorityQuantities(array $quantities, ProductGroup $productGroup): array
    {
        $storesCount = count($quantities);
        $resultStores = [];
        if ($storesCount !== 0) {
            $storesCounter = StoreLimitCalculator::calculate($quantities, $productGroup->getProductCount());

            $resultStoresIds = $this->storeManager->getResponsibleStoreIdsByLimit(
                $productGroup->getProduct(),
                $storesCounter
            );

            $resultStores = ResponsibleStoreResponseBuilder::buildResponsesByStoresIds($resultStoresIds);
        }

        return $resultStores;
    }

    /**
     * @param array $storesData
     *
     * @return ResponsibleStoreResponse[]|array
     */
    public static function buildResponsesByStoresIds(array $storesData): array
    {
        $data = [];
        foreach ($storesData as $storeData) {
            $data[] = new ResponsibleStoreResponse($storeData['id']);
        }

        return $data;
    }
}