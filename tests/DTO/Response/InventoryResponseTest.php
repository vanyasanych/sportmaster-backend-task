<?php

namespace App\Tests\DTO\Response;

use App\DTO\Response\InventoryResponse;
use App\Entity\Inventory;
use App\Entity\Product;
use App\Entity\Store;
use App\Tests\Controller\AbstractApiTestCase;

class InventoryResponseTest extends AbstractApiTestCase
{
    public function testCreate()
    {
        $inventory = $this->createInventory();

        $inventoryResponse = new InventoryResponse($inventory);
        $this->assertInstanceOf(InventoryResponse::class, $inventoryResponse);
        $this->assertSame($inventory->getId(), $inventoryResponse->getId());
        $this->assertSame($inventory->getProduct()->getId(), $inventoryResponse->getProductId());
        $this->assertSame($inventory->getStore()->getId(), $inventoryResponse->getStoreId());
        $this->assertSame($inventory->getQuantity(), $inventoryResponse->getQuantity());
    }

    /**
     * @return Inventory
     */
    public function createInventory(): Inventory
    {
        $inventory = new Inventory();

        $inventory
            ->setProduct($this->createProduct())
            ->setStore($this->createStore())
            ->setQuantity(1)
        ;

        $this->getEntityManager()->persist($inventory);
        $this->getEntityManager()->flush();

        return $inventory;
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
            Inventory::class,
            Product::class,
            Store::class,
        ];
    }
}