<?php

namespace App\Tests\DTO\Request;

use App\DTO\Request\StoreRequest;
use App\Tests\Controller\AbstractApiTestCase;

class StoreRequestTest extends AbstractApiTestCase
{
    public function testCreate()
    {
        $expectedData = [
            'name' => 'Store 1',
            'priority' => 1,
        ];

        $storeRequest = new StoreRequest();

        $storeRequest
            ->setName($expectedData['name'])
            ->setPriority($expectedData['priority'])
        ;
        $this->assertInstanceOf(StoreRequest::class, $storeRequest);
        $this->assertSame($expectedData['name'], $storeRequest->getName());
        $this->assertSame($expectedData['priority'], $storeRequest->getPriority());
    }

    protected function getUsedEntities(): array
    {
        return [];
    }
}