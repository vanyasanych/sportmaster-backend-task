<?php

namespace App\Service\EntityManager;

use App\Entity\EntityInterface;
use App\Entity\Inventory;
use App\Repository\InventoryRepository;
use Doctrine\ORM\EntityManagerInterface as DoctrineEntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class InventoryManager implements EntityManagerInterface
{
    /**
     * @var DoctrineEntityManagerInterface
     */
    private DoctrineEntityManagerInterface $entityManager;

    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * @param DoctrineEntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     */
    public function __construct(DoctrineEntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /**
     * @return Inventory
     */
    public function create(): Inventory
    {
        $Inventory = new Inventory();

        $this->entityManager->persist($Inventory);

        return $Inventory;
    }

    public function remove(EntityInterface $entity, bool $andFlush = true): void
    {

        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    public function update(EntityInterface $entity, bool $andFlush = true): void
    {
        $errors = $this->validator->validate($entity);

        if (count($errors) === 0 && $andFlush) {
            $this->entityManager->flush();
        }
    }

    /**
     * @return ObjectRepository|InventoryRepository
     */
    public function getRepository(): InventoryRepository
    {
        return $this->entityManager->getRepository(Inventory::class);
    }

    /**
     * @param array $storeIds
     * @param int $quantity
     *
     * @return int|mixed|string
     */
    public function updateQuantityByStoreIds(array $storeIds, int $quantity)
    {
        return $this->getRepository()->updateQuantityByStoreIds($storeIds, $quantity);
    }
}