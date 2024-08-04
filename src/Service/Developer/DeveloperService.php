<?php

namespace App\Service\Developer;

use App\Entity\Developer;
use Doctrine\ORM\EntityManagerInterface;

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
}
