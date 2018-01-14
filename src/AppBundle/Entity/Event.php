<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Event
{
    public const WT_MINOR = 1;
    public const WT_MEDIUM = 4;
    public const WT_MAJOR = 7;
    public const WT_CRITICAL = 10;

    public const STATUS_DRAFT = 0;
    public const STATUS_OPEN = 10;
    public const STATUS_WORK = 20;
    public const STATUS_FINISH = 30;
    public const STATUS_CLOSED = 40;

    public const PERIOD_ONCE = 0;
    public const PERIOD_DAY = 10;
    public const PERIOD_WEEK = 20;
    public const PERIOD_BIWEEK = 30;
    public const PERIOD_MONTH = 40;

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
     * @var \DateTimeInterface|\DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $startDate;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $duration;

    /**
     * @var \DateTimeInterface|\DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $deadLine;

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
     * @var Employee
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="ownEvents")
     * @ORM\JoinColumn(name="owner_id", nullable=false)
     */
    protected $owner;

    /**
     * @var \DateTimeInterface|\DateTime
     * @ORM\Column(type="datetime")
     */
    protected $creationDate;

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
     * @ORM\OneToMany(targetEntity="EventDay", mappedBy="event", cascade={"persist","remove"})
     */
    protected $eventDays;

    /**
     * @var EventLog[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="EventLog", mappedBy="event", cascade={"persist","remove"})
     */
    protected $eventLogs;

    // *** //

    public function __construct()
    {
        $this->eventDays = new ArrayCollection();
        $this->eventLogs = new ArrayCollection();
        $this->creationDate = new \DateTime();
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
     * @return \DateTimeInterface|\DateTime|null
     */
    public function getStartDate(): ?\DateTimeInterface
    {
        return clone ($this->startDate);
    }

    /**
     * @param \DateTimeInterface|null $startDate
     */
    public function setStartDate(?\DateTimeInterface $startDate)
    {
        $this->startDate = clone $startDate;
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
     * @return \DateTimeInterface|\DateTime|null
     */
    public function getDeadLine(): ?\DateTimeInterface
    {
        return clone ($this->deadLine);
    }

    /**
     * @param \DateTimeInterface|null $deadLine
     */
    public function setDeadLine(?\DateTimeInterface $deadLine)
    {
        $this->deadLine = clone $deadLine;
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
    public function getOwner(): ?Employee
    {
        return $this->owner;
    }

    /**
     * @param Employee $owner
     */
    public function setOwner(Employee $owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return \DateTimeInterface|\DateTime|null
     */
    public function getCreationDate(): ?\DateTimeInterface
    {
        return clone ($this->creationDate);
    }

    /**
     * @param \DateTimeInterface $creationDate
     */
    public function setCreationDate(\DateTimeInterface $creationDate)
    {
        $this->creationDate = clone $creationDate;
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
     * @return EventDay[]|ArrayCollection
     */
    public function getEventDays()
    {
        return $this->eventDays;
    }

    /**
     * <strong>!!! Calls EventDay::setEvent()</strong>.
     *
     * @param EventDay[]|ArrayCollection $eventDays
     */
    public function setEventDays($eventDays)
    {
        $this->eventDays = $eventDays;
        foreach ($this->eventDays as $eventDay) {
            $eventDay->setEvent($this);
        }
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

    /**
     * <strong>!!! Calls EventLog::setEvent()</strong>.
     *
     * @param EventLog $eventLog
     *
     * @return bool
     */
    public function addEventLog(EventLog $eventLog): bool
    {
        $eventLog->setEvent($this);
        $this->eventLogs[] = $eventLog;

        return true;
    }
}
