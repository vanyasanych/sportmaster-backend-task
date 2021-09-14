<?php

namespace App\DTO\Response;

use App\Entity\Cart;
use App\Entity\ProductGroup;
use App\Entity\Product;

class CartResponse implements ResponseInterface
{
    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var ProductGroup[]|array
     */
    private array $productGroups;

    /**
     * @param Cart|null $cart
     */
    public function __construct(?Cart $cart)
    {
        if (!is_null($cart)) {
            $this->id = $cart->getId();
            $this->productGroups = $cart->getProductGroups()->map(function (ProductGroup $cartProduct) {
                return new ProductGroupResponse($cartProduct);
            })->toArray();
        }
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return ProductGroupResponse[]|array
     */
    public function getProductGroups(): array
    {
        return $this->productGroups;
    }
}