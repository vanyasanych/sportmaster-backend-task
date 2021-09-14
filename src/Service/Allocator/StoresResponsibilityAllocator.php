<?php

namespace App\Service\Allocator;

use App\DTO\Response\DeliveryResponse;
use App\Entity\Cart;
use App\Entity\ProductGroup;
use App\Service\Allocator\ResponseBuilder\DeliveryResponseBuilder;
use App\Service\Allocator\Selector\PriorityStoresSelector;
use App\Service\Allocator\Selector\RandomStoresSelector;
use App\Service\EntityManager\CartManager;

class StoresResponsibilityAllocator
{
    /**
     * @var PriorityStoresSelector
     */
    private PriorityStoresSelector $priorityStoresSelector;

    /**
     * @var RandomStoresSelector
     */
    private RandomStoresSelector $randomStoresSelector;

    /**
     * @var CartManager
     */
    private CartManager $cartManager;

    /**
     * @param PriorityStoresSelector $priorityStoresSelector
     * @param RandomStoresSelector $randomStoresSelector
     * @param CartManager $cartManager
     */
    public function __construct(
        PriorityStoresSelector $priorityStoresSelector,
        RandomStoresSelector $randomStoresSelector,
        CartManager $cartManager
    ) {
        $this->priorityStoresSelector = $priorityStoresSelector;
        $this->randomStoresSelector = $randomStoresSelector;
        $this->cartManager = $cartManager;
    }

    /**
     * @param Cart $cart
     *
     * @return DeliveryResponse[]|array
     */
    public function allocate(Cart $cart): array
    {
        $deliveriesResponses = [];
        /** @var ProductGroup $productGroup */
        foreach ($cart->getProductGroups() as $productGroup) {

            $resultStores = $productGroup->getProductCount() === 1
                ? $this->randomStoresSelector->getResponsibleStoresResponses($productGroup)
                : $this->priorityStoresSelector->getResponsibleStoresResponses($productGroup)
            ;

            if (count($resultStores) === 0) {
                $cart->removeCartProduct($productGroup);
                continue;
            }

            $deliveriesResponses[] = DeliveryResponseBuilder::build($productGroup, $resultStores);
        }

        $this->cartManager->update($cart);

        return $deliveriesResponses;
    }
}