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
     * @var Event[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="Event", mappedBy="schedule")
     */
    protected $events;

    ###

    public function __construct()
    {
        $this->events = new ArrayCollection();
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
     * @return ArrayCollection
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
}
