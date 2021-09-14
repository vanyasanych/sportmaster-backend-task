<?php

namespace App\Tests\DTO\Response;

use App\DTO\Response\DeliveryResponse;
use App\DTO\Response\ResponsibleStoreResponse;
use App\Tests\Controller\AbstractApiTestCase;

class DeliveryResponseTest extends AbstractApiTestCase
{

    public function testCreate()
    {
        $expectedData = [
            'product_id' => 1,
            'responsible_stores' => [
                $this->createResponsibleStoreResponse(),
            ],
            'delivery_count' => 1,
        ];

        $deliveryResponse = new DeliveryResponse(
            $expectedData['product_id'],
            $expectedData['delivery_count'],
            $expectedData['responsible_stores'],
        );
        $this->assertInstanceOf(DeliveryResponse::class, $deliveryResponse);
        $this->assertSame($expectedData['product_id'], $deliveryResponse->getProductId());
        $this->assertSame($expectedData['delivery_count'], $deliveryResponse->getDeliveryCount());
        $this->assertEquals($expectedData['responsible_stores'], $deliveryResponse->getStores());
    }

    public function createResponsibleStoreResponse(): ResponsibleStoreResponse
    {
        return new ResponsibleStoreResponse(1);
    }

    protected function getUsedEntities(): array
    {
        return [

        ];
    }
}