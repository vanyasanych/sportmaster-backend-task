<?php

namespace App\Tests\DTO\Response;

use App\DTO\Response\ProductResponse;
use App\Entity\Product;
use App\Tests\Controller\AbstractApiTestCase;

class ProductResponseTest extends AbstractApiTestCase
{
    public function testCreate()
    {
        $product = $this->createProduct();

        $productResponse = new ProductResponse($product);

        $this->assertInstanceOf(ProductResponse::class, $productResponse);
        $this->assertSame($product->getId(), $productResponse->getId());
        $this->assertSame($product->getSdk(), $productResponse->getSdk());
        $this->assertSame($product->getSku(), $productResponse->getSku());
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

    protected function getUsedEntities(): array
    {
        return [
            Product::class
        ];
    }
}