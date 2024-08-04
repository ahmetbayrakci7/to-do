<?php

namespace App\Service\ToDo;

use App\Entity\Developer;
use App\Entity\DeveloperJobs;
use App\Entity\ToDoList;
use App\Repository\DeveloperJobRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeveloperJobService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var DeveloperJobRepository
     */
    private $developerJobRepository;

    public function __construct(
        EntityManagerInterface $em,
        DeveloperJobRepository $developerJobRepository
    )
    {
        $this->em = $em;
        $this->developerJobRepository = $developerJobRepository;
    }

    public function getAllActiveDevelopersJobs(): array
    {
        $developersJobs = $this->em->getRepository(DeveloperJobs::class)->findBy(['deletedAt' => null]);
        return $this->getActiveDevJobsGroupByWeek($developersJobs);
    }

    public function getActiveDevJobsGroupByWeek($devJobs): array
    {
        $groupedJobs = [];
        foreach ($devJobs as $job) {
            $week = $job->getWeek();
            $groupedJobs[$week][] = $job;
        }
        return $groupedJobs;
    }

    public function getDevJob(Developer $developer): array
    {
        $devJobs = $this->developerJobRepository->getDevJobs($developer);
        return $this->getActiveDevJobsGroupByWeek($devJobs);
    }


    public function createDevJob(Developer $developer, ToDoList $job, $performance, $week)
    {
        try {
            $devJob = new DeveloperJobs();
            $devJob->setDeveloper($developer);
            $devJob->setJob($job);
            $devJob->setPerformance($performance);
            $devJob->setWeek($week);
            $devJob->setCreatedAt(new \DateTime());

            $this->em->persist($devJob);
            $this->em->flush();
        } catch (\Exception $e) {
            throw new \JsonException('HATA: ' . $e->getMessage());
        }
    }
}
