<?php

namespace App\Service\ResponseManager;

use App\DTO\Response\InventoryResponse;
use App\Entity\EntityInterface;
use App\Entity\Inventory;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class InventoryResponseManager implements ResponseManagerInterface
{
    /**
     * @param EntityInterface|Inventory $entity
     * @return InventoryResponse
     */
    public function createDTO(EntityInterface $entity): InventoryResponse
    {
        return new InventoryResponse($entity);
    }

    public function createView(EntityInterface $entity, int $statusCode = Response::HTTP_OK): View
    {
        $entityDTO = $this->createDTO($entity);

        return View::create($entityDTO, $statusCode);
    }

    public function createListView(array $entities, int $statusCode = Response::HTTP_OK, array $headers = []): View
    {
        $entitiesDTO = array_map(
            fn(Inventory $inventory) => $this->createDTO($inventory),
            $entities,
        );

        return View::create($entitiesDTO, $statusCode, $headers);
    }
}