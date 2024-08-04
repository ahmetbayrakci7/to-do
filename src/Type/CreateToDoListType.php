<?php

namespace App\Type;

use App\Entity\Poi;
use App\Entity\Shipment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\Constraints as Assert;

class CreateToDoListType
{
    /**
     * @var integer
     * @Assert\Type("integer")
     */
    private $id;

    /**
     * @var integer
     * @Assert\Type("integer")
     */
    private $difficulty;

    /**
     * @var integer
     * @Assert\Type("integer")
     */
    private $duration;

    /**
     * @var string
     * @Assert\Type("string")
     */
    private $pathName;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDifficulty(): ?int
    {
        return $this->difficulty;
    }

    public function setDifficulty(?int $difficulty): void
    {
        $this->difficulty = $difficulty;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): void
    {
        $this->duration = $duration;
    }

    public function getPathName(): string
    {
        return $this->pathName;
    }

    public function setPathName(string $pathName): void
    {
        $this->pathName = $pathName;
    }
}