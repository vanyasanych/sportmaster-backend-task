<?php

namespace App\Service\EntityManager;

use App\Entity\EntityInterface;
use App\Entity\Product;
use App\Factory\ProductFactory;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface as DoctrineEntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductManager implements EntityManagerInterface
{
    /**
     * @var DoctrineEntityManagerInterface
     */
    private DoctrineEntityManagerInterface $entityManager;


    /**
     * @param DoctrineEntityManagerInterface $entityManager
     */
    public function __construct(DoctrineEntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return Product
     */
    public function create(): Product
    {
        $Product = ProductFactory::createEntity();

        $this->entityManager->persist($Product);

        return $Product;
    }

    public function remove(EntityInterface $entity, bool $andFlush = true): void
    {

        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    public function update(EntityInterface $entity, bool $andFlush = true): void
    {
            $this->entityManager->flush();
    }

    /**
     * @return ObjectRepository|ProductRepository
     */
    public function getRepository(): ProductRepository
    {
        return $this->entityManager->getRepository(Product::class);
    }
}