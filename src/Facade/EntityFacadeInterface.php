<?php

namespace App\Facade;

use App\DTO\Request\RequestInterface;
use App\Entity\EntityInterface;

interface EntityFacadeInterface
{
    public function createByRequest(RequestInterface $request): EntityInterface;

    public function updateByRequest(EntityInterface $entity, RequestInterface $request): EntityInterface;
}