<?php

namespace App\Type\Response;

use Symfony\Contracts\HttpClient\ResponseInterface;

class MockApiResponseType
{
    /** @var mixed|null */
    private $status;

    /** @var array|null */
    private $data;

    public function __construct(ResponseInterface $response)
    {
        $this->status = $response->getStatusCode();
        $this->data = json_decode($response->getContent(false), true);
        return $this;
    }

    public function get($key, bool $expand = false)
    {
        $data = $this->data;
        if ($expand) {
            if (array_key_exists('data', $this->data)) {
                $data = $this->data['data'];
            }
        }
        if (empty($data)) {
            return null;
        }
        if (array_key_exists($key, $data)) {
            return $data[$key];
        }
        return null;
    }

    /**
     * @return mixed|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return array|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return (bool)$this->get('success', true);
    }

    public function getMessage()
    {
        return $this->get('message', true);
    }
}