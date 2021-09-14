<?php

namespace App\Tests\DTO\Response;

use App\DTO\Response\StoreResponse;
use App\Entity\Store;
use App\Tests\Controller\AbstractApiTestCase;

class StoreResponseTest extends AbstractApiTestCase
{
    public function testCreate()
    {
        $store = $this->createStore();

        $storeResponse = new StoreResponse($store);

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
            Store::class
        ];
    }
}