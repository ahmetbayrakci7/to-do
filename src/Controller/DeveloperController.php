<?php

namespace App\Controller;

use App\Entity\Developer;
use App\Service\ToDo\DeveloperJobService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DeveloperController extends AbstractController
{
    /**
     * @var DeveloperJobService
     */
    private $developerJobService;

    public function __construct(
        DeveloperJobService $developerJobService
    )
    {
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