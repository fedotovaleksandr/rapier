<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Event.
 *
 * @ORM\Entity
 */
class Event
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
    protected $title;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $description;

    /**
     * @var \DateTimeInterface
     * @ORM\Column(type="datetime")
     */
    protected $startDate;

    /**
     * @var \DateInterval
     * @ORM\Column(type="dateinterval")
     */
    protected $interval;

    /**
     * @var int
     * @ORM\Column(type="smallint")
     */
    protected $importance;

    /**
     * @var int
     * @ORM\Column(type="smallint")
     */
    protected $status;

    /**
     * @var Employee
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="events")
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     */
    protected $employee;

    /**
     * @var Schedule
     * @ORM\ManyToOne(targetEntity="Schedule", inversedBy="events")
     * @ORM\JoinColumn(name="schedule_id", referencedColumnName="id")
     */
    protected $schedule;

    /**
     * @var EventLog[]
     * @ORM\OneToMany(targetEntity="EventLog", mappedBy="event")
     */
    protected $eventLogs;

    /**
     * @var EmployeeDay[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="EmployeeDay", inversedBy="events")
     * @ORM\JoinTable(
     *     name="employee_days_event",
     *     inverseJoinColumns={ @ORM\JoinColumn(name="employee_day", referencedColumnName="day") }
     * )
     */
    protected $employeeDays;

    /**
     * Event constructor.
     */
    public function __construct()
    {
        $this->eventLogs = new ArrayCollection();
        $this->employeeDays = new ArrayCollection();
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
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
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
     * @return \DateInterval|null
     */
    public function getInterval(): ?\DateInterval
    {
        return $this->interval;
    }

    /**
     * @param \DateInterval $interval
     */
    public function setInterval(\DateInterval $interval)
    {
        $this->interval = $interval;
    }

    /**
     * @return int|null
     */
    public function getImportance(): ?int
    {
        return $this->importance;
    }

    /**
     * @param int $importance
     */
    public function setImportance(int $importance)
    {
        $this->importance = $importance;
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    /**
     * @return Employee|null
     */
    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    /**
     * @param Employee $employee
     */
    public function setEmployee(Employee $employee)
    {
        $this->employee = $employee;
    }

    /**
     * @return Schedule|null
     */
    public function getSchedule(): ?Schedule
    {
        return $this->schedule;
    }

    /**
     * @param Schedule $schedule
     */
    public function setSchedule(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * @return EventLog[]|ArrayCollection
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

    /**
     * @return EmployeeDay[]|ArrayCollection
     */
    public function getEmployeeDays(): ArrayCollection
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
}
