<?php

namespace App\Service\ResponseManager;

use App\DTO\Response\StoreResponse;
use App\Entity\EntityInterface;
use App\Entity\Store;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class StoreResponseManager implements ResponseManagerInterface
{
    /**
     * @param EntityInterface|Store $entity
     * @return StoreResponse
     */
    public function createDTO(EntityInterface $entity): StoreResponse
    {
        return new StoreResponse($entity);
    }

    public function createView(EntityInterface $entity, int $statusCode = Response::HTTP_OK): View
    {
        $entityDTO = $this->createDTO($entity);

        return View::create($entityDTO, $statusCode);
    }

    public function createListView(array $entities, int $statusCode = Response::HTTP_OK, array $headers = []): View
    {
        $entitiesDTO = array_map(
            fn(Store $store) => $this->createDTO($store),
            $entities,
        );

        return View::create($entitiesDTO, $statusCode, $headers);
    }
}