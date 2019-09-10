<?php

namespace App\Repository\Admin;



use App\Entity\Admin\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    public function findOneByIdWithAllUsers(int $id)
    {
        return $this->createQueryBuilder('car')
            ->andWhere("car.id = :id")
            ->setParameter('id', $id)
            ->leftJoin('car.userCar', 'user_car')
            ->addSelect('user_car')
            ->leftJoin('user_car.user', 'user')
            ->addSelect('user')
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}