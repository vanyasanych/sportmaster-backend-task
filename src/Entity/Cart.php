<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartRepository::class)
 */
class Cart implements EntityInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=ProductGroup::class, mappedBy="cart", orphanRemoval=true, cascade={"persist"})
     */
    private $productGroups;

    public function __construct()
    {
        $this->productGroups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|ProductGroup[]
     */
    public function getProductGroups(): Collection
    {
        return $this->productGroups;
    }

    public function addProductGroup(ProductGroup $productGroup): self
    {
        if (!$this->productGroups->contains($productGroup)) {
            $this->productGroups[] = $productGroup;
            $productGroup->setCart($this);
        }

        return $this;
    }

    public function removeCartProduct(ProductGroup $productGroup): self
    {
        if ($this->productGroups->removeElement($productGroup)) {
            // set the owning side to null (unless already changed)
            if ($productGroup->getCart() === $this) {
                $productGroup->setCart(null);
            }
        }

        return $this;
    }
}
