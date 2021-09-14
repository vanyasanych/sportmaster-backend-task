<?php

namespace App\Tests\Controller;

use App\Entity\Store;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StoreControllerTest extends AbstractApiTestCase
{
    /**
     * @return array
     */
    public function testCreate(): array
    {
        $expectedStore = [
            'name' => 'store1',
            'priority' => 1
        ];

        self::$client->request(Request::METHOD_POST, '/stores', $expectedStore);

        $this->assertSame(Response::HTTP_CREATED, self::$client->getResponse()->getStatusCode());

        $actualStore = json_decode(self::$client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('id', $actualStore);
        $expectedStore['id'] = $actualStore['id'];

        $this->assertEquals($expectedStore, $actualStore);

        return $expectedStore;
    }

    protected function getUsedEntities(): array
    {
        return [
            Store::class,
        ];
    }
}