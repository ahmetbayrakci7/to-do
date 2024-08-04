<?php

namespace App\Service\Developer;

use App\Entity\Developer;
use App\Entity\ToDoList;
use App\Type\CreateToDoListType;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class DeveloperService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(
        EntityManagerInterface $em
    )
    {
        $this->em = $em;
    }

    public function getAllActiveDeveloper()
    {
        return $this->em->getRepository(Developer::class)->findBy(['deletedAt' => null]);
    }

    public function getDeveloperById($id)
    {
        return $this->em->getRepository(Developer::class)->findOneBy(['deletedAt' => null, 'id' => $id]);
    }

    public function getActiveDeveloperSortByDifficulty()
    {
        return $this->em->getRepository(Developer::class)->findBy(['deletedAt' => null], ['difficulty' => 'desc']);
    }
}
