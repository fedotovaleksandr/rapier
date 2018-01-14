<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Employee;
use AppBundle\Entity\Event;
use AppBundle\Entity\EventLog;
use AppBundle\Entity\Role;
use AppBundle\Entity\Schedule;
use AppBundle\Entity\User;
use AppBundle\Model\Manager\EventManager;
use AppBundle\Util\EventUtil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TestDataFixture extends Fixture implements ContainerAwareInterface
{
    /**
     * @var ObjectManager
     */
    private $entityManager;

    /**
     * @var EventManager
     */
    private $evManager;

    /**
     * Necessary to load fixture with custom services.yml.
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * Necessary to load fixture with custom services.yml.
     *
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param array|\ArrayAccess $a
     *
     * @return mixed
     */
    private static function rndElem($a)
    {
        return $a[random_int(0, count($a) - 1)];
    }

    /**
     * @return string
     */
    private static function rndPass()
    {
        $nBytes = 6;
        //return base64_encode(random_bytes($nBytes));
        return (string) random_int(10 ** ($nBytes - 1), 10 ** $nBytes - 1);
    }

    /**
     * @param string             $unit
     * @param \DateTimeInterface $start
     * @param \DateTimeInterface $end
     *
     * @return \DateTimeInterface[]
     */
    private static function getDatesPool(string $unit, \DateTimeInterface $start, \DateTimeInterface $end)
    {
        return iterator_to_array(new \DatePeriod(
            $start, new \DateInterval($unit), $end));
    }

    /**
     * @param EventManager $evManager
     */
    public function __construct(EventManager $evManager)
    {
        $this->evManager = $evManager;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $entityManager)
    {
        // *** Employees, roles & schedules ***
        $this->entityManager = $entityManager;
        $evManager = $this->evManager;
        $employees = $this->generateEmployees();
        $schedules = $this->generateSchedules();
        $entityManager->flush();
        $nScheds = count($schedules);

        $nEventsPerSched = 15;
        $workStart = new \DateTime();
        $workStart->setTime(8, 0);
        $hours = self::getDatesPool('PT1H',
            clone $workStart, $workStart->modify('+12 hour'));

        // *** Events & event logs ***
        for ($k = 0; $k < $nScheds; ++$k) {
            $sched = $schedules[$k];
            $schedStart = $sched->getStartDate();
            $schedEnd = $sched->getEndDate();
            $schedDays = self::getDatesPool('P1D',
                $schedStart, $schedEnd);

            for ($i = 0; $i < $nEventsPerSched; ++$i) {
                // Title, owner, responsible, role, period
                $event = new Event();
                $employee = self::rndElem($employees);
                $event->setTitle($sched->getTitle().' Event #'.$i);
                $event->setOwner($employee);
                $event->setEmployee($employee);
                $event->setRole($employee->getRoles()[0]);
                $event->setPeriod(Event::PERIOD_ONCE);

                // Start timestamp & duration
                do {
                    $startDate = self::rndElem($schedDays);
                    $startTime = self::rndElem($hours);
                    $startHour = (int) $startTime->format('H');
                    $startMin = (int) $startTime->format('i');

                    $startDate->setTime($startHour, $startMin);
                    $event->setStartDate($startDate);
                    $duration = self::rndElem([30, 45, 60, 75, 90]);
                    $event->setDuration($duration);

                    // Check if time overlaps exist
                    $overlapIntervals = [];
                    $empSchedEvents =
                        $evManager->findByEmployeeAndSchedule($employee, $sched);
                    EventUtil::getOverlapIntervals(
                        $event, $empSchedEvents, $overlapIntervals);
                } while (!empty($overlapIntervals));

                // Creation date
                $schedBeforeStart = (clone $schedStart)->modify('-1 day');
                $event->setCreationDate(self::rndElem(self::getDatesPool('P1D',
                    $schedBeforeStart, $startDate)));

                // Deadline, importance, status
                $event->setDeadLine((clone $startDate)
                    ->modify('+'.$duration.' minute'));
                $event->setImportance(self::rndElem(
                    [Event::WT_MINOR, Event::WT_MEDIUM, Event::WT_MAJOR, Event::WT_CRITICAL]));
                $event->setStatus(Event::STATUS_OPEN);

                $this->generateEventLogs($i, $event, $employee);
                $sched->addEvent($event);
                $entityManager->persist($event);
                $entityManager->flush();
            }
        }

        $entityManager->flush();
    }

    /**
     * @return Employee[]
     */
    private function generateEmployees()
    {
        // *** Last names (A., B., C., ...) ***
        $LNAMES = array_map(function ($letter) {
            return $letter.'.';
        }, range('A', 'Z'));

        $passEncoder = $this->container->get('security.password_encoder');
        $emails = [];

        // *** Employees ***
        $nEmployees = 5;
        for ($i = 0; $i < $nEmployees; ++$i) {
            // User name & pass
            $user = new User();
            $pass = self::rndPass();
            $user->setUsername('hero'.$i);
            $user->setPassword($passEncoder->encodePassword($user, $pass));
            $user->setEnabled(true);

            // Unique e-mail
            $email = self::rndElem(self::EMAILS);
            if (in_array($email, $emails)) {
                $email = 'noreply'.$i.'@localhost';
            } else {
                $emails[] = $email;
            }
            $user->setEmail($email);

            // Remaining data
            $employee = new Employee();
            $firstName = self::rndElem(array_keys(self::NAMES));
            $employee->setFirstName($firstName);
            $employee->setLastName(self::rndElem($LNAMES));
            $employee->setGender(self::NAMES[$firstName]);
            $employee->setPhone((string) random_int(9990000, 9991111));
            $employee->setWorkMode(0);

            // Saving an employee
            $employee->setUser($user);
            $this->entityManager->persist($employee);
            echo $user->getUsername().':'.$pass."\n";
        }
        $this->entityManager->flush();

        // *** Roles ***
        $nRoles = count(self::ROLES);
        $roles = [];
        for ($i = 0; $i < $nRoles; ++$i) {
            $role = new Role();
            $role->setRoleName(self::ROLES[$i]);
            $role->setDescription(self::ROLES[$i].' (role #'.$i);
            $this->entityManager->persist($role);
            $roles[] = $role;
        }

        // *** Employee/role mapping ***
        $employeeRep = $this->entityManager->getRepository(Employee::class);
        $employees = $employeeRep->findAll();
        for ($i = 0; $i < $nEmployees; ++$i) {
            $employees[$i]->addRole(self::rndElem($roles));
        }

        $this->entityManager->flush();

        return $employees;
    }

    /**
     * @return Schedule[]
     */
    private function generateSchedules()
    {
        $sched1 = new Schedule();
        $sched1->setTitle('February, 2018');
        $sched1->setDescription('All tasks during February, 2018');
        $sched1->setStartDate(new \DateTime('2018/02/01'));
        $sched1->setEndDate(new \DateTime('2018/03/01'));
        $this->entityManager->persist($sched1);

        $sched2 = new Schedule();
        $sched2->setTitle('March, 2018');
        $sched2->setDescription('All tasks during March, 2018');
        $sched2->setStartDate(new \DateTime('2018/03/01'));
        $sched2->setEndDate(new \DateTime('2018/04/01'));
        $this->entityManager->persist($sched2);

        return [$sched1, $sched2];
    }

    /**
     * @param int      $i
     * @param Event    $event
     * @param Employee $employee
     */
    private function generateEventLogs(int $i, Event $event, Employee $employee)
    {
        if (0 != $i % 4) {
            $eventLog = new EventLog();
            $eventLog->setEmployee($employee);
            $eventLog->setAction(EventLog::ACTION_TOGGLE);
            $eventLog->setOldStatus(Event::STATUS_OPEN);
            $eventLog->setNewStatus(Event::STATUS_WORK);
            $eventLog->setDuration(0);

            $startDate = $event->getStartDate();
            $startTime = self::rndElem(self::getDatesPool(
                'PT1H',
                (clone $startDate)->modify('-3 hour'),
                (clone $startDate)->modify('+3 hour')));
            $eventLog->setStartTime($startTime);

            $eventLog->setTimeInstant(self::rndElem(self::getDatesPool(
                'PT1H',
                $startTime,
                (clone $startTime)->modify('+3 hour'))));

            $eventLog->setTitle($event->getTitle().' WORK');
            $event->setStatus(Event::STATUS_WORK);
            $event->addEventLog($eventLog);

            if (0 != $i % 3) {
                $eventLog = new EventLog();
                $eventLog->setEmployee($employee);
                $eventLog->setAction(EventLog::ACTION_TOGGLE);
                $eventLog->setOldStatus(Event::STATUS_WORK);
                $eventLog->setNewStatus(Event::STATUS_FINISH);
                $duration = $event->getDuration();
                $duration = random_int(
                    $duration - 30, $duration + 30);
                $eventLog->setDuration($duration);

                $startTime->modify('+'.$duration.' minute');
                $eventLog->setTimeInstant(self::rndElem(self::getDatesPool(
                    'PT1H',
                    clone $startTime,
                    $startTime->modify('+3 hour'))));

                $eventLog->setTitle(
                    $event->getTitle().' FINISH IN '
                    .$eventLog->getDuration().' min');
                $event->setStatus(Event::STATUS_FINISH);
                $event->addEventLog($eventLog);
            }
        }
    }

    private const DT_FMT = 'Y/m/d H:i';

    private const NAMES = [
        'Sergey' => 'M',
        'Daniel' => 'M',
        'Alex' => 'M',
        'James' => 'M',
        'Oscar' => 'M',
        'Henry' => 'M',
        'Victor' => 'M',
        'Laura' => 'F',
        'Nadine' => 'F',
        'Lisa' => 'F',
        'Eve' => 'F',
        'Helen' => 'F',
    ];

    private const EMAILS = [
        'serge2nd@yandex.ru',
        'manifest321@yandex.ru',
        'itip1515@yandex.ru',
        'serge2th@gmail.com',
        'serge2nd.spb@gmail.com',
        'xtn_l@mail.ru',
        '172436@niuitmo.ru',
        'dany007_93@mail.ru',
    ];

    private const ROLES = [
        'Admin',
        'Manager',
        'Analyst',
        'Architect',
        'Developer',
        'Tester',
        'Designer',
        'Tech Support',
    ];
}
