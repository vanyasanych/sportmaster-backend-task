<?php

namespace App\Tests\Controller;

use App\Entity\Inventory;
use App\Entity\Product;
use App\Entity\Store;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InventoryControllerTest extends AbstractApiTestCase
{
    /**
     * @return array
     */
    public function testCreate(): array
    {
        $product = $this->createProduct();
        $store = $this->createStore();

        $expectedInventory = [
            "quantity" =>  10,
            "store_id" =>  $store->getId(),
            "product_id" => $product->getId(),
        ];

        self::$client->request(Request::METHOD_POST, '/inventories', $expectedInventory);

        $this->assertSame(Response::HTTP_CREATED, self::$client->getResponse()->getStatusCode());

        $actualInventory = json_decode(self::$client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('id', $actualInventory);
        $expectedInventory['id'] = $actualInventory['id'];

        $this->assertEquals($expectedInventory, $actualInventory);

        return $expectedInventory;
    }

    /**
     * @return Product
     */
    private function createProduct(): Product
    {
        $product = new Product();
        $product
            ->setSdk(123)
            ->setSku('123')
        ;

        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();

        return $product;
    }

    /**
     * @return Store
     */
    private function createStore(): Store
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

    /**
     * @return string[]
     */
    protected function getUsedEntities(): array
    {
        return [
            Inventory::class,
            Product::class,
            Store::class,
        ];
    }
}