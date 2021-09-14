<?php

namespace App\DTO\Request;

use App\DTO\Request\RequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ProductRequest implements RequestInterface
{
    /**
     * @var int|null
     *
     * @Assert\NotBlank(groups={"create"})
     */
    private ?int $sdk;

    /**
     * @Assert\NotBlank(groups={"create"})
     */
    private ?string $sku;

    /**
     * @return int|null
     */
    public function getSdk(): ?int
    {
        return $this->sdk;
    }

    /**
     * @param int|null $sdk
     *
     * @return ProductRequest
     */
    public function setSdk(?int $sdk): self
    {
        $this->sdk = $sdk;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSku(): ?string
    {
        return $this->sku;
    }

    /**
     * @param string|null $sku
     *
     * @return ProductRequest
     */
    public function setSku(?string $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

}