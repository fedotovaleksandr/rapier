<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class EmployeeDay
{
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
    public function setEndDate(?\DateTimeInterface $endTime)
    {
        $this->endTime = $endTime;
    }
}
