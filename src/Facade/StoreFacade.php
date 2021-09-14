<?php

namespace App\Facade;

use App\DTO\Request\RequestInterface;
use App\DTO\Request\StoreRequest;
use App\Entity\EntityInterface;
use App\Entity\Store;
use App\Service\EntityManager\StoreManager;

class StoreFacade implements EntityFacadeInterface
{
    /**
     * @var StoreManager
     */
    private StoreManager $storeManager;

    /**
     * @param StoreManager $storeManager
     */
    public function __construct(StoreManager $storeManager)
    {
        $this->storeManager = $storeManager;
    }

    /**
     * @param StoreRequest|RequestInterface $request
     *
     * @return Store
     */
    public function createByRequest(RequestInterface $request): Store
    {
        $store = $this->storeManager->create();

        return $this->updateByRequest($store, $request);
    }

    /**
     * @param Store|EntityInterface $entity
     * @param StoreRequest|RequestInterface $request
     *
     * @return Store
     */
    public function updateByRequest(EntityInterface $entity, RequestInterface $request): Store
    {
        $entity
            ->setPriority($request->getPriority())
            ->setName($request->getName())
        ;

        $this->storeManager->update($entity);

        return $entity;
    }
}