<?php

namespace App\DTO\Request;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\ShopNameUnique;

class StoreRequest implements RequestInterface
{
    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"create"})
     * @ShopNameUnique
     */
    private string $name;

    /**
     * @var int
     *
     * @Assert\NotBlank(groups={"create"})
     */
    private int $priority;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }
}