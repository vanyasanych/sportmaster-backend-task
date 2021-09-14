<?php

namespace App\Tests\Controller;

use App\Entity\Cart;
use App\Entity\ProductGroup;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CartControllerTest extends AbstractApiTestCase
{
    /**
     * @return array
     */
    public function testCreate(): array
    {
        $product1 = $this->createProduct(1, '1');
        $product2 = $this->createProduct(2, '2');

        $expectedCart = [
            'product_groups' => [
                [
                    'product_id' => $product1->getId(),
                    'product_count' => 2,
                ],
                [
                    'product_id' => $product2->getId(),
                    'product_count' => 5,
                ]
            ],
        ];

        self::$client->request(Request::METHOD_POST, '/carts', $expectedCart);

        $this->assertSame(Response::HTTP_CREATED, self::$client->getResponse()->getStatusCode());

        $actualCart = json_decode(self::$client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('id', $actualCart);
        $expectedCart['id'] = $actualCart['id'];

        for ($i = 0; $i < count($actualCart['product_groups']); $i++) {
            $expectedCart['product_groups'][$i]['id'] = $actualCart['product_groups'][$i]['id'];
        }

        $this->assertEquals($expectedCart, $actualCart);

        return $expectedCart;
    }

    /**
     * @param int $sdk
     * @param string $sku
     *
     * @return Product
     */
    private function createProduct(int $sdk, string $sku): Product
    {
        $product = new Product();
        $product
            ->setSdk($sdk)
            ->setSku($sku)
        ;

        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();

        return $product;
    }

    protected function getUsedEntities(): array
    {
        return [
            Cart::class,
            Product::class,
            ProductGroup::class,
        ];
    }
}