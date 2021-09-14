<?php

namespace App\Tests\Controller\Allocator;

use App\Entity\Cart;
use App\Entity\Inventory;
use App\Entity\Product;
use App\Entity\ProductGroup;
use App\Entity\Store;
use App\Tests\Controller\AbstractApiTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractAllocatorControllerTest  extends AbstractApiTestCase
{
    protected function getActualData(): array
    {
        foreach ($this->requestedStoresData() as $storeData) {
            self::$client->request(Request::METHOD_POST, '/stores', $storeData);
        }
        foreach ($this->requestedProductsData() as $productData) {
            self::$client->request(Request::METHOD_POST, '/products', $productData);
        }
        foreach ($this->requestedInventoriesData() as $inventoryData) {
            self::$client->request(Request::METHOD_POST, '/inventories', $inventoryData);
        }
        self::$client->request(Request::METHOD_POST, '/carts', $this->requestedCartData());
        self::$client->request(Request::METHOD_GET, '/allocate/1');
        $this->assertSame(Response::HTTP_OK, self::$client->getResponse()->getStatusCode());

        return json_decode(self::$client->getResponse()->getContent(), true);
    }

    abstract public function expectedData(): array;
    abstract public function requestedCartData(): array;
    abstract public function requestedInventoriesData(): array;
    abstract public function requestedProductsData(): array;
    abstract public function requestedStoresData(): array;

    protected function getUsedEntities(): array
    {
        return [
            Product::class,
            Store::class,
            Inventory::class,
            ProductGroup::class,
            Cart::class,
        ];
    }
}