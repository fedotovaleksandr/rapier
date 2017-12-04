<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Employee
{
    public const WORKMODE_DEFAULT = 0;
    public const WORKMODE_CUSTOM = 1;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="User", inversedBy="employee", cascade="all")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
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
     * @ORM\OneToMany(targetEntity="Employee", mappedBy="manager", cascade="persist")
     */
    protected $employees;

    /**
     * @var EmployeeDay[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="EmployeeDay", mappedBy="employee", cascade={"persist","remove"})
     */
    protected $employeeDays;

    /**
     * @var Role[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="employees", cascade="persist")
     * @ORM\JoinTable(name="employee_role")
     */
    protected $roles;

    /**
     * @var Event[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="Event", mappedBy="employee", cascade={"persist","remove"})
     */
    protected $events;

    /**
     * @var Event[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="Event", mappedBy="owner", cascade={"persist","remove"})
     */
    protected $ownEvents;

    /**
     * @var EventLog[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="EventLog", mappedBy="employee", cascade={"persist","remove"})
     */
    protected $eventLogs;

    // *** //

    public function __construct()
    {
        $this->employees = new ArrayCollection();
        $this->employeeDays = new ArrayCollection();
        $this->roles = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->ownEvents = new ArrayCollection();
        $this->eventLogs = new ArrayCollection();
    }

    public function __toString()
    {
        return implode(' ', [$this->id, $this->lastName, $this->firstName]);
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return implode(' ', [$this->lastName, $this->firstName]);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
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
     * @param User $user
     */
    public function setUser(User $user)
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
    public function getManager(): ?self
    {
        return $this->manager;
    }

    /**
     * @param Employee|null $manager
     */
    public function setManager(?self $manager)
    {
        $this->manager = $manager;
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
    public function addEmployee(self $employee): bool
    {
        $employees = &$this->employees;

        if (!$this->isManagerOf($employee->getId()))
            return $employees->add($employee);

        return false;
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function isManagerOf(int $id): bool
    {
        $employees = &$this->employees;
        $idComp = function($i, $employee) use($id) {
            return $employee->id === $id;
        };

        return $employees->exists($idComp);
    }

    /**
     * @return EmployeeDay[]|ArrayCollection
     */
    public function getEmployeeDays()
    {
        return $this->employeeDays;
    }

    /**
     * @param EmployeeDay[]|ArrayCollection $employeeDays
     */
    public function setEmployeeDays($employeeDays)
    {
        $this->employeeDays = $employeeDays;
    }

    /**
     * @return Role[]|ArrayCollection
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param Role[]|ArrayCollection $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @param Role $role
     *
     * @return bool
     */
    public function addRole(Role $role): bool
    {
        $roles = &$this->roles;
        if (!$this->hasRole($role->getId()))
            return $roles->add($role);

        return false;
    }

    /**
     * @param int $roleId
     *
     * @return bool
     */
    public function hasRole(int $roleId): bool
    {
        $roles = &$this->roles;
        $idComp = function($i, $role) use($roleId) {
            return $role->getId() === $roleId;
        };

        return $roles->exists($idComp);
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

    /**
     * @return Event[]|ArrayCollection
     */
    public function getOwnEvents()
    {
        return $this->ownEvents;
    }

    /**
     * @param Event[]|ArrayCollection $ownEvents
     */
    public function setOwnEvents($ownEvents)
    {
        $this->ownEvents = $ownEvents;
    }

    /**
     * @return EventLog[]|ArrayCollection
     */
    public function getEventLogs()
    {
        return $this->eventLogs;
    }

    /**
     * @param EventLog[]|ArrayCollection $eventLogs
     */
    public function setEventLogs($eventLogs)
    {
        $this->eventLogs = $eventLogs;
    }
}
