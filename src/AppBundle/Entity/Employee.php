<?php


namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Employee
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
     * @var string
     * @ORM\Column(type="string")
     */
    protected $lastName;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $firstName;

    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    protected $gender;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $phone;

    /**
     * @var integer
     * @ORM\Column(type="smallint")
     */
    protected $workMode;

    /**
     * @var Employee
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="employees")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
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
     * @var Event[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="Event", mappedBy="employee")
     */
    protected $events;

    /**
     * @var Role[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="employees")
     * @ORM\JoinTable(name="employee_role")
     */
    protected $roles;

    /**
     * Employee constructor.
     */
    public function __construct()
    {
        $this->employees = new ArrayCollection();
        $this->employeeDays = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->roles = new ArrayCollection();
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
     * @return int|null
     */
    public function getGender(): ?int
    {
        return $this->gender;
    }

    /**
     * @param int $gender
     */
    public function setGender(int $gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
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
     * @param Employee $manager
     */
    public function setManager(Employee $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return ArrayCollection|Employee[]
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
     * @return ArrayCollection|EmployeeDay[]
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
     * @return Event[]|ArrayCollection
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
    public function getRoles(): ArrayCollection
    {
        return $this->roles;
    }

    /**
     * @param iterable $roles
     */
    public function setRoles(iterable $roles)
    {
        $this->roles = $roles;
    }
}