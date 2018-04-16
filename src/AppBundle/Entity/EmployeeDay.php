<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class EmployeeDay
{
    public const MON = 0;
    public const TUE = 1;
    public const WED = 2;
    public const THU = 3;
    public const FRI = 4;
    public const SAT = 5;
    public const SUN = 6;

    const DAY_TITLES = [
        self::MON => 'monday',
        self::TUE => 'tuesday',
        self::WED => 'wednesday',
        self::THU => 'thursday',
        self::FRI => 'friday',
        self::SAT => 'saturday',
        self::SUN => 'sunday',
    ];

    private const FMT = 'H:i';

    /**
     * @var Employee
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="employeeDays")
     * @ORM\JoinColumn(name="employee_id", nullable=false)
     */
    protected $employee;

    /**
     * @ORM\Id
     * @ORM\Column(type="smallint")
     */
    protected $day;

    /**
     * @var \DateTimeInterface|null
     * @ORM\Column(type="time", nullable=true)
     */
    protected $startTime;

    /**
     * @var \DateTimeInterface|null
     * @ORM\Column(type="time", nullable=true)
     */
    protected $endTime;

    // *** //

    /**
     * @param int $day
     */
    public function __construct(int $day = null)
    {
        $this->day = $day;
    }

    public function __toString()
    {
        return implode(' ', [$this->day,
            date_format($this->startTime, self::FMT),
            date_format($this->endTime, self::FMT),
        ]);
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

    /**
     * @return \DateTimeInterface|null
     */
    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    /**
     * @param \DateTimeInterface|null $startTime
     */
    public function setStartTime(?\DateTimeInterface $startTime)
    {
        $this->startTime = $startTime;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    /**
     * @param \DateTimeInterface|null $endTime
     */
    public function setEndTime(?\DateTimeInterface $endTime)
    {
        $this->endTime = $endTime;
    }

    public function getDayTitle()
    {
        return self::DAY_TITLES[$this->day];
    }
}
