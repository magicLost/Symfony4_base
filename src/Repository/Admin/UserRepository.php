<?php

namespace App\Repository\Admin;


use App\Entity\Admin\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findOneByIdWithAllCars(int $id){

        return $this->createQueryBuilder('user')
            ->andWhere("user.id = :id")
            ->setParameter('id', $id)
            ->leftJoin('user.userCar', 'user_car')
            ->addSelect('user_car')
            ->leftJoin('user_car.car', 'car')
            ->addSelect('car')
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function findById(int $id){
        return $this->createQueryBuilder('user')
            ->andWhere('user.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}