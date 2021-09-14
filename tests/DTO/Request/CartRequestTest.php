<?php

namespace App\Tests\DTO\Request;

use App\DTO\Request\CartRequest;
use App\DTO\Request\GroupProductRequest;
use App\Entity\Product;
use App\Tests\Controller\AbstractApiTestCase;

class CartRequestTest extends AbstractApiTestCase
{
    public function testCreate()
    {
        $productGroupRequests = [
            $this->createProductGroupRequest(),
        ];

        $cartRequest = new CartRequest();

        $cartRequest->setGroupProducts($productGroupRequests);

        $this->assertInstanceOf(CartRequest::class, $cartRequest);

        $this->assertEquals($productGroupRequests, $cartRequest->getGroupProducts());
    }

    public function createProductGroupRequest(): GroupProductRequest
    {
        $productGroupRequest = new GroupProductRequest();
        $productGroupRequest
            ->setProduct($this->createProduct())
            ->setCount(1)
        ;

        return $productGroupRequest;
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