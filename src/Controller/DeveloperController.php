<?php

namespace App\Controller;

use App\Entity\Developer;
use App\Service\Developer\DeveloperService;
use App\Service\Task\TaskService;
use App\Service\ToDo\DeveloperJobService;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DeveloperController extends AbstractController
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
     * @Route("/dev/{developer}", name="app_developer_index", methods={"GET"})
     * @Template()
     */
    public function index(Developer $developer)
    {
        $devJobs = $this->developerJobService->getDevJob($developer);

        return [
            'devJobs' => $devJobs,
            'developer' => $developer
        ];
    }

}