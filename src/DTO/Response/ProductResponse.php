<?php

namespace App\DTO\Response;

use App\Entity\Product;

class ProductResponse implements ResponseInterface
{
    private ?int $id;
    private ?int $sdk;
    private ?string $sku;

    /**
     * @param Product|null $product
     */
    public function __construct(?Product $product)
    {
        if (!is_null($product)) {
            $this->id = $product->getId();
            $this->sdk = $product->getSdk();
            $this->sku = $product->getSku();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getSdk(): ?int
    {
        return $this->sdk;
    }

    /**
     * @return string|null
     */
    public function getSku(): ?string
    {
        return $this->sku;
    }


}