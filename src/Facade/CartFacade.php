<?php

namespace App\Facade;

use App\DTO\Request\CartRequest;
use App\DTO\Request\RequestInterface;
use App\Entity\Cart;
use App\Entity\EntityInterface;
use App\Factory\CartProductFactory;
use App\Service\EntityManager\CartManager;

class CartFacade
{
    /**
     * @var CartManager
     */
    private CartManager $cartManager;

    /**
     * @param CartManager $cartManager
     */
    public function __construct(CartManager $cartManager)
    {
        $this->cartManager = $cartManager;
    }

    /**
     * @param RequestInterface $cartRequest
     *
     * @return Cart
     */
    public function createByRequest(RequestInterface $cartRequest): Cart
    {
        $cart = $this->cartManager->create();

        return $this->updateByRequest($cart, $cartRequest);
    }

    /**
     * @param Cart $cart
     * @param CartRequest|RequestInterface $cartRequest
     *
     * @return Cart
     */
    public function updateByRequest(EntityInterface $cart, RequestInterface $cartRequest): Cart
    {
        foreach ($cartRequest->getGroupProducts() as $groupProduct) {
            $productGroup = CartProductFactory::createEntity();

            $productGroup
                ->setProduct($groupProduct->getProduct())
                ->setProductCount($groupProduct->getCount())
            ;
            $cart->addProductGroup($productGroup);
        }

        $this->cartManager->update($cart);

        return $cart;
    }
}