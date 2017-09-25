<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
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
     * @ORM\Column(type="string", length=255)
     */
    protected $title;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=4000, nullable=true)
     */
    protected $description;

    /**
     * @var \DateTimeInterface|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $startDate;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $duration;

    /**
     * @var int
     * @ORM\Column(type="smallint")
     */
    protected $period;

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
     * @var Employee|null
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="events")
     * @ORM\JoinColumn(name="employee_id", nullable=true)
     */
    protected $employee;

    /**
     * @var Schedule
     * @ORM\ManyToOne(targetEntity="Schedule", inversedBy="events")
     * @ORM\JoinColumn(name="schedule_id", nullable=false)
     */
    protected $schedule;

    /**
     * @var Role
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="events")
     * @ORM\JoinColumn(name="role_id", nullable=false)
     */
    protected $role;

    /**
     * @var EventDay[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="EventDay", mappedBy="event")
     */
    protected $eventDays;

    /**
     * @var EventLog[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="EventLog", mappedBy="event")
     */
    protected $eventLogs;

    // *** //

    public function __construct()
    {
        $this->eventDays = new ArrayCollection();
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
     * @return \DateTimeInterface|null
     */
    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    /**
     * @param \DateTimeInterface|null $startDate
     */
    public function setStartDate(?\DateTimeInterface $startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return int|null
     */
    public function getDuration(): ?int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     */
    public function setDuration(int $duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return int|null
     */
    public function getPeriod(): ?int
    {
        return $this->period;
    }

    /**
     * @param int $period
     */
    public function setPeriod(int $period)
    {
        $this->period = $period;
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
     * @param Employee|null $employee
     */
    public function setEmployee(?Employee $employee)
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
     * @return Role|null
     */
    public function getRole(): ?Role
    {
        return $this->role;
    }

    /**
     * @param Role $role
     */
    public function setRole(Role $role)
    {
        $this->role = $role;
    }

    /**
     * @return ArrayCollection
     */
    public function getEventDays()
    {
        return $this->eventDays;
    }

    /**
     * @param iterable $eventDays
     */
    public function setEventDays(iterable $eventDays)
    {
        $this->eventDays = $eventDays;
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
}
