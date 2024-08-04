<?php

namespace App\Repository;

use App\Entity\Developer;
use App\Entity\DeveloperJobs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DeveloperJobs|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeveloperJobs|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeveloperJobs[]    findAll()
 * @method DeveloperJobs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeveloperJobRepository extends ServiceEntityRepository
{

    public function __construct(
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, DeveloperJobs::class);
    }

    public function getDeveloperJobsWithWeek()
    {
        return $this->createQueryBuilder('dj')
            ->where('dj.deletedAt IS NULL')
            ->getQuery()
            ->getResult();
    }

    public function getDevJobs(Developer $developer)
    {
        return $this->createQueryBuilder('dj')
            ->where('dj.deletedAt IS NULL')
            ->andWhere('dj.developer = :developer')
            ->setParameter('developer', $developer)
            ->getQuery()
            ->getResult();

    }
}