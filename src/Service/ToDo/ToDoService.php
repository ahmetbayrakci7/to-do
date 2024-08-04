<?php

namespace App\Service\ToDo;

use App\Entity\ToDoList;
use App\Repository\ToDoListRepository;
use App\Type\CreateToDoListType;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class ToDoService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var ToDoListRepository
     */
    private $toDoListRepository;

    public function __construct(
        EntityManagerInterface $em,
        LoggerInterface $logger,
        ToDoListRepository $toDoListRepository
    )
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->toDoListRepository = $toDoListRepository;
    }

    public function getAllActiveToDo()
    {
        return $this->em->getRepository(ToDoList::class)->findBy(['deletedAt' => null]);
    }

    public function getAllTasksWithSort(): array
    {
        $tasks = $this->getAllActiveToDo();
        usort($tasks, function ($a, $b) {
            return $b->difficulty <=> $a->difficulty;
        });
        return $tasks;
    }


    public function createToDoListWithArray(array $createTypes)
    {
        foreach ($createTypes as $createType) {
            /**@var CreateToDoListType $createType */
            $this->createToDoList($createType);
        }
    }

    public function createToDoList(CreateToDoListType $createToDoListType): ToDoList
    {
        $hash = $this->hashTask($createToDoListType);
        $existToDoList = $this->toDoListRepository->checkToDoList($hash);
        if (!$existToDoList instanceof ToDoList) {
            try {
                $todo = new ToDoList();
                $todo->setDifficulty($createToDoListType->getDifficulty());
                $todo->setDuration($createToDoListType->getDuration());
                $todo->setServicePath($createToDoListType->getPathName());
                $todo->setServiceId($createToDoListType->getId());
                $todo->setHash($hash);
                $todo->setCreatedAt(new \DateTime());
                $this->em->persist($todo);
                $this->em->flush();

                return $todo;
            } catch (\Exception $e) {
                $this->logger->error('HATA: '. $e->getMessage());
                throw new \Exception('HATA: '. $e->getMessage());
            }
        } else {
            return $existToDoList;
        }
    }

    private function hashTask(CreateToDoListType $listType): string
    {
        return md5($listType->getPathName().'_'.$listType->getDuration().' _ '.$listType->getDifficulty(). ' _ '. $listType->getId());
    }
}
