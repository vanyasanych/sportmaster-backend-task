<?php

namespace App\Service\Allocator\ResponseBuilder;

use App\DTO\Response\DeliveryResponse;
use App\DTO\Response\ResponsibleStoreResponse;
use App\Entity\ProductGroup;

class DeliveryResponseBuilder
{
    /**
     * @param ProductGroup $productGroup
     * @param ResponsibleStoreResponse[]|array $responsibleStores
     *
     * @return DeliveryResponse
     */
    public static function build(ProductGroup $productGroup, array $responsibleStores): DeliveryResponse
    {
        return new DeliveryResponse(
            $productGroup->getProduct()->getId(),
            $productGroup->getProductCount(),
            $responsibleStores
        );
    }
}