<?php

namespace App\Facade;

use App\DTO\Request\InventoryRequest;
use App\DTO\Request\RequestInterface;
use App\Entity\EntityInterface;
use App\Entity\Inventory;
use App\Service\EntityManager\InventoryManager;

class InventoryFacade
{
    /**
     * @var InventoryManager
     */
    private InventoryManager $inventoryManager;

    /**
     * @param InventoryManager $inventoryManager
     */
    public function __construct(InventoryManager $inventoryManager)
    {
        $this->inventoryManager = $inventoryManager;
    }

    /**
     * @param RequestInterface $request
     *
     * @return Inventory
     */
    public function createByRequest(RequestInterface $request): Inventory
    {
        $inventory = $this->inventoryManager->create();

        return $this->updateByRequest($inventory, $request);
    }

    /**
     * @param Inventory|EntityInterface $entity
     * @param InventoryRequest|RequestInterface $request
     *
     * @return Inventory
     */
    public function updateByRequest(EntityInterface $entity, RequestInterface $request): Inventory
    {
        $entity
            ->setProduct($request->getProduct())
            ->setQuantity($request->getQuantity())
            ->setStore($request->getStore())
        ;

        $this->inventoryManager->update($entity);

        return $entity;
    }
}