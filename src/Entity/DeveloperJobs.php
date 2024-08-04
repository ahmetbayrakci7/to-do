<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity()
 * @ORM\Table(name="developer_jobs")
 */
class DeveloperJobs
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var Developer
     * @ORM\ManyToOne(targetEntity=Developer::class, inversedBy="developer")
     */
    private $developer;


    /**
     * @var ToDoList
     * @ORM\ManyToOne(targetEntity=ToDoList::class, inversedBy="todo")
     */
    private $job;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $performance;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $week;


    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function getDeveloper(): Developer
    {
        return $this->developer;
    }

    public function setDeveloper(Developer $developer): void
    {
        $this->developer = $developer;
    }

    public function getJob(): ToDoList
    {
        return $this->job;
    }

    public function setJob(ToDoList $job): void
    {
        $this->job = $job;
    }

    public function getPerformance(): string
    {
        return $this->performance;
    }

    public function getWeek(): int
    {
        return $this->week;
    }

    public function setWeek(int $week): void
    {
        $this->week = $week;
    }

    public function setPerformance(string $performance): void
    {
        $this->performance = $performance;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getDeletedAt(): ?\DateTime
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }
}
