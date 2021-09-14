<?php

namespace App\Tests\DTO\Response;

use App\DTO\Response\ResponsibleStoreResponse;
use App\Tests\Controller\AbstractApiTestCase;

class ResponsibleStoreResponseTest extends AbstractApiTestCase
{

    public function testCreate()
    {
        $expectedData = [
            'id' => 1,
        ];

        $responsibleStoreResponse = new ResponsibleStoreResponse($expectedData['id']);

        $this->assertInstanceOf(ResponsibleStoreResponse::class, $responsibleStoreResponse);
        $this->assertSame($expectedData['id'], $responsibleStoreResponse->getId());
    }

    protected function getUsedEntities(): array
    {
        return [];
    }
}