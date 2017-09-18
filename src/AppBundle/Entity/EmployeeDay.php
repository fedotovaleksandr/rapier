<?php


namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class EmployeeDay
 * @ORM\Entity
 */
class EmployeeDay
{
    /**
     * @ORM\Id
     * @ORM\Column(type="smallint")
     */
    protected $day;

    /**
     * @var \DateTimeInterface
     * @ORM\Column(type="datetime")
     */
    protected $startDate;

    /**
     * @var \DateTimeInterface
     * @ORM\Column(type="datetime")
     */
    protected $endDate;

    /**
     * @var Employee
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="employeeDays")
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     */
    protected $employee;

    /**
     * @var Employee[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="Event", mappedBy="employeeDays")
     */
    protected $events;

    /**
     * EmployeeDay constructor.
     */
    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param mixed $day
     */
    public function setDay($day)
    {
        $this->day = $day;
    }

    /**
     * @return Employee|null
     */
    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    /**
     * @param mixed $employee
     */
    public function setEmployee($employee)
    {
        $this->employee = $employee;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    /**
     * @param \DateTimeInterface $startDate
     */
    public function setStartDate(\DateTimeInterface $startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    /**
     * @param \DateTimeInterface $endDate
     */
    public function setEndDate(\DateTimeInterface $endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return Employee[]|ArrayCollection
     */
    public function getEvents(): ArrayCollection
    {
        return $this->events;
    }

    /**
     * @param Employee[]|ArrayCollection $events
     */
    public function setEvents($events)
    {
        $this->events = $events;
    }
}