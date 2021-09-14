<?php

namespace App\Service\ResponseManager;

use App\DTO\Response\CartResponse;
use App\Entity\Cart;
use App\Entity\EntityInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class CartResponseManager implements ResponseManagerInterface
{
    /**
     * @param EntityInterface|Cart $entity
     * @return CartResponse
     */
    public function createDTO(EntityInterface $entity): CartResponse
    {
        return new CartResponse($entity);
    }

    public function createView(EntityInterface $entity, int $statusCode = Response::HTTP_OK): View
    {
        $entityDTO = $this->createDTO($entity);

        return View::create($entityDTO, $statusCode);
    }

    public function createListView(array $entities, int $statusCode = Response::HTTP_OK, array $headers = []): View
    {
        $entitiesDTO = array_map(
            fn(Cart $cart) => $this->createDTO($cart),
            $entities,
        );

        return View::create($entitiesDTO, $statusCode, $headers);
    }
}