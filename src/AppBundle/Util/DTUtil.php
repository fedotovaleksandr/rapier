<?php
namespace AppBundle\Util;
use Psr\Log\InvalidArgumentException;

class DTUtil
{
    private const DT_FMT = 'Y/m/d H:i';
    private function __construct() {}

    /**
     * @param \DateTimeInterface $start1
     * @param \DateTimeInterface $end1
     * @param \DateTimeInterface $start2
     * @param \DateTimeInterface $end2
     *
     * @return bool
     */
    public static function isOverlap(
        \DateTimeInterface $start1, \DateTimeInterface $end1,
        \DateTimeInterface $start2, \DateTimeInterface $end2)
    {
        self::checkValidInterval($start1, $end1);
        self::checkValidInterval($start2, $end2);

        return $start1 < $end2 && $end1 > $start2;
    }

    /**
     * @param \DateTimeInterface $start
     * @param \DateTimeInterface $end
     * @param \DateTimeInterface $innerStart
     * @param \DateTimeInterface $innerEnd
     *
     * @return bool
     */
    public static function isIn(
        \DateTimeInterface $start, \DateTimeInterface $end,
        \DateTimeInterface $innerStart, \DateTimeInterface $innerEnd)
    {
        self::checkValidInterval($start, $end);
        self::checkValidInterval($innerStart, $innerEnd);

        return $start <= $innerStart && $innerEnd <= $end;
    }

    /**
     * @param \DateTimeInterface $start
     * @param \DateTimeInterface $end
     * @param bool $returns if true, return false instead of
     *                      throwing an exception
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public static function checkValidInterval(
        \DateTimeInterface $start, \DateTimeInterface $end,
        bool $returns = false)
    {
        $valid = $start <= $end;
        if ($valid)
            return true;

        if (!$returns) {
            throw new InvalidArgumentException(
                'interval is invalid (start > end): '
                .self::formatInterval($start, $end)
            );
        }

        return false;
    }

    /**
     * @param \DateTimeInterface $start
     * @param \DateTimeInterface $end
     * @param string $fmt
     *
     * @return string
     */
    public static function formatInterval(
        \DateTimeInterface $start, \DateTimeInterface $end,
        string $fmt = self::DT_FMT)
    {
        return '('.$start->format($fmt)
            .', '.$end->format($fmt).')';
    }
}