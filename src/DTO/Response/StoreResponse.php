<?php

namespace App\DTO\Response;

use App\Entity\Store;

class StoreResponse implements ResponseInterface
{
    private ?int $id;
    private ?string $name;
    private ?int $priority;

    /**
     * @param Store|null $store
     */
    public function __construct(?Store $store)
    {
        if (!is_null($store)) {
            $this->id = $store->getId();
            $this->name = $store->getName();
            $this->priority = $store->getPriority();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return int|null
     */
    public function getPriority(): ?int
    {
        return $this->priority;
    }


}