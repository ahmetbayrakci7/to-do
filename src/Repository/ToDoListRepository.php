<?php

namespace App\Repository;

use App\Entity\Developer;
use App\Entity\ToDoList;
use App\Type\CreateToDoListType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ToDoList|null find($id, $lockMode = null, $lockVersion = null)
 * @method ToDoList|null findOneBy(array $criteria, array $orderBy = null)
 * @method ToDoList[]    findAll()
 * @method ToDoList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ToDoListRepository extends ServiceEntityRepository
{

    public function __construct(
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, ToDoList::class);
    }

    public function checkToDoList($hash)
    {
        return $this->createQueryBuilder('td')
            ->where('td.hash = :hash')
            ->setParameter('hash', $hash)
            ->getQuery()
            ->getOneOrNullResult();
    }
}