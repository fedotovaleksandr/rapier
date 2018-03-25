<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Schedule
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
     * @var \DateTimeInterface|\DateTime
     * @ORM\Column(type="datetime")
     */
    protected $startDate;

    /**
     * @var \DateTimeInterface|\DateTime
     * @ORM\Column(type="datetime")
     */
    protected $endDate;

    /**
     * @var Event[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="Event", mappedBy="schedule", cascade={"persist","remove"}, orphanRemoval=true)
     */
    protected $events;

    // *** //

    public function __construct()
    {
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
        return $this->startDate ? clone $this->startDate : null;
    }

    /**
     * @param \DateTimeInterface $startDate
     */
    public function setStartDate(\DateTimeInterface $startDate)
    {
        $this->startDate = clone $startDate;
    }

    /**
     * @return \DateTimeInterface|\DateTime|null
     */
    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate ? clone $this->endDate : null;
    }

    /**
     * @param \DateTimeInterface $endDate
     */
    public function setEndDate(\DateTimeInterface $endDate)
    {
        $this->endDate = clone $endDate;
    }

    /**
     * @return Event[]|ArrayCollection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @return array
     */
    public function getSortedByStartDateEvents(): array
    {
        $arr = $this->events->toArray();

        usort($arr, function (Event $first, Event $second) {
            return $first->getStartDate() <=> $second->getStartDate();
        });

        return $arr;
    }

    /**
     * @param Event[]|ArrayCollection $events
     */
    public function setEvents($events)
    {
        $this->events = $events;
    }

    /**
     * <strong>!!! Calls Event::setSchedule()</strong>.
     *
     * @param Event $event
     *
     * @return bool
     */
    public function addEvent(Event $event): bool
    {
        $event->setSchedule($this);
        $this->events[] = $event;

        return true;
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function removeEvent(int $id): bool
    {
        $events = &$this->events;

        foreach ($events as $k => $event) {
            if ($event->getId() === $id) {
                unset($events[$k]);

                return true;
            }
        }

        return false;
    }
}
