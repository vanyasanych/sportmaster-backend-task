<?php

namespace App\Tests\DTO\Request;

use App\DTO\Request\InventoryRequest;
use App\Entity\Inventory;
use App\Entity\Product;
use App\Entity\Store;
use App\Tests\Controller\AbstractApiTestCase;

class InventoryRequestTest extends AbstractApiTestCase
{

    public function testCreate()
    {
        $expectedData = [
            'quantity' => 1,
            'product' => $this->createProduct(),
            'store' => $this->createStore(),
        ];

        $inventoryRequest = new InventoryRequest();

        $inventoryRequest
            ->setQuantity($expectedData['quantity'])
            ->setProduct($expectedData['product'])
            ->setStore($expectedData['store'])
        ;

        $this->assertInstanceOf(InventoryRequest::class, $inventoryRequest);
        $this->assertSame($expectedData['quantity'], $inventoryRequest->getQuantity());
        $this->assertSame($expectedData['product'], $inventoryRequest->getProduct());
        $this->assertSame($expectedData['store'], $inventoryRequest->getStore());
    }

    /**
     * @return Product
     */
    public function createProduct(): Product
    {
        $product = new Product();

        $product
            ->setSdk(1)
            ->setSku('1')
        ;

        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();

        return $product;
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
            Product::class,
            Inventory::class,
        ];
    }
}