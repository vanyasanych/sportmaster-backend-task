<?php

namespace App\DTO\Request;

use App\DTO\Request\RequestInterface;
use App\Entity\Product;
use App\Entity\Store;
use Symfony\Component\Validator\Constraints as Assert;

class InventoryRequest implements RequestInterface
{
    /**
     * @var int|null
     *
     * @Assert\NotBlank(groups={"create"})
     * @Assert\GreaterThanOrEqual(value="0")
     */
    private ?int $quantity;

    /**
     * @var Store|null
     *
     * @Assert\NotBlank(groups={"create"})
     */
    private ?Store $store;

    /**
     * @var Product|null
     *
     * @Assert\NotBlank(groups={"create"})
     */
    private ?Product $product;

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getStore(): ?Store
    {
        return $this->store;
    }

    public function setStore(?Store $store): self
    {
        $this->store = $store;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}