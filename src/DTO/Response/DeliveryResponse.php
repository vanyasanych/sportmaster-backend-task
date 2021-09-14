<?php

namespace App\DTO\Response;

class DeliveryResponse
{
    /**
     * @var int
     */
    private int $product_id;

    /**
     * @var int
     */
    private int $deliveryCount;

    /**
     * @var array
     */
    private array $responsibleStores;

    /**
     * @param int $product_id
     * @param int $deliveryCount
     * @param ResponsibleStoreResponse[]|array $responsibleStores
     */
    public function __construct(int $product_id, int $deliveryCount, array $responsibleStores)
    {
        $this->product_id = $product_id;
        $this->deliveryCount = $deliveryCount;
        $this->responsibleStores = $responsibleStores;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->product_id;
    }

    /**
     * @return int
     */
    public function getDeliveryCount(): int
    {
        return $this->deliveryCount;
    }

    /**
     * @return ResponsibleStoreResponse[]|array
     */
    public function getStores(): array
    {
        return $this->responsibleStores;
    }
}