<?php

namespace App\Service\ResponseManager;

use App\DTO\Response\ResponseInterface;
use App\Entity\EntityInterface;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

interface ResponseManagerInterface
{
    public function createDTO(EntityInterface $entity): ResponseInterface;

    public function createView(EntityInterface $entity, int $statusCode = Response::HTTP_OK): View;

    /**
     * @param EntityInterface[] $entities
     * @param int $statusCode
     * @param array $headers
     *
     * @return View
     */
    public function createListView(array $entities, int $statusCode = Response::HTTP_OK, array $headers = []): View;
}
