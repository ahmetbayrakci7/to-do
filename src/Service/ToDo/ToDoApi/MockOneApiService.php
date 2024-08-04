<?php

namespace App\Service\ToDo\ToDoApi;

use App\Service\ToDo\IToDo;
use App\Service\ToDo\ToDoService;
use App\Type\CreateToDoListType;
use App\Type\Response\MockApiResponseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MockOneApiService implements IToDo
{
    const GET_TO_DO_ENDPOINT = ['method' => 'GET', 'path' => 'mock-one'];

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var string
     */
    private $api;
    /**
     * @var ParameterBagInterface
     */
    private $parameterBag;
    /**
     * @var HttpClientInterface
     */
    private $client;
    /**
     * @var ToDoService
     */
    private $toDoService;

    public function __construct(
        EntityManagerInterface $em,
        ParameterBagInterface $parameterBag,
        HttpClientInterface $client,
        ToDoService $toDoService
    )
    {
        $this->em = $em;
        $this->api = $parameterBag->get('mock_api');
        $this->parameterBag = $parameterBag;
        $this->client = $client;
        $this->toDoService = $toDoService;
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @return MockApiResponseType
     */
    private function request(
        string $method,
        string $endpoint
    ): MockApiResponseType
    {
        try {
            $url = $this->generateUrl($endpoint);
            $request = $this->client->request($method, $url);
        } catch (TransportExceptionInterface $exception) {
            throw new UnprocessableEntityHttpException($exception->getMessage());
        }

        $response = new MockApiResponseType($request);

        if ($response->getStatus() == 401) {
            $this->request($method, $endpoint);
        }

        return $response;
    }

    private function generateUrl($endpoint): string
    {
        return "{$this->api}/{$endpoint}";
    }


    /**
     * @return MockApiResponseType
     */
    public function getAndSetTodoList(): MockApiResponseType
    {
        $response = $this->request(self::GET_TO_DO_ENDPOINT['method'], self::GET_TO_DO_ENDPOINT['path']);
        $contents = json_decode(base64_decode($response->getData()['content']));
        $createTypes = $this->prepareContent($contents);
        $this->toDoService->createToDoListWithArray($createTypes);
        return $response;

    }

    private function prepareContent($contents): array
    {
        $items = [];
        foreach ($contents as $content) {
            $createType = new CreateToDoListType();
            $createType->setId($content->id);
            $createType->setDifficulty($content->value);
            $createType->setDuration($content->estimated_duration);
            $createType->setPathName(self::GET_TO_DO_ENDPOINT['path']);
            $items[] = $createType;
        }
        return $items;
    }
}