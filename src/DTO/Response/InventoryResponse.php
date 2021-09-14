<?php

namespace App\DTO\Response;

use App\Entity\Inventory;
use App\Entity\Product;

class InventoryResponse implements ResponseInterface
{

    private ?int $id;
    private ?int $productId;
    private ?int $storeId;
    private ?int $quantity;

    /**
     * @param Inventory|null $inventory
     */
    public function __construct(?Inventory $inventory)
    {
        if (!is_null($inventory)) {
            $this->id = $inventory->getId();
            $this->productId = $inventory->getProduct()->getId();
            $this->storeId = $inventory->getStore()->getId();
            $this->quantity = $inventory->getQuantity();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @return int|null
     */
    public function getStoreId(): ?int
    {
        return $this->storeId;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }
}