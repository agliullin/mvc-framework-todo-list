<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 * @ORM\Table(name="task")
 */
class Task
{
    /**
     * Task unique ID
     *
     * @var integer
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * Name
     *
     * @var string
     *
     * @ORM\Column(type="string", length=250)
     */
    private $name;

    /**
     * E-mail
     *
     * @var string
     *
     * @ORM\Column(type="string", length=180)
     */
    private $email;

    /**
     * Description
     *
     * @var string
     *
     * @ORM\Column(type="string", length=500)
     */
    private $description;

    /**
     * Status
     *
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default":"0"})
     */
    private $status;

    /**
     * If description changed flag
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default":"0"})
     */
    private $isDescriptionModified;

    /**
     * Get Id
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Task
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Task
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Task
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get status
     *
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param bool $status
     * @return Task
     */
    public function setStatus(bool $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get status of description modified
     *
     * @return bool
     */
    public function getIsDescriptionModified(): bool
    {
        return $this->isDescriptionModified;
    }

    /**
     * Set status of description modified
     *
     * @param bool $isDescriptionModified
     * @return Task
     */
    public function setIsDescriptionModified(bool $isDescriptionModified): self
    {
        $this->isDescriptionModified = $isDescriptionModified;
        return $this;
    }
    /**
     * Fill by data
     *
     * @param $data
     * @return void
     */
    public function fill($data)
    {
        foreach ($data as $name => $value) {
            switch ($name) {
                case 'name':
                    $this->setName($value);
                    break;
                case 'email':
                    $this->setEmail($value);
                    break;
                case 'description':
                    $this->setDescription($value);
                    break;
                case 'status':
                    $this->setStatus($value ?? 0);
                    break;
            }
        }
    }
}