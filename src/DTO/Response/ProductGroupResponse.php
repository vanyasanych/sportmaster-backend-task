<?php

namespace App\DTO\Response;

use App\Entity\ProductGroup;

class ProductGroupResponse
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var int
     */
    private int $productId;

    /**
     * @var int
     */
    private int $productCount;

    /**
     * @param ProductGroup|null $cartProduct
     */
    public function __construct(?ProductGroup $cartProduct)
    {
        if (!is_null($cartProduct)) {
            $this->id = $cartProduct->getId();
            $this->productId = $cartProduct->getProduct()->getId();
            $this->productCount = $cartProduct->getProductCount();
        }

    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @return int
     */
    public function getProductCount(): int
    {
        return $this->productCount;
    }


}