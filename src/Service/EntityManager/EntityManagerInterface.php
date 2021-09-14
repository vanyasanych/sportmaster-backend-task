<?php

namespace App\Service\EntityManager;

use App\Entity\EntityInterface;
use Doctrine\Persistence\ObjectRepository;

interface EntityManagerInterface
{
    /**
     * @return EntityInterface
     */
    public function create(): EntityInterface;

    /**
     * @param EntityInterface $entity
     * @param bool $andFlush
     */
    public function remove(EntityInterface $entity, bool $andFlush = true): void;

    /**
     * @param EntityInterface $entity
     * @param bool $andFlush
     */
    public function update(EntityInterface $entity, bool $andFlush = true): void;

    /**
     * @return ObjectRepository
     */
    public function getRepository(): ObjectRepository;
}