<?php

namespace App\Service\ResponseManager;

use App\DTO\Response\ProductResponse;
use App\Entity\EntityInterface;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

class ProductResponseManager implements ResponseManagerInterface
{
    /**
     * @param EntityInterface|Product $entity
     * @return ProductResponse
     */
    public function createDTO(EntityInterface $entity): ProductResponse
    {
        return new ProductResponse($entity);
    }

    public function createView(EntityInterface $entity, int $statusCode = Response::HTTP_OK): View
    {
        $entityDTO = $this->createDTO($entity);

        return View::create($entityDTO, $statusCode);
    }

    public function createListView(array $entities, int $statusCode = Response::HTTP_OK, array $headers = []): View
    {
        $entitiesDTO = array_map(
            fn(Product $product) => $this->createDTO($product),
            $entities,
        );

        return View::create($entitiesDTO, $statusCode, $headers);
    }

}