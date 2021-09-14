<?php

namespace App\Tests\Service\ResponseManager;

use App\DTO\Response\StoreResponse;
use App\Entity\Store;
use App\Service\ResponseManager\StoreResponseManager;
use App\Tests\Controller\AbstractApiTestCase;

class StoreResponseManagerTest extends AbstractApiTestCase
{
    public function testCreatDTO()
    {
        $storeResponseManager = new StoreResponseManager();
        $store = $this->createStore();
        $storeResponse = $storeResponseManager->createDTO($store);

        $this->assertInstanceOf(StoreResponse::class, $storeResponse);
        $this->assertSame($store->getId(), $storeResponse->getId());
        $this->assertSame($store->getName(), $storeResponse->getName());
        $this->assertSame($store->getPriority(), $storeResponse->getPriority());
    }

    /**
     * @return Store
     */
    public function createStore(): Store
    {
        $store = new Store();

        $store
            ->setName('store')
            ->setPriority(1)
        ;

        $this->getEntityManager()->persist($store);
        $this->getEntityManager()->flush();

        return $store;
    }

    protected function getUsedEntities(): array
    {
        return [
            Store::class,
        ];
    }
}