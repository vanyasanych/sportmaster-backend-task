<?php

namespace App\Facade;

use App\DTO\Request\ProductRequest;
use App\DTO\Request\RequestInterface;
use App\Entity\EntityInterface;
use App\Entity\Product;
use App\Service\EntityManager\ProductManager;

class ProductFacade
{
    /**
     * @var ProductManager
     */
    private ProductManager $productManager;

    /**
     * @param ProductManager $productManager
     */
    public function __construct(ProductManager $productManager)
    {
        $this->productManager = $productManager;
    }

    /**
     * @param RequestInterface $request
     *
     * @return Product
     */
    public function createByRequest(RequestInterface $request): Product
    {
        $product = $this->productManager->create();

        return $this->updateByRequest($product, $request);
    }

    /**
     * @param Product|EntityInterface $entity
     * @param ProductRequest|RequestInterface $request
     *
     * @return Product
     */
    public function updateByRequest(EntityInterface $entity, RequestInterface $request): Product
    {
        $entity
            ->setSdk($request->getSdk())
            ->setSku($request->getSku())
        ;

        $this->productManager->update($entity);

        return $entity;
    }
}