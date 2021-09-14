<?php

namespace App\Tests\Service\ResponseManager;

use App\DTO\Response\CartResponse;
use App\Entity\Cart;
use App\Service\ResponseManager\CartResponseManager;
use App\Tests\Controller\AbstractApiTestCase;

class CartResponseManagerTest extends AbstractApiTestCase
{
    public function testCreatDTO()
    {
        $cartResponseManager = new CartResponseManager();
        $cart = $this->createCart();
        $cartResponse = $cartResponseManager->createDTO($cart);

        $this->assertInstanceOf(CartResponse::class, $cartResponse);
        $this->assertSame($cart->getId(), $cartResponse->getId());
        $this->assertEquals($cart->getProductGroups()->toArray(), $cartResponse->getProductGroups());
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
            Cart::class,
        ];
    }
}