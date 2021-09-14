<?php

namespace App\Service\EntityManager;

use App\Entity\Cart;
use App\Entity\EntityInterface;
use App\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface as DoctrineEntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CartManager implements EntityManagerInterface
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
     * @return Cart
     */
    public function create(): Cart
    {
        $cart = new Cart();

        $this->entityManager->persist($cart);

        return $cart;
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
     * @return ObjectRepository|CartRepository
     */
    public function getRepository(): CartRepository
    {
        return $this->entityManager->getRepository(Cart::class);
    }
}