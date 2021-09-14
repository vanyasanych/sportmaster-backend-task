<?php

namespace App\Tests\Controller;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductControllerTest extends AbstractApiTestCase
{
    /**
     * @return array
     */
    public function testCreate(): array
    {
        $expectedProduct = [
            'sdk' => 123,
            'sku' => "123",
        ];

        self::$client->request(Request::METHOD_POST, '/products', $expectedProduct);

        $this->assertSame(Response::HTTP_CREATED, self::$client->getResponse()->getStatusCode());

        $actualProduct = json_decode(self::$client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('id', $actualProduct);
        $expectedProduct['id'] = $actualProduct['id'];

        $this->assertEquals($expectedProduct, $actualProduct);

        return $expectedProduct;
    }

    protected function getUsedEntities(): array
    {
        return [
            Product::class,
        ];
    }
}