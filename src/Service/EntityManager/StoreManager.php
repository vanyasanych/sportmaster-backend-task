<?php

namespace App\Service\EntityManager;

use App\DTO\Response\ResponsibleStoreResponse;
use App\Entity\EntityInterface;
use App\Entity\Product;
use App\Entity\Store;
use App\Repository\StoreRepository;
use Doctrine\ORM\EntityManagerInterface as DoctrineEntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class StoreManager implements EntityManagerInterface
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
     * @return Store
     */
    public function create(): Store
    {
        $store = new Store();

        $this->entityManager->persist($store);

        return $store;
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
     * @return ObjectRepository|StoreRepository
     */
    public function getRepository(): StoreRepository
    {
        return $this->entityManager->getRepository(Store::class);
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function existShopByName(string $name): bool
    {
        return $this->getRepository()->existShopByName($name);
    }

    /**
     * @param int $index
     *
     * @return Store|null
     */
    public function findById(int $index): ?Store
    {
        return $this->getRepository()->find($index);
    }

    /**
     * @param Product $product
     *
     * @return Store[]|array
     */
    public function findStoresByProduct(Product $product): array
    {
        return $this->getRepository()->findStoresByProduct($product);
    }

    /**
     * @param Product $product
     *
     * @return array
     */
    public function findPriorityQuantityByProduct(Product $product): array
    {
        $data = $this->getRepository()->findPriorityQuantityByProduct($product);

        $result = [];
        array_walk_recursive($data, function ($item) use (&$result) {
            if (!empty($item)) {
                $result[] = $item;
            }
        });

        return $result;
    }

    /**
     * @param Product $product
     * @param int $limit
     *
     * @return ResponsibleStoreResponse[]|array
     */
    public function getResponsibleStoreIdsByLimit(Product $product, int $limit): array
    {
        return $this->getRepository()->findPriorityStoresIdsByLimit($product, $limit);
    }
}