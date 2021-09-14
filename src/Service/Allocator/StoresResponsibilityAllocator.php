<?php

namespace App\Service\Allocator;

use App\DTO\Response\DeliveryResponse;
use App\DTO\Response\ResponsibleStoreResponse;
use App\Entity\Cart;
use App\Entity\ProductGroup;
use App\Service\EntityManager\CartManager;
use App\Service\EntityManager\InventoryManager;
use App\Service\EntityManager\StoreManager;

class StoresResponsibilityAllocator
{
    /**
     * @var StoreManager
     */
    private StoreManager $storeManager;

    /**
     * @var CartManager
     */
    private CartManager $cartManager;

    /**
     * @var InventoryManager
     */
    private InventoryManager $inventoryManager;

    /**
     * @param StoreManager $storeManager
     * @param CartManager $cartManager
     * @param InventoryManager $inventoryManager
     */
    public function __construct(
        StoreManager $storeManager,
        CartManager $cartManager,
        InventoryManager $inventoryManager
    ) {
        $this->storeManager = $storeManager;
        $this->cartManager = $cartManager;
        $this->inventoryManager = $inventoryManager;
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
            $resultStoresIds = [];
            if ($productGroup->getProductCount() === 1) {
                $stores = $this->storeManager->findStoresByProduct($productGroup->getProduct());
                $storesCount = count($stores);

                if ($storesCount === 0) {
                    $cart->removeCartProduct($productGroup);
                    continue;
                } else {
                    $storeRandomIndex = rand(0, $storesCount - 1);
                    $resultStoresIds[] = new ResponsibleStoreResponse($stores[$storeRandomIndex]->getId());
                }
            } else {
                $priorityStoresProductQuantities = $this->storeManager->findPriorityStoresProductQuantityByProduct(
                    $productGroup->getProduct()
                );

                $storesCount = count($priorityStoresProductQuantities);
                if ($storesCount === 0) {
                    $cart->removeCartProduct($productGroup);
                    continue;
                }

                $storesCounter = 0;
                $priorityStoresProductQuantitySum = 0;
                foreach ($priorityStoresProductQuantities as $priorityStoresProductQuantity) {

                    $priorityStoresProductQuantitySum += $priorityStoresProductQuantity;

                    $storesCounter++;
                    dump("storesCounter = {$storesCounter}");
                    dump("priorityStoresProductQuantitySum = {$priorityStoresProductQuantitySum}");
                    dump("priorityStoresProductQuantity = {$priorityStoresProductQuantity}");
                    dump("CountInCart = {$productGroup->getProductCount()}");

                    if ($priorityStoresProductQuantitySum >= $productGroup->getProductCount()) {
                        dump("exit");
                        dump("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");

                        break;
                    }
                    dump("------------------------------------------------------------");
                }
                $resultStoresIds = $this->storeManager->findPriorityStoresIdsByLimit(
                    $productGroup->getProduct(),
                    $storesCounter
                );
            }

            $deliveriesResponses[] = new DeliveryResponse(
                $productGroup->getProduct()->getId(),
                $productGroup->getProductCount(),
                $resultStoresIds
            );
        }


        $this->cartManager->update($cart);

        return $deliveriesResponses;
    }
}