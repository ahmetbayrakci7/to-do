<?php

namespace App\Service\Task;

use App\Entity\Developer;
use App\Entity\DeveloperJobs;
use App\Entity\ToDoList;
use App\Service\Developer\DeveloperService;
use App\Service\ToDo\DeveloperJobService;
use App\Service\ToDo\ToDoService;
use Doctrine\ORM\EntityManagerInterface;

class TaskService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var DeveloperService
     */
    private $developerService;
    /**
     * @var ToDoService
     */
    private $toDoService;
    /**
     * @var DeveloperJobService
     */
    private $developerJobService;

    public function __construct(
        EntityManagerInterface $em,
        DeveloperService       $developerService,
        ToDoService            $toDoService,
        DeveloperJobService $developerJobService
    )
    {
        $this->em = $em;
        $this->developerService = $developerService;
        $this->toDoService = $toDoService;
        $this->developerJobService = $developerJobService;
    }

    public function distributeTasksAndCalculateWeeks(): array
    {
        $developers = $this->developerService->getAllActiveDeveloper();
        $tasks = $this->toDoService->getAllActiveToDo();
        $weekSchedule = $this->distributeTasksForWeek($tasks, $developers);

        return [
            'schedule' => $weekSchedule,
            'totalWeeks' => count($weekSchedule)
        ];
    }

    private function distributeTasksForWeek(array $tasks, array $developers): array
    {
        $weekSchedule = [];
        list($remainingDevCapacity, $waitingTaskCapacity) = $this->getDevAndTaskPerformanceWithSort($tasks, $developers);
        $cloneDevCap = $remainingDevCapacity;
        $i = 1;

        foreach ($waitingTaskCapacity as $taskId => $taskCap) {
            $task = $this->em->getRepository(ToDoList::class)->findOneBy(['id' => $taskId]);
                list($devId, $devCap) = $this->checkDeveloperPerformance($remainingDevCapacity);
                $developer = $this->em->getRepository(Developer::class)->findOneBy(['id' => $devId]);
                if ($taskCap != 0 && $taskCap < $devCap) {
                    $weekSchedule[$i][$devId][] = [
                        'taskType' => 'full',
                        'task' => $task,
                        'duration' => $task->getDuration(),
                        'difficulty' => $task->getDifficulty(),
                        'performance' => $taskCap
                    ];
                    $remainingDevCapacity[$devId] = $devCap - $taskCap;

                    unset($waitingTaskCapacity[$taskId]);
                    $this->developerJobService->createDevJob($developer, $task, $taskCap, $i);
                } elseif ($devCap != 0 && $taskCap > $devCap) {
                    $weekSchedule[$i][$devId][] = [
                        'taskType' => 'partial',
                        'task' => $task,
                        'duration' => $task->getDuration(),
                        'difficulty' => $task->getDifficulty(),
                        'performance' => $devCap
                    ];
                    $this->developerJobService->createDevJob($developer, $task, $devCap, $i);
                    $devCap = 0;
                    unset($remainingDevCapacity[$devId]);
                    $waitingTaskCapacity[$taskId] = $taskCap - $devCap;
                } else {
                    continue;
                }
//            }
            if (empty($remainingDevCapacity)) {
                $i++;
                $remainingDevCapacity = $cloneDevCap;
            }
        }
        return $weekSchedule;
    }

    private function checkDeveloperPerformance($remainingDevCapacity): array
    {
        uasort($remainingDevCapacity, function ($a, $b){
            return $b <=> $a;
        });

        $devId = array_keys($remainingDevCapacity)[0];
        return [
            $devId,
            $remainingDevCapacity[$devId]
        ];
    }

    private function getDevAndTaskPerformanceWithSort($tasks, array $developers): ?array
    {
        $remainingCapacity = [];
        $waitingTaskCapacity = [];

        usort($developers, function ($a, $b) {
            return $b->getDifficulty() * $b->getDuration() <=> $a->getDifficulty() * $a->getDuration();
        });
        foreach ($developers as $developer) {
            /**@var Developer $developer */
            $remainingCapacity[$developer->getId()] = $developer->getDifficulty() * $developer->getDuration() * $developer->getWeeklyHours();
        }
        usort($tasks, function ($a, $b) {
            return $b->getDifficulty() * $b->getDuration() <=> $a->getDifficulty() * $a->getDuration();
        });
        foreach ($tasks as $task) {
            /**@var ToDoList $task */
            $waitingTaskCapacity[$task->getId()] = $task->getDuration() * $task->getDifficulty();
        }
        return [
            $remainingCapacity,
            $waitingTaskCapacity
        ];
    }
}
