<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product implements EntityInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $sdk;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sku;

    /**
     * @ORM\OneToMany(targetEntity=Inventory::class, mappedBy="product", orphanRemoval=true)
     */
    private $inventories;

    /**
     * @ORM\OneToMany(targetEntity=ProductGroup::class, mappedBy="product", orphanRemoval=true)
     */
    private $productGroups;

    public function __construct()
    {
        $this->inventories = new ArrayCollection();
        $this->productGroups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSdk(): ?int
    {
        return $this->sdk;
    }

    public function setSdk(int $sdk): self
    {
        $this->sdk = $sdk;

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * @return Collection|Inventory[]
     */
    public function getInventories(): Collection
    {
        return $this->inventories;
    }

    public function addInventory(Inventory $inventory): self
    {
        if (!$this->inventories->contains($inventory)) {
            $this->inventories[] = $inventory;
            $inventory->setProduct($this);
        }

        return $this;
    }

    public function removeInventory(Inventory $inventory): self
    {
        if ($this->inventories->removeElement($inventory)) {
            // set the owning side to null (unless already changed)
            if ($inventory->getProduct() === $this) {
                $inventory->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProductGroup[]
     */
    public function getProductGroups(): Collection
    {
        return $this->productGroups;
    }

    public function addProductGroups(ProductGroup $productGroup): self
    {
        if (!$this->productGroups->contains($productGroup)) {
            $this->productGroups[] = $productGroup;
            $productGroup->setProduct($this);
        }

        return $this;
    }

    public function removeCartProduct(ProductGroup $productGroup): self
    {
        if ($this->productGroups->removeElement($productGroup)) {
            // set the owning side to null (unless already changed)
            if ($productGroup->getProduct() === $this) {
                $productGroup->setProduct(null);
            }
        }

        return $this;
    }
}
