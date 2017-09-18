<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class EventLog.
 *
 * @ORM\Entity
 */
class EventLog
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
     * @var int
     * @ORM\Column(type="smallint")
     */
    protected $action;

    /**
     * @var \DateInterval
     * @ORM\Column(type="dateinterval")
     */
    protected $interval;

    /**
     * @var int
     * @ORM\Column(type="smallint")
     */
    protected $oldStatus;

    /**
     * @var int
     * @ORM\Column(type="smallint")
     */
    protected $newStatus;

    /**
     * @var Event
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="eventLogs")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    protected $event;

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
    public function getOldStatus(): ?int
    {
        return $this->oldStatus;
    }

    /**
     * @param int $oldStatus
     */
    public function setOldStatus(int $oldStatus)
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
     * @param int $newStatus
     */
    public function setNewStatus(int $newStatus)
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
}
