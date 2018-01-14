<?php

namespace AppBundle\Util;

use AppBundle\Entity\Event;
use Doctrine\Common\Collections\ArrayCollection;

class EventUtil
{
    private function __construct()
    {
    }

    /**
     * @param Event                   $newEvent
     * @param Event[]|ArrayCollection $existingEvents
     * @param array                   $intervals
     */
    public static function getOverlapIntervals(Event $newEvent, $existingEvents, array &$intervals)
    {
        $busyIntervals = [];
        $eventIntervals = [];

        foreach ($existingEvents as $event) {
            self::getIntervals($event, $busyIntervals);
        }
        self::getIntervals($newEvent, $eventIntervals);
        $eventIntervals = array_values($eventIntervals)[0];

        foreach ($busyIntervals as $eventUid => $evBusyIntervals) {
            foreach ($evBusyIntervals as $busyInterval) {
                foreach ($eventIntervals as $eventInterval) {
                    if (DTUtil::isOverlap($busyInterval[0], $busyInterval[1],
                        $eventInterval[0], $eventInterval[1])) {
                        if (!array_key_exists($eventUid, $intervals)) {
                            $intervals[$eventUid] = [];
                        }
                        $intervals[$eventUid][] = $busyInterval;
                    }
                }
            }
        }
    }

    /**
     * @param Event $event
     * @param array &$intervals
     */
    public static function getIntervals(Event $event, array &$intervals)
    {
        $startDate = $event->getStartDate();
        $status = $event->getStatus();
        $duration = $event->getDuration();
        if (is_null($startDate) || 0 === $duration
            || Event::STATUS_DRAFT === $status) {
            return;
        }

        $period = $event->getPeriod();
        switch ($period) {
        case Event::PERIOD_ONCE:
            self::getIntervalsPeriodOnce($event, $intervals);
            break;
        case Event::PERIOD_DAY: break; // TODO
        case Event::PERIOD_WEEK: break;
        case Event::PERIOD_BIWEEK: break;
        case Event::PERIOD_MONTH: break;
        }
    }

    /**
     * @param Event $event
     * @param array $intervals
     */
    public static function getIntervalsPeriodOnce(Event $event, array &$intervals)
    {
        $duration = $event->getDuration();
        $startTime = $event->getStartDate();
        $endTime = (clone $startTime)
            ->modify('+'.$duration.' minute');

        $eventUid = spl_object_hash($event);
        if (!array_key_exists($eventUid, $intervals)) {
            $intervals[$eventUid] = [];
        }
        $intervals[$eventUid][] = [$startTime, $endTime];
    }
}
