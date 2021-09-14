<?php

namespace App\DTO\Request;

use App\Entity\Product;

class GroupProductRequest implements RequestInterface
{
    /**
     * @var Product
     */
    private Product $product;

    /**
     * @var int
     */
    private int $count;

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     *
     * @return GroupProductRequest
     */
    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     *
     * @return GroupProductRequest
     */
    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }


}