<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\Store;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
/**
 * @method Store|null find($id, $lockMode = null, $lockVersion = null)
 * @method Store|null findOneBy(array $criteria, array $orderBy = null)
 * @method Store[]    findAll()
 * @method Store[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Store::class);
    }

    /**
     * @param string $name
     *
     * @return bool
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function existShopByName(string $name): bool
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->select(
                $queryBuilder->expr()->countDistinct('s.id')
            )
            ->where(
                $queryBuilder->expr()->eq('s.name', ':name')
            )
            ->setParameter('name', $name)
        ;

        return $queryBuilder->getQuery()->getSingleScalarResult() > 0;
    }

    /**
     * @param Product $product
     *
     * @return Store[]|array
     */
    public function findStoresByProduct(Product $product): array
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->leftJoin('s.inventories', 'i')
            ->leftJoin('i.product', 'p')
            ->andWhere(
                $queryBuilder->expr()->eq('p.id', ':product')
            )
            ->andWhere(
                $queryBuilder->expr()->gt('i.quantity', 0)
            )
            ->setParameter('product', $product)
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param Product $product
     *
     * @return array
     */
    public function findPriorityStoresProductQuantityByProduct(Product $product): array
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->select([
                'i.quantity as quantity'
            ])
            ->leftJoin('s.inventories', 'i')
            ->leftJoin('i.product', 'p')
            ->andWhere(
                $queryBuilder->expr()->eq('p.id', ':product')
            )
            ->andWhere(
                $queryBuilder->expr()->gt('i.quantity', 0)
            )
            ->orderBy('s.priority', 'ASC')
            ->setParameter('product', $product)
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param Product $product
     * @param int $limit
     *
     * @return Store[]|array
     */
    public function findPriorityStoresIdsByLimit(Product $product, int $limit): array
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->select([
                's.id as id',
            ])
            ->leftJoin('s.inventories', 'i')
            ->leftJoin('i.product', 'p')
            ->andWhere(
                $queryBuilder->expr()->eq('p.id', ':product')
            )
            ->andWhere(
                $queryBuilder->expr()->gt('i.quantity', 0)
            )
            ->orderBy('s.priority', 'ASC')
            ->setParameter('product', $product)
            ->setMaxResults($limit)
        ;

        return $queryBuilder->getQuery()->getResult();
    }
}
