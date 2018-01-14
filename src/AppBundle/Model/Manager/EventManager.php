<?php

namespace AppBundle\Model\Manager;

use AppBundle\Entity\Employee;
use AppBundle\Entity\Event;
use AppBundle\Entity\Schedule;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class EventManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var EntityRepository
     */
    private $evRepo;

    /**
     * EmployeeManager constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->evRepo = $entityManager->getRepository(Event::class);
    }

    /**
     * @param Employee                     $employee
     * @param Schedule|null                $schedule
     * @param Event[]|ArrayCollection|null $events
     *
     * @return Event[]|ArrayCollection
     */
    public function findByEmployeeAndSchedule(
        Employee $employee, Schedule $schedule = null, $events = null)
    {
        $employeeId = $employee->getId();
        $scheduleId = null;
        $criteria = ['employee' => $employeeId];

        if (!is_null($schedule)) {
            $scheduleId = $schedule->getId();
            $criteria['schedule'] = $scheduleId;
        }
        if (is_null($events)) {
            return $this->evRepo->findBy($criteria);
        }

        $result = new ArrayCollection();
        foreach ($events as $event) {
            $evEmployee = $event->getEmployee();
            $evSchedule = $event->getSchedule();
            if ($evEmployee->getId() === $employeeId
                && $evSchedule->getId() === $scheduleId) {
                $result[] = $event;
            }
        }

        return $result;
    }
}
