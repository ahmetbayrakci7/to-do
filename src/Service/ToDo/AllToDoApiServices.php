<?php

namespace App\Service\ToDo;

use Symfony\Component\DependencyInjection\ContainerInterface;

class AllToDoApiServices
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(
        ContainerInterface $container
    )
    {
        $this->container = $container;
    }

    public function connect(): array
    {
        $mocService = [];
        $serviceIds = $this->container->getServiceIds();
        foreach ($serviceIds as $serviceId) {
            $service = $this->container->get($serviceId);
            if ($service instanceof IToDo) {
                $mocService[] = $service;
            }
        }
        return $mocService;
    }

}