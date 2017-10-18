<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Employee
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * An employee can be (and will be at most)
     * registered in the system himself.
     *
     * @var User
     * @ORM\OneToOne(targetEntity="User", inversedBy="employee", cascade="all")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    protected $lastName;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    protected $firstName;

    /**
     * @var string
     * @ORM\Column(type="string", length=1)
     */
    protected $gender;

    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    protected $phone;

    /**
     * @var int
     * @ORM\Column(type="smallint")
     */
    protected $workMode;

    /**
     * @var Employee|null
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="employees")
     * @ORM\JoinColumn(name="manager_id", nullable=true)
     */
    protected $manager;

    /**
     * @var Employee[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="Employee", mappedBy="manager")
     */
    protected $employees;

    /**
     * @var EmployeeDay[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="EmployeeDay", mappedBy="employee")
     */
    protected $employeeDays;

    /**
     * @var Role[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="employees",cascade={"persist"})
     * @ORM\JoinTable(name="employee_role")
     */
    protected $roles;

    /**
     * @var Event[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="Event", mappedBy="employee")
     */
    protected $events;

    /**
     * @var EventLog[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="EventLog", mappedBy="employee")
     */
    protected $eventLogs;

    // *** //

    public function __construct()
    {
        $this->employees = new ArrayCollection();
        $this->employeeDays = new ArrayCollection();
        $this->roles = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->eventLogs = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     */
    public function setUser(?User $user)
    {
        $this->user = $user;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender(string $gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return int|null
     */
    public function getWorkMode(): ?int
    {
        return $this->workMode;
    }

    /**
     * @param int $workMode
     */
    public function setWorkMode(int $workMode)
    {
        $this->workMode = $workMode;
    }

    /**
     * @return Employee|null
     */
    public function getManager(): ?Employee
    {
        return $this->manager;
    }

    /**
     * @param Employee|null $manager
     */
    public function setManager(?Employee $manager)
    {
        $this->manager = $manager;
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
    public function getEmployeeDays(): ArrayCollection
    {
        return $this->employeeDays;
    }

    /**
     * @param iterable $employeeDays
     */
    public function setEmployeeDays(iterable $employeeDays)
    {
        $this->employeeDays = $employeeDays;
    }

    /**
     * @return ArrayCollection
     */
    public function getRoles(): ArrayCollection
    {
        return $this->roles;
    }

    /**
     * @param iterable|Role[] $roles
     */
    public function setRoles(iterable $roles)
    {
        foreach ($roles as $role) {
            $this->addRole($role);
        }
    }


    /**
     * @param Role $role
     */
    public function addRole(Role $role): void
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
            $role->addEmployee($this);
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

    /**
     * @return ArrayCollection
     */
    public function getEventLogs(): ArrayCollection
    {
        return $this->eventLogs;
    }

    /**
     * @param iterable $eventLogs
     */
    public function setEventLogs(iterable $eventLogs)
    {
        $this->eventLogs = $eventLogs;
    }

    public function getFullName(): string{
        return sprintf('%s %s',$this->firstName,$this->lastName);
    }
}
