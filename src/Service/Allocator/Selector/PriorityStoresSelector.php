<?php

namespace App\Service\Allocator\Selector;

use App\DTO\Response\ResponsibleStoreResponse;
use App\Entity\ProductGroup;
use App\Service\Allocator\ResponseBuilder\ResponsibleStoreResponseBuilder;
use App\Service\EntityManager\StoreManager;

class PriorityStoresSelector
{
    /**
     * @var StoreManager
     */
    private StoreManager $storeManager;

    private ResponsibleStoreResponseBuilder $responsibleStoreResponseBuilder;

    /**
     * @param StoreManager $storeManager
     * @param ResponsibleStoreResponseBuilder $responsibleStoreResponseBuilder
     */
    public function __construct(StoreManager $storeManager, ResponsibleStoreResponseBuilder $responsibleStoreResponseBuilder)
    {
        $this->storeManager = $storeManager;
        $this->responsibleStoreResponseBuilder = $responsibleStoreResponseBuilder;
    }
    /**
     * @param ProductGroup $productGroup
     *
     * @return ResponsibleStoreResponse[]|array
     */
    public function getResponsibleStoresResponses(ProductGroup $productGroup): array
    {
        $result = [];
        if ($productGroup->getProductCount() > 1) {
            $priorityStoresProductQuantities = $this->storeManager->findPriorityStoresProductQuantityByProduct(
                $productGroup->getProduct()
            );

            $result = $this->responsibleStoreResponseBuilder->buildResponseByPriorityQuantities(
                $priorityStoresProductQuantities,
                $productGroup
            );
        }

        return $result;
    }
}