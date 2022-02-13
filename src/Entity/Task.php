<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    public $task;

    /**
     * @Assert\NotBlank
     * @Assert\Type("\DateTime")
     * @ORM\Column(type="datetime")
     */
    protected $dueDate;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class)
     */
    protected $category;

    /**
     * @ORM\ManyToOne(targetEntity=Issue::class)
     */
    private $issue;

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     * @return Task
     */
    public function setCategory(Category $category = null): Task
    {
        $this->category = $category;
        return $this;
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTask(): ?string
    {
        return $this->task;
    }

    public function setTask(string $task): self
    {
        $this->task = $task;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(\DateTimeInterface $dueDate = null): self
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function getIssue(): ?Issue
    {
        return $this->issue;
    }

    public function setIssue(?Issue $issue): self
    {
        $this->issue = $issue;

        return $this;
    }
}
