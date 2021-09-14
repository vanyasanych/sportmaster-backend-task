<?php

namespace App\Repository;

use App\Entity\Inventory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Inventory|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inventory|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inventory[]    findAll()
 * @method Inventory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InventoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inventory::class);
    }

    /**
     * @param array $storeIds
     * @param int $quantity
     *
     * @return int|mixed|string
     */
    public function updateQuantityByStoreIds(array $storeIds, int $quantity)
    {
        $queryBuilder = $this->createQueryBuilder('i');

        $queryBuilder
            ->update()
            ->leftJoin('i.store', 's')
            ->set('i.quantity', ':quantity')
            ->where($queryBuilder->expr()->in('s.id', ':storeIds'))
            ->setParameter('storeIds', $storeIds)
            ->setParameter('quantity', $quantity)
        ;

        return $queryBuilder->getQuery()->execute();
    }
}
