<?php

namespace App\DTO\Request;

class CartRequest implements RequestInterface
{
    /**
     * @var GroupProductRequest[]|array|null
     */
    private ?array $groupProducts;

    /**
     * @return GroupProductRequest[]|array|null
     */
    public function getGroupProducts(): ?array
    {
        return $this->groupProducts;
    }

    /**
     * @param GroupProductRequest[]|array|null $groupProducts
     */
    public function setGroupProducts(?array $groupProducts): void
    {
        $this->groupProducts = $groupProducts;
    }


}