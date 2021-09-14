<?php

namespace App\Tests\DTO\Request;

use App\DTO\Request\ProductRequest;
use App\DTO\Request\StoreRequest;
use App\Tests\Controller\AbstractApiTestCase;

class ProductRequestTest extends AbstractApiTestCase
{

    public function testCreate()
    {
        $expectedData = [
            'sdk' => 1,
            'sku' => '1',
        ];

        $productRequest = new ProductRequest();

        $productRequest
            ->setSdk($expectedData['sdk'])
            ->setSku($expectedData['sku'])
        ;

        $this->assertInstanceOf(ProductRequest::class, $productRequest);
        $this->assertSame($expectedData['sdk'], $productRequest->getSdk());
        $this->assertSame($expectedData['sku'], $productRequest->getSku());
    }

    protected function getUsedEntities(): array
    {
        return [];
    }
}