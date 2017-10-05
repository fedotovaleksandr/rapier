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
    protected $roleName;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=4000, nullable=true)
     */
    protected $description;

    /**
     * @var Employee[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="Employee", mappedBy="roles",cascade={"persist"})
     */
    protected $employees;

    /**
     * @var Event[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="Event", mappedBy="role")
     */
    protected $events;

    // *** //

    public function __construct(string $roleName)
    {
        if (!in_array($roleName, User::getAvailableRoles(), true)) {
            throw new \InvalidArgumentException(
                sprintf('%s role is not available.', $roleName)
            );
        }
        $this->roleName = $roleName;
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
    public function getRoleName(): ?string
    {
        return $this->roleName;
    }

    /**
     * @param string $roleName
     */
    public function setRoleName(string $roleName)
    {
        $this->roleName = $roleName;
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
        foreach ($employees as $employee) {
            $this->addEmployee($employee);
        }
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

    public function addEmployee(Employee $employee)
    {
        if (!$this->employees->contains($employee)) {
            $this->employees->add($employee);
            $employee->addRole($this);
        }
    }
}
