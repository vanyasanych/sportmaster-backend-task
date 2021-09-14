<?php

namespace App\Tests\DTO\Response;

use App\DTO\Response\CartResponse;
use App\Entity\Cart;
use App\Tests\Controller\AbstractApiTestCase;

class CartResponseTest extends AbstractApiTestCase
{
    public function testCreate()
    {
        $cart = $this->createCart();

        $cartResponse = new CartResponse($cart);

        $this->assertSame($cart->getId(), $cartResponse->getId());
        $this->assertInstanceOf(CartResponse::class, $cartResponse);
    }

    /**
     * @return Cart
     */
    public function createCart(): Cart
    {
        $cart = new Cart();

        $this->getEntityManager()->persist($cart);
        $this->getEntityManager()->flush();

        return $cart;
    }

    protected function getUsedEntities(): array
    {
        return [
            Cart::class
        ];
    }
}