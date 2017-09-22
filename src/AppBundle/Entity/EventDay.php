<?php

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class EventDay
{
    /**
     * @var Event
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="eventDays")
     * @ORM\JoinColumn(name="event_id", nullable=false)
     */
    protected $event;

    /**
     * @ORM\Id
     * @ORM\Column(type="smallint")
     */
    protected $day;

    ###

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
     * @return int|null
     */
    public function getDay(): ?int
    {
        return $this->day;
    }

    /**
     * @param int $day
     */
    public function setDay(int $day)
    {
        $this->day = $day;
    }
}