<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Service\Allocator\StoresResponsibilityAllocator;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\Route("allocate")
 */
class AllocatorController extends AbstractFOSRestController
{
    /**
     * @var StoresResponsibilityAllocator
     */
    private StoresResponsibilityAllocator $storesResponsibilityAllocator;

    /**
     * @param StoresResponsibilityAllocator $storesResponsibilityAllocator
     */
    public function __construct(StoresResponsibilityAllocator $storesResponsibilityAllocator)
    {
        $this->storesResponsibilityAllocator = $storesResponsibilityAllocator;
    }

    /**
     * @Rest\Get("/{id}", requirements={"id"="\d+"})
     *
     * @param Cart $cart
     *
     * @return View
     */
    public function allocate(Cart $cart): View
    {
        return View::create($this->storesResponsibilityAllocator->allocate($cart));
    }
}
