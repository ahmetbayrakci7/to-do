<?php

namespace App\Controller;

use App\Service\Developer\DeveloperService;
use App\Service\Task\TaskService;
use App\Service\ToDo\DeveloperJobService;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    /**
     * @var TaskService
     */
    private $taskService;
    /**
     * @var DeveloperService
     */
    private $developerService;
    /**
     * @var DeveloperJobService
     */
    private $developerJobService;

    public function __construct(
        TaskService         $taskService,
        DeveloperService    $developerService,
        DeveloperJobService $developerJobService
    )
    {
        $this->taskService = $taskService;
        $this->developerService = $developerService;
        $this->developerJobService = $developerJobService;
    }

    /**
     * @Route("/", name="app_todo_index", methods={"GET", "POST"})
     * @Template()
     */
    public function index(Request $request)
    {
        if ($request->isMethod('POST')) {
            $this->taskService->distributeTasksAndCalculateWeeks();
        }

        $developers = $this->developerService->getAllActiveDeveloper();
        $devJobs = $this->developerJobService->getAllActiveDevelopersJobs();
        return [
            'developers' => $developers,
            'devJobs' => $devJobs
        ];
    }

}