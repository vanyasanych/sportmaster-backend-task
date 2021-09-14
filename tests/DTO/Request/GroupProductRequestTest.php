<?php

namespace App\Tests\DTO\Request;

use App\DTO\Request\GroupProductRequest;
use App\Entity\Product;
use App\Tests\Controller\AbstractApiTestCase;

class GroupProductRequestTest extends AbstractApiTestCase
{
    public function testCreate()
    {
        $expectedData = [
            'product' => $this->createProduct(),
            'count' => 1,
        ];

        $groupProductRequest = new GroupProductRequest();

        $groupProductRequest
            ->setProduct($expectedData['product'])
            ->setCount($expectedData['count'])
        ;

        $this->assertInstanceOf(GroupProductRequest::class, $groupProductRequest);
        $this->assertSame($expectedData['product'], $groupProductRequest->getProduct());
        $this->assertSame($expectedData['count'], $groupProductRequest->getCount());
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