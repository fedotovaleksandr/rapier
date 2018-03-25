<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class EventLog
{
    public const ACTION_TOGGLE = 0;
    public const ACTION_START = 10;
    public const ACTION_STOP = 20;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTimeInterface|\DateTime
     * @ORM\Column(type="datetime")
     */
    protected $timeInstant;

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
     * @var int
     * @ORM\Column(type="smallint")
     */
    protected $action;

    /**
     * @var \DateTimeInterface|\DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $startTime;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $duration;

    /**
     * @var int|null
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $oldStatus;

    /**
     * @var int|null
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $newStatus;

    /**
     * @var Employee
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="eventLogs")
     * @ORM\JoinColumn(name="employee_id", nullable=false)
     */
    protected $employee;

    /**
     * @var Event
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="eventLogs")
     * @ORM\JoinColumn(name="event_id", nullable=false)
     */
    protected $event;

    // *** //

    public function __construct()
    {
        $this->timeInstant = new \DateTime();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return \DateTimeInterface|\DateTime|null
     */
    public function getTimeInstant(): ?\DateTimeInterface
    {
        return $this->timeInstant ? clone $this->timeInstant : null;
    }

    /**
     * @param \DateTimeInterface $timeInstant
     */
    public function setTimeInstant(\DateTimeInterface $timeInstant)
    {
        $this->timeInstant = clone $timeInstant;
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
    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime ? clone $this->startTime : null;
    }

    /**
     * @param \DateTimeInterface|null $startTime
     */
    public function setStartTime(?\DateTimeInterface $startTime)
    {
        $this->startTime = clone $startTime;
    }

    /**
     * @return int|null
     */
    public function getAction(): ?int
    {
        return $this->action;
    }

    /**
     * @param int $action
     */
    public function setAction(int $action)
    {
        $this->action = $action;
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
    public function getOldStatus(): ?int
    {
        return $this->oldStatus;
    }

    /**
     * @param int|null $oldStatus
     */
    public function setOldStatus(?int $oldStatus)
    {
        $this->oldStatus = $oldStatus;
    }

    /**
     * @return int|null
     */
    public function getNewStatus(): ?int
    {
        return $this->newStatus;
    }

    /**
     * @param int|null $newStatus
     */
    public function setNewStatus(?int $newStatus)
    {
        $this->newStatus = $newStatus;
    }

    /**
     * @return Event|null
     */
    public function getEvent(): ?Event
    {
        return $this->event;
    }

    /**
     * @param Event $event
     */
    public function setEvent(Event $event)
    {
        $this->event = $event;
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
}
