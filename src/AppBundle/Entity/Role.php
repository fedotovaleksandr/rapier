<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Role
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $title;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=4000, nullable=true)
     */
    protected $description;

    /**
     * @var Employee[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="Employee", mappedBy="roles")
     */
    protected $employees;

    /**
     * @var Event[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="Event", mappedBy="role")
     */
    protected $events;

    ###

    public function __construct()
    {
        $this->employees = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description)
    {
        $this->description = $description;
    }

    /**
     * @return ArrayCollection
     */
    public function getEmployees(): ArrayCollection
    {
        return $this->employees;
    }

    /**
     * @param iterable $employees
     */
    public function setEmployees(iterable $employees)
    {
        $this->employees = $employees;
    }

    /**
     * @return ArrayCollection
     */
    public function getEvents(): ArrayCollection
    {
        return $this->events;
    }

    /**
     * @param iterable $events
     */
    public function setEvents(iterable $events)
    {
        $this->events = $events;
    }
}
