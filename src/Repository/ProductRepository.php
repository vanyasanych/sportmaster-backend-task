<?php

namespace App\Repository;

use App\Entity\Cart;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findGroupProductsByCart(Cart $cart)
    {
        $queryBuilder = $this->createQueryBuilder('p');
        $queryBuilder
            ->select([
                'p',
                'sum(p.id) as product_in_cart_count',
            ])
            ->leftJoin('p.carts', 'c')
            ->where($queryBuilder->expr()->eq('c.id', ':cart'))
            ->setParameter('cart', $cart)
        ;
    }
}
