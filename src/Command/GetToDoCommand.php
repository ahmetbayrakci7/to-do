<?php

namespace App\Command;

use App\Service\ToDo\AllToDoApiServices;
use App\Service\ToDo\IToDo;
use App\Service\ToDo\ToDoService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GetToDoCommand extends Command
{
    protected static $defaultName = 'get-to-do:command';
    protected static $defaultDescription = 'Get To Do Command';

    /**
     * @var AllToDoApiServices
     */
    private $allToDoApiServices;
    /**
     * @var ToDoService
     */
    private $toDoService;

    protected function configure(): void
    {
        $this->setDescription(self::$defaultDescription);
    }

    public function __construct(
        AllToDoApiServices $allToDoApiServices,
        ToDoService $toDoService
    )
    {
        $this->allToDoApiServices = $allToDoApiServices;
        $this->toDoService = $toDoService;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $responses = $this->allToDoApiServices->connect();
        foreach ($responses as $response) {
            /**@var IToDo $response */
            $result = $response->getAndSetTodoList();
            if ($result->getStatus() == 200) {
                $io->writeln('Added: '. $result->getData()['name']);
            }
        }

        $io->success("DONE");
    }
}
