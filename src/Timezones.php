<?php

namespace MBarlow\Timezones;

use DateTime;
use DateTimeZone;

class Timezones
{
    /**
     * convert the given DateTime into UTC timezone
     *
     * @param DateTime|string $dateTime
     * @param DateTimeZone|string|null $tz
     * @param string $format
     * @return string
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function convertToUTC($dateTime, $tz = null, $format = 'Y-m-d H:i:s')
    {
        if (! ($dateTime instanceof DateTime)) {
            if (is_null($tz)) {
                throw new \InvalidArgumentException(
                    '$Timezone must be defined when $DateTime is not an instance of DateTime'
                );
            }

            if (is_string($tz)) {
                $tz = new DateTimeZone($tz);
            }

            if (! ($tz instanceof DateTimeZone)) {
                throw new \InvalidArgumentException(
                    'A valid DateTimeZone object could not be loaded'
                );
            }

            $dateTime = new DateTime(
                $dateTime,
                $tz
            );
        }

        $dateTime->setTimezone(
            new DateTimeZone('UTC')
        );

        return $dateTime->format($format);
    }

    /**
     * convert the given DateTime into local Timezone from UTC
     *
     * @param DateTime|string $dateTime
     * @param DateTimeZone|string|null $tz
     * @param string $format
     * @return string
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function convertToLocal($dateTime, $tz, $format = 'Y-m-d H:i:s')
    {
        if (is_string($tz)) {
            $tz = new DateTimeZone($tz);
        }

        if (! ($tz instanceof DateTimeZone)) {
            throw new \InvalidArgumentException(
                'A valid DateTimeZone object could not be loaded'
            );
        }

        if (! ($dateTime instanceof DateTime)) {
            $dateTime = new DateTime(
                $dateTime,
                new \DateTimeZone('UTC')
            );
        }

        $dateTime->setTimezone(
            $tz
        );

        return $dateTime->format($format);
    }
}
