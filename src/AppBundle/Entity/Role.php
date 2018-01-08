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
     * @ORM\ManyToMany(targetEntity="Employee", mappedBy="roles", cascade={"persist"})
     */
    protected $employees;

    /**
     * @var Event[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="Event", mappedBy="role")
     */
    protected $events;

    // *** //

    public function __construct()
    {
        $this->employees = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
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
     * @return Employee[]|ArrayCollection
     */
    public function getEmployees()
    {
        return $this->employees;
    }

    /**
     * @param Employee[]|ArrayCollection $employees
     */
    public function setEmployees($employees)
    {
        $this->employees = $employees;
    }

    /**
     * @param Employee $employee
     *
     * @return bool
     */
    public function addEmployee(Employee $employee): bool
    {
        $employees = &$this->employees;
        if (!$this->hasEmployee($employee->getId())) {
            $employees[] = $employee;

            return true;
        }

        return false;
    }

    /**
     * @param int|null $employeeId
     *
     * @return bool
     */
    public function hasEmployee(?int $employeeId)
    {
        if (is_null($employeeId)) {
            return false;
        }

        $employees = &$this->employees;
        foreach ($employees as $employee) {
            if ($employee->getId() === $employeeId) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return Event[]|ArrayCollection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param Event[]|ArrayCollection $events
     */
    public function setEvents($events)
    {
        $this->events = $events;
    }
}
