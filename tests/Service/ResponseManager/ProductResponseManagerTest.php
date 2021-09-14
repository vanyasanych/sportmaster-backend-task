<?php

namespace App\Tests\Service\ResponseManager;

use App\DTO\Response\ProductResponse;
use App\Entity\Product;
use App\Service\ResponseManager\ProductResponseManager;
use App\Tests\Controller\AbstractApiTestCase;

class ProductResponseManagerTest extends AbstractApiTestCase
{
    public function testCreatDTO()
    {
        $productResponseManager = new ProductResponseManager();
        $product = $this->createProduct();
        $productResponse = $productResponseManager->createDTO($product);

        $this->assertInstanceOf(ProductResponse::class, $productResponse);
        $this->assertSame($product->getId(), $productResponse->getId());
        $this->assertSame($product->getSku(), $productResponse->getSku());
        $this->assertSame($product->getSdk(), $productResponse->getSdk());
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
            Product::class,
        ];
    }
}