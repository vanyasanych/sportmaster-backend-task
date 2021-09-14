<?php

namespace App\Tests\DTO\Response;

use App\DTO\Response\ProductGroupResponse;
use App\Entity\Cart;
use App\Entity\Product;
use App\Entity\ProductGroup;
use App\Tests\Controller\AbstractApiTestCase;

class ProductGroupResponseTest extends AbstractApiTestCase
{

    public function testCreate()
    {
        $productGroupGroup = $this->createProductGroup();

        $productGroupGroupResponse = new ProductGroupResponse($productGroupGroup);
        $this->assertInstanceOf(ProductGroupResponse::class, $productGroupGroupResponse);
        $this->assertSame($productGroupGroup->getId(), $productGroupGroupResponse->getId());
        $this->assertSame($productGroupGroup->getProduct()->getId(), $productGroupGroupResponse->getProductId());
        $this->assertSame($productGroupGroup->getProductCount(), $productGroupGroupResponse->getProductCount());
    }

    /**
     * @return ProductGroup
     */
    public function createProductGroup(): ProductGroup
    {
        $productGroupGroup = new ProductGroup();

        $productGroupGroup
            ->setProduct($this->createProduct())
            ->setCart($this->createCart())
            ->setProductCount(1)
        ;

        $this->getEntityManager()->persist($productGroupGroup);
        $this->getEntityManager()->flush();

        return $productGroupGroup;
    }

    /**
     * @return Product
     */
    public function createProduct(): Product
    {
        $product = new Product();

        $product
            ->setSdk(1)
            ->setSku('1')
        ;

        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();

        return $product;
    }

    /**
     * @return Cart
     */
    public function createCart(): Cart
    {
        $cart = new Cart();

        $this->getEntityManager()->persist($cart);
        $this->getEntityManager()->flush();

        return $cart;
    }

    protected function getUsedEntities(): array
    {
        return [
            ProductGroup::class,
            Cart::class,
            Product::class,
        ];
    }
}